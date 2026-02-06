<?php
namespace Modules\Kandang\Http\Controllers\RecordingTelur;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\ProduksiTelur;
use Modules\Kandang\Models\ProduksiTelurItem;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Services\PopulasiAyamService;

class RecordingTelurController extends Controller
{
    public function __construct(
        private ProduksiTelur $produksiTelur,
        private ProduksiTelurItem $produksiTelurItem,
        private KandangRepository $kandangRepository,
        private PopulasiAyamService $populasiAyamService,
    ) { }
    
    public function index(Request $request)
    {
        $listProduksiTelur = $this->produksiTelur
            ->with(['picUser', 'produksiTelurItems'])
            ->when($request->filled('kandang_id'), function($query) use ($request) {
                $query->where('kandang_id', $request->kandang_id);
            })
            ->when($request->filled('tanggal_mulai'), function($query) use ($request) {
                $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
            })
            ->when($request->filled('tanggal_selesai'), function($query) use ($request) {
                $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
            })
            ->when($request->filled('recorded_by'), function($query) use ($request) {
                $query->whereHas('picUser', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->recorded_by . '%');
                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate($request->query('perPage', 10));
        
        $listKandang = $this->kandangRepository->getModel()->pluck('nama', 'id')->toArray();

        return view("kandang::recording-telur.index", compact('listProduksiTelur', 'listKandang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {
        $listKandang = $this->kandangRepository->getModel()->pluck('nama', 'id')->toArray();

        return view("kandang::recording-telur.create", compact('listKandang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'   => [
                'required', 
                'date',
                'unique:produksi_telur,tanggal,NULL,id,kandang_id,' . $request->kandang_id
            ],
            'kandang_id' => ['required', 'exists:kandang,id'],
        ], [
            'tanggal.unique' => 'Data produksi telur untuk tanggal dan flock ini sudah ada.'
        ]);

        $validated['umur_ayam'] = $this->populasiAyamService->getUmurAyamByKandangId(
            $validated['kandang_id'], 
            $request->date('tanggal')
        )['umur_ayam'];

        $validated['pic_user_id'] = auth()->id();

        try{
            $produksiTelur = $this->produksiTelur->create($validated);

            return to_route('recording-telur.edit', $produksiTelur->id)
                ->with('success', 'Data Berhasil Ditambahkan.');   
                
        }catch(\Exception $e){
            return to_route('recording-telur.index')
                ->with('danger', 'Data Gagal Ditambahkan. Error: '.$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produksiTelur = $this->produksiTelur
            ->with([
                'kandang.flocks',
                'produksiTelurItems',
            ])
            ->findOrFail($id);

        if ($produksiTelur->produksiTelurItems->count() === 0) {
            foreach ($produksiTelur->kandang->flocks as $flock) {
                $items[$flock->id] = [
                    'nama_flock'            => $flock->nama,
                    'flock_id'              => $flock->id,
                    'jumlah_telur_bagus'    => 0,
                    'jumlah_telur_putih'    => 0,
                    'jumlah_telur_reject'   => 0,
                    'berat_telur_bagus'     => 0,
                    'berat_telur_putih'     => 0,
                    'berat_telur_reject'    => 0,
                ];
            }
        } else {
            foreach ($produksiTelur->produksiTelurItems as $item) {
                $items[$item->flock_id] = $item->toArray();
                $items[$item->flock_id]['nama_flock'] = $item->flock->nama;
            }
        }

        $listKandang = $this->kandangRepository->getModel()->pluck('nama', 'id')->toArray();

        return view('kandang::recording-telur.edit', compact(['listKandang', 'produksiTelur', 'items']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produksiTelur = $this->produksiTelur->findOrFail($id);

        $request->validate([
            'tanggal'   => [
                'required', 
                'date',
                'unique:produksi_telur,tanggal,' . $id . ',id,kandang_id,' . $produksiTelur->kandang_id
            ],
            'items'                         => ['required', 'array'],
            'items.*.flock_id'                 => ['required', 'numeric', 'exists:flock,id'],
            'items.*.jumlah_telur_bagus'    => ['required', 'numeric'],
            'items.*.berat_telur_bagus'     => ['required', 'numeric'],
            'items.*.jumlah_telur_putih'    => ['required', 'numeric'],
            'items.*.berat_telur_putih'     => ['required', 'numeric'],
            'items.*.jumlah_telur_reject'   => ['required', 'numeric'],
            'items.*.berat_telur_reject'    => ['required', 'numeric'],
        ], [
            'tanggal.unique' => 'Data produksi telur untuk tanggal dan flock ini sudah ada.'
        ]);

        $validated['umur_ayam'] = $this->populasiAyamService->getUmurAyamByKandangId(
            $produksiTelur->kandang_id, 
            $request->date('tanggal')
        )['umur_ayam'];

        $validated['pic_user_id'] = auth()->id();

        DB::beginTransaction();
        try{
            $produksiTelur->fill($validated);
            $produksiTelur->save();

            foreach ($request->input('items') as $item) {
                $this->produksiTelurItem->updateOrCreate([
                    'produksi_telur_id'     => $produksiTelur->id,
                    'kandang_id'            => $produksiTelur->kandang_id,
                    'tanggal'               => $produksiTelur->tanggal,
                    'flock_id'              => $item['flock_id'],
                ], [
                    'jumlah_telur_bagus'    => $item['jumlah_telur_bagus'],
                    'jumlah_telur_putih'    => $item['jumlah_telur_putih'],
                    'jumlah_telur_reject'   => $item['jumlah_telur_reject'],
                    'berat_telur_bagus'     => $item['berat_telur_bagus'],
                    'berat_telur_putih'     => $item['berat_telur_putih'],
                    'berat_telur_reject'    => $item['berat_telur_reject'],
                ]);
            }            

            DB::commit();
            return to_route('recording-telur.index')
                ->with('success', 'Data Berhasil Diupdate.');                   
        }catch(\Exception $e){
            DB::rollBack();
            return to_route('recording-telur.index')
                ->with('danger', 'Data Gagal Diupdate. Error: '.$e->getMessage());
        }
    }
}
