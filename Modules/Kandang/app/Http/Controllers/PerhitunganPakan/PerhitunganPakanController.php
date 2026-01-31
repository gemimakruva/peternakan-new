<?php

namespace Modules\Kandang\Http\Controllers\PerhitunganPakan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Models\PerhitunganPakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Kandang\Models\JenisPakan;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PemberianPakanSisaPakan;
use Modules\Kandang\Models\PerhitunganPakanItem;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Repositories\Pakan\PerhitunganPakanRepository;
use Modules\Kandang\Services\Pakan\PerhitunganPakanService;

class PerhitunganPakanController extends Controller
{
    public function __construct(
        private PerhitunganPakanRepository $repository,
        private PerhitunganPakanService $service,
        private PerhitunganPakanItem $perhitunganPakanItem,
        private JenisPakan $jenisPakan,
        private Kandang $kandang,
        private User $user,
    ) { }

    public function index(Request $request)
    {
        // columns: tanggal, kandang, petugas pencatatat, petugas pelaksana, jumlah ayam, berat pakan (kg), jenis pakan
        // filters: kandang, jenis_pakan

        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        $listKandang = $this->kandang->pluck('nama', 'id');
        $listJenisPakan = $this->jenisPakan->pluck('nama', 'id');

        return view('kandang::perhitungan-pakan.index', compact(['datas', 'listKandang', 'listJenisPakan']));
    }

