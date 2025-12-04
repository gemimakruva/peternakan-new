<?php
namespace Modules\Kandang\Http\Controllers\RecordingTelur;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\ProduksiTelur;

class RecordingTelurController extends Controller
{
    public function __construct(
        private ProduksiTelur $produksiTelur,
    ) { }
    
    public function index(Request $request)
    {
        $listProduksiTelur = $this->produksiTelur
            ->with('flock.kandang', 'picUser')
            ->when($request->filled('kandang_id'), function($query) use ($request) {
                $query->whereHas('flock', function($q) use ($request) {
                    $q->where('kandang_id', $request->kandang_id);
                });
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
            ->paginate(2);
        
        $listKandang = Kandang::all();
        return view("kandang::recording-telur.index", compact('listProduksiTelur', 'listKandang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {
        return view("kandang::recording-telur.create");
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
                'unique:produksi_telur,tanggal,NULL,id,flock_id,' . $request->flock_id
            ],
            'flock_id' => ['required', 'integer'],
            'usia_ayam' => ['required', 'integer'],
            'jumlah_telur_bagus'   => ['required', 'numeric'],
            'berat_telur_bagus'   => ['required', 'numeric'],
            'jumlah_telur_putih'   => ['required', 'numeric'],
            'berat_telur_putih'   => ['required', 'numeric'],
            'jumlah_telur_reject'   => ['required', 'numeric'],
            'berat_telur_reject'   => ['required', 'numeric'],
        ], [
            'tanggal.unique' => 'Data produksi telur untuk tanggal dan baris ini sudah ada.'
        ]);
        $validated['pic_user_id'] = Auth::id();

        try{

            $create = $this->produksiTelur->create($validated);

            return to_route('recording-telur.index')
                ->with('success', 'Data Berhasil Ditambahkan.');   
                
        }catch(\Exception $e){
            return to_route('recording-telur.index')
            ->with('danger', 'Data Gagal Ditambahkan. Error: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PopulasiAyam $populasiAyam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produksiTelur = $this->produksiTelur->with('flock.kandang')->findOrFail($id);
        return view('kandang::recording-telur.edit', compact('produksiTelur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal'   => [
                'required', 
                'date',
                'unique:produksi_telur,tanggal,' . $id . ',id,flock_id,' . $request->flock_id
            ],
            'flock_id' => ['required', 'integer'],
            'usia_ayam' => ['required', 'integer'],
            'jumlah_telur_bagus'   => ['required', 'numeric'],
            'berat_telur_bagus'   => ['required', 'numeric'],
            'jumlah_telur_putih'   => ['required', 'numeric'],
            'berat_telur_putih'   => ['required', 'numeric'],
            'jumlah_telur_reject'   => ['required', 'numeric'],
            'berat_telur_reject'   => ['required', 'numeric'],
        ], [
            'tanggal.unique' => 'Data produksi telur untuk tanggal dan baris ini sudah ada.'
        ]);

        try{
            $produksiTelur = $this->produksiTelur->findOrFail($id);
            $produksiTelur->update($validated);

            return to_route('recording-telur.index')
                ->with('success', 'Data Berhasil Diupdate.');   
                
        }catch(\Exception $e){
            return to_route('recording-telur.index')
            ->with('danger', 'Data Gagal Diupdate. Error: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $produksiTelur = $this->produksiTelur->findOrFail($id);
            $produksiTelur->delete();

            return to_route('recording-telur.index')
                ->with('success', 'Data Berhasil Dihapus.');   
                
        }catch(\Exception $e){
            return to_route('recording-telur.index')
            ->with('danger', 'Data Gagal Dihapus. Error: '.$e->getMessage());
        }
    }
}