    public function create()
    {
        $listKandang = $this->kandang
            ->orderBy('nama')
            ->pluck('nama', 'id');
        $listUser = $this->user
            ->where('id', '<>', auth()->id())
            ->orderBy('name')
            ->pluck('name', 'id');
        $listJenisPakan = $this->jenisPakan
            ->orderBy('nama')
            ->pluck('nama', 'id');

        return view("kandang::perhitungan-pakan.create", compact(['listKandang', 'listUser', 'listJenisPakan']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_pemberian_pakan'   => ['required', 'date'],
            'kandang_id'                => ['required', 'exists:kandang,id'],
            'jenis_pakan_id'            => ['required', 'exists:jenis_pakan,id'],
            'proporsi_pemberian_pagi'   => ['required', 'numeric'],
            'proporsi_pemberian_sore'   => ['required', 'numeric'],
            'waktu_pemberian_pagi'      => ['required', 'date_format:H:i', 'after_or_equal:05:00', 'before_or_equal:09:30'],
            'waktu_pemberian_sore'      => ['required', 'date_format:H:i', 'after_or_equal:15:00', 'before_or_equal:18:30'],
            'user_executor_id'          => ['required', 'exists:users,id'],
            'catatan'                   => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $perhitunganPakan = $this->repository->create([
                'tanggal_pemberian_pakan'   => $validated["tanggal_pemberian_pakan"],
                'kandang_id'                => $validated['kandang_id'],
                'jenis_pakan_id'            => $validated['jenis_pakan_id'],
                'proporsi_pemberian_pagi'   => $validated['proporsi_pemberian_pagi'],
                'proporsi_pemberian_sore'   => $validated['proporsi_pemberian_sore'],
                'waktu_pemberian_pagi'      => $validated['waktu_pemberian_pagi'],
                'waktu_pemberian_sore'      => $validated['waktu_pemberian_sore'],
                'user_creator_id'           => auth()->id(),
                'user_executor_id'          => $validated['user_executor_id'],
                'catatan'                   => $validated['catatan']
            ]);
            
            return redirect()->route('perhitungan-pakan.edit', $perhitunganPakan)
                ->with('success', 'Data Perhitungan Pakan berhasil disimpan!');
        } catch (\Throwable $th) {
            Log::error('Store method failed', [
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PerhitunganPakan $perhitunganPakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerhitunganPakan $perhitunganPakan)
    {
        [$data, $initialState] = $this->service->getTableInitialState($perhitunganPakan);

        $listKandang = $this->kandang
            ->orderBy('nama')
            ->pluck('nama', 'id');
        $listUser = $this->user
            ->where('id', '<>', auth()->id())
            ->orderBy('name')
            ->pluck('name', 'id');
        $listJenisPakan = $this->jenisPakan
            ->orderBy('nama')
            ->pluck('nama', 'id');

        return view("kandang::perhitungan-pakan.edit", compact([
            'data',
            'initialState',
            'listKandang',
            'listUser',
            'listJenisPakan',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerhitunganPakan $perhitunganPakan)
    {
        $validated = $request->validate([
            'tanggal_pemberian_pakan'   => ['required', 'date'],
            'kandang_id'                => ['required', 'exists:kandang,id'],
            'jenis_pakan_id'            => ['required', 'exists:jenis_pakan,id'],
            'proporsi_pemberian_pagi'   => ['required', 'numeric'],
            'proporsi_pemberian_sore'   => ['required', 'numeric'],
            'waktu_pemberian_pagi'      => ['required', 'date_format:H:i:s', 'after_or_equal:05:00:00', 'before_or_equal:09:30:00'],
            'waktu_pemberian_sore'      => ['required', 'date_format:H:i:s', 'after_or_equal:15:00:00', 'before_or_equal:18:30:00'],
            'user_executor_id'          => ['required', 'exists:users,id'],
            'catatan'                   => ['nullable', 'string', 'max:500'],
            'items'                             => ['required', 'array'],
            'items.*.id'                        => ['nullable', 'integer'],
            'items.*.perhitungan_pakan_id'      => ['required', 'integer', 'exists:perhitungan_pakan,id'],
            'items.*.kandang_id'                => ['required', 'integer', 'exists:kandang,id'],
            'items.*.flock_id'                  => ['required', 'integer', 'exists:flock,id'],
            'items.*.pipe_id'                   => ['required', 'integer', 'exists:pipe,id'],
            'items.*.jumlah_ayam'               => ['required', 'integer', 'min:0'],
            'items.*.pemberian_pakan_per_ekor'  => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            $perhitunganPakan->fill([
                'tanggal_pemberian_pakan'   => $validated["tanggal_pemberian_pakan"],
                'kandang_id'                => $validated['kandang_id'],
                'jenis_pakan_id'            => $validated['jenis_pakan_id'],
                'proporsi_pemberian_pagi'   => $validated['proporsi_pemberian_pagi'],
                'proporsi_pemberian_sore'   => $validated['proporsi_pemberian_sore'],
                'waktu_pemberian_pagi'      => $validated['waktu_pemberian_pagi'],
                'waktu_pemberian_sore'      => $validated['waktu_pemberian_sore'],
                'user_creator_id'           => auth()->id(),
                'user_executor_id'          => $validated['user_executor_id'],
                'catatan'                   => $validated['catatan']
            ]);
            $perhitunganPakan->save();

            foreach ($validated['items'] as $item) {
                $this->perhitunganPakanItem->updateOrCreate([
                    'id'                        => $item['id'],
                    'perhitungan_pakan_id'      => $item['perhitungan_pakan_id'],
                    'kandang_id'                => $item['kandang_id'],
                    'flock_id'                  => $item['flock_id'],
                    'pipe_id'                   => $item['pipe_id'],
                    'tanggal_pemberian_pakan'   => $validated['tanggal_pemberian_pakan']
                ], [
                    'jumlah_ayam'               => $item['jumlah_ayam'],
                    'pemberian_pakan_per_ekor'  => $item['pemberian_pakan_per_ekor'],
                ]);
            }
           
            DB::commit();
            return back()->with('success', 'Data Perhitungan Pakan berhasil disimpan!');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Store method failed', [
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerhitunganPakan $perhitunganPakan)
    {
        try {
        $perhitunganPakan->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } catch (\Throwable $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: '
         . $e->getMessage());
        }
    }

    public function createSisaPakan()
    {
        $kandang = Kandang::latest()->get();
        $jenisPakan = JenisPakan::latest()->get();
        return view("kandang::sisa-pakan.create", 
        compact('kandang',"jenisPakan"));
    }

   public function storeSisaPakan(Request $request)
{
 
    // Validasi input di luar try-catch
    $validated = $request->validate([
        'tanggal'           => 'required|exists:perhitungan_pakan,tanggal_pemberian_pakan',
        'pemberian_pakan'   => 'required|numeric',
        'sisa_pakan'        => 'required|numeric',
        'flock_id'          => 'required|numeric|exists:flock,id',
        'jenis_pakan_id'    => 'required|numeric|exists:jenis_pakan,id',
    ]);

    try {
        // Ambil tanggal dari model PerhitunganPakan
        $tanggal = $validated['tanggal'] ?? null;
        $tanggalPemberianPakan = PerhitunganPakan::where('tanggal_pemberian_pakan', $tanggal)
        ->first();
        $userId = auth()->id();
        // Simpan data ke tabel pemberian_pakan_sisa_pakan
       PemberianPakanSisaPakan::create([
            'flock_id' => $validated["flock_id"],
            'jenis_pakan_id' => $validated['jenis_pakan_id'],
            'tanggal' => $tanggalPemberianPakan->tanggal_pemberian_pakan,
            'user_executor_id' => $userId,
            'pemberian_pakan_flock_kg' => $validated['pemberian_pakan'],
            'sisa_pakan_per_flock_kg' => $validated["sisa_pakan"],
        ]);


        return redirect()
            ->route('sisa-pakan.listDataSisaPakanHarian')
            ->with('success', 'Data pemberian & sisa pakan berhasil disimpan!');
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->with('error', $e->getMessage());
    }
}

    public function listDataPakanHarian(Request $request)
{
    $kandang = Kandang::latest()->get();

    $query = PerhitunganPakan::with([
        'jenis_pakan',
        'pipe.flock.kandang',
        'pipe.flock.pemberianPakanSisaPakan'
    ])
    ->orderBy('tanggal_pemberian_pakan', 'desc'); // TANGGAL TERBARU

    if ($request->filled('tanggal')) {
        $query->where('tanggal_pemberian_pakan', $request->tanggal);
    }

    if ($request->filled('kandang')) {
        $query->whereHas('pipe.flock', function ($q) use ($request) {
            $q->where('kandang_id', $request->kandang);
        });
    }

    if ($request->filled('petugas_pencatatan')) {
        $query->whereHas('userExecutor', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->petugas_pencatatan . '%');
        });
    }
    $perhitunganPakan = $query->paginate(10)->withQueryString();
    return view("kandang::perhitungan-pakan.listPakanHarian",
        compact('perhitunganPakan', 'kandang')
    );
}


    public function listDataSisaPakanHarian(Request $request)
    {
        $query = PemberianPakanSisaPakan::with([
            'flock.kandang', 'jenisPakan','userExecutor'
        ])->orderBy('tanggal', 'desc'); ;
         if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }
         if ($request->filled('kandang')) {
        $query->whereHas('flock.kandang',
        function ($q) use ($request) {
            $q->where('kandang_id', $request->kandang);
        });
        }

        if ($request->filled('petugas_pencatatan')) {
                    $query->whereHas('userExecutor', function 
                    ($q) use ($request) {
                        $q->where('name', 'like', '%' .
                         $request->petugas_pencatatan . '%');
                    });
            }
            
        $data = $query->paginate(10)->withQueryString();
        $kandang = Kandang::latest()->get();
        return view("kandang::sisa-pakan.listDataSisaPakanHarian",
         compact('kandang','data'));
    }

    public function editSisaPakan($id){
         $data = PemberianPakanSisaPakan::with([
        'flock.kandang',
        'flock.pipes',
        'jenisPakan'
        ])->find($id);
        $kandang = Kandang::latest()->get();
        $jenisPakan = JenisPakan::latest()->get();
         if (!$data) {
        return redirect()->back()->with('error', 'Data sisa pakan tidak ditemukan.');
    }
      return view('kandang::sisa-pakan.edit', compact('data','kandang','jenisPakan'));
    }

    public function deleteSisaPakan($id)
    {
        $data = PemberianPakanSisaPakan::find($id);
        if (!$data) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

     try {
        $data->delete();
        return redirect()->back()->with('success', 'Data sisa pakan berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }

    }

    public function updateSisaPakan(Request $request, $id)
{
    // dd($request);
   $validated = $request->validate([
    'tanggal'         => 'required|date',
    'kandang_id'      => 'required|integer',
    'flock_id'        => 'required|integer',
    'jenis_pakan_id'  => 'required|integer',
    'pemberian_pakan' => 'required|numeric',
    'sisa_pakan'      => 'required|numeric',
]);

    $validated['user_executor_id'] = auth()->id();

    $sisa = PemberianPakanSisaPakan::findOrFail($id);

      $sisa->update([
        'tanggal' => $validated['tanggal'],
        'flock_id' => $validated['flock_id'],
        'jenis_pakan_id' => $validated['jenis_pakan_id'],
        'pemberian_pakan_flock_kg' => $validated['pemberian_pakan'],
        'sisa_pakan_per_flock_kg' => $validated['sisa_pakan'] 
      ]);

    return redirect()
        ->route('sisa-pakan.listDataSisaPakanHarian')
        ->with('success', 'Data sisa pakan berhasil diperbarui.');
}

}
