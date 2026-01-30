<?php

namespace Modules\Kandang\Http\Controllers\PerhitunganPakan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Kandang\Models\PerhitunganPakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Kandang\Models\JenisPakan;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PemberianPakanSisaPakan;
use Modules\Kandang\Models\Pipe;

class PerhitunganPakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $query = PerhitunganPakan::with([
        'jenis_pakan',
        'pipe.flock.kandang',
        'pipe.flock.pemberianPakanSisaPakan'
    ])->latest()
      ->when($request->filled('tanggal'), fn($q) => 
          $q->where('tanggal_pemberian_pakan', $request->tanggal))
      ->when($request->filled('kandang'), fn($q) => 
          $q->whereHas('pipe.flock.kandang', fn($q2) => 
              $q2->where('id', $request->kandang)))
      ->when($request->filled('flock'), fn($q) => 
          $q->whereHas('pipe.flock', fn($q2) => 
              $q2->where('id', $request->flock)))
      ->when($request->filled('jenis_pakan'), fn($q) => 
          $q->whereHas('jenis_pakan', fn($q2) => 
              $q2->where('nama', $request->jenis_pakan)));
    $perhitunganPakan = (clone $query)->paginate(10);
    $perhitunganPakan->appends($request->all()); 
    $allData = $query->get(); 
    $dataKandang = $allData
        ->groupBy(fn($item) => $item->pipe->flock->kandang->id)
        ->map(fn($items) => [
            'kandang_id' => $items->first()->pipe->flock->kandang->id,
            'kandang_nama' => $items->first()->pipe->flock->kandang->nama,
            'total_ayam' => $items->sum('jumlah_ayam_per_pipe'),
            'estimasi_pakan_per_ekor' => $items->avg('jumlah_pakan_per_ekor_gram'),
            'estimasi_pakan_per_pipe' => $items->sum(fn($item)
             => $item->jumlah_ayam_per_pipe * $item->jumlah_pakan_per_ekor_gram / 1000),
            'pemberian_pagi' => $items->avg('proporsi_pemberian_pagi'),
            'pemberian_sore' => $items->avg('proporsi_pemberian_sore'),
        ])
        ->values();
    $jenisPakanList = JenisPakan::all();
    return view('kandang::perhitungan-pakan.index', 
    compact('perhitunganPakan','jenisPakanList','dataKandang'));
}




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUserId = Auth::id();                     
        $Users = User::where('id', '!=',
         $currentUserId)->get(); 
        $listJenisPakan = JenisPakan::all();   
        $listPipe = Pipe::all();

        return view("kandang::perhitungan-pakan.create",
         compact('Users','listJenisPakan','listPipe'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try {
         $validated = $request->validate([
                'tanggal' => ['required', 'date'],
                'pipe_id' => ['required', 'exists:pipe,id'],
                'jenis_pakan_id' => ['required', 'exists:jenis_pakan,id'],
                'jumlah_ayam' => ['required', 'integer', 'min:1'],
                'jumlah_pakan_per_ekor_gram' => ['required', 'numeric', 'min:0'],
                'proporsi_pemberian_pagi' => ['required', 'numeric'],
                'proporsi_pemberian_sore' => ['required', 'numeric'],
                'jam_pemberian_pagi' => ['required', 'date_format:H:i', 'after_or_equal:05:00', 
                'before_or_equal:09:30'],
                'jam_pemberian_sore' => ['required', 'date_format:H:i', 'after_or_equal:15:00',
                 'before_or_equal:18:30'],
                'catatan' => ['nullable', 'string', 'max:500'],
        ]);
         $userId  = Auth::id();
         $executor = User::where('id', '!=', Auth::id())->first();

         $validated['user_creator_id'] = $userId;
         $validated['user_executor_id'] = $executor;

         PerhitunganPakan::create([
            'tanggal_pemberian_pakan' => $validated["tanggal"],
            'user_creator_id' => $userId,
            'user_executor_id' => $executor->id,
            'jenis_pakan_id' => $validated['jenis_pakan_id'],
            'pipe_id' => $validated['pipe_id'],
            'proporsi_pemberian_pagi' => $validated['proporsi_pemberian_pagi'],
            'proporsi_pemberian_sore' => $validated['proporsi_pemberian_sore'],
            'waktu_pemberian_pagi' => $validated['jam_pemberian_pagi'],
             'waktu_pemberian_sore' => $validated['jam_pemberian_sore'],
             'jumlah_ayam_per_pipe' => $validated['jumlah_ayam'],
             'jumlah_pakan_per_ekor_gram' => $validated['jumlah_pakan_per_ekor_gram'],
             'catatan' => $validated['catatan']
         ]);
             return redirect()->route('perhitungan-pakan.listdata')->with('success',
              'Data Perhitungan Pakan berhasil disimpan!');
       }
        catch (\Illuminate\Validation\ValidationException $e) 
       {
             return redirect()->back()
                         ->withErrors($e->errors())
                         ->withInput();
        } 
       catch (\Throwable $th)
        {
            return redirect()->back()
                            ->with('error', 'Terjadi kesalahan: ' 
                            . $th->getMessage())
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
        $currentUserId = Auth::id();                     
        $Users = User::where('id', '!=',
         $currentUserId)->get();
        $perhitunganPakan->load('pipe.flock.kandang'); 
        $data = $perhitunganPakan;
        $listJenisPakan = JenisPakan::all();   
        $listPipe = Pipe::all();
        return view("kandang::perhitungan-pakan.edit",
         compact('Users','listJenisPakan','listPipe','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerhitunganPakan $perhitunganPakan)
    {

         $validated = $request->validate([
                'tanggal' => ['required', 'date'],
                'pipe_id' => ['required', 'exists:pipe,id'],
                'jenis_pakan_id' => ['required', 'exists:jenis_pakan,id'],
                'jumlah_ayam' => ['required', 'integer', 'min:1'],
                'jumlah_pakan_per_ekor_gram' => ['required', 'numeric', 'min:0'],
                'proporsi_pemberian_pagi' => ['required', 'numeric'],
                'proporsi_pemberian_sore' => ['required', 'numeric'],
                'jam_pemberian_pagi' => ['required', 'date_format:H:i', 'after_or_equal:05:00', 
                'before_or_equal:09:30'],
                'jam_pemberian_sore' => ['required', 'date_format:H:i', 'after_or_equal:15:00',
                 'before_or_equal:18:30'],
                'catatan' => ['nullable', 'string', 'max:500'],
        ]);

         $userId  = Auth::id();
         $executor = User::where('id', '!=', Auth::id())->first();
         $validated['user_creator_id'] = $userId;
         $validated['user_executor_id'] = $executor;
        
        try {
            $perhitunganPakan->update([
                 'tanggal_pemberian_pakan' => $validated["tanggal"],
                    'user_creator_id' => $userId,
                    'user_executor_id' => $executor->id,
                    'jenis_pakan_id' => $validated['jenis_pakan_id'],
                    'pipe_id' => $validated['pipe_id'],
                    'proporsi_pemberian_pagi' => $validated['proporsi_pemberian_pagi'],
                    'proporsi_pemberian_sore' => $validated['proporsi_pemberian_sore'],
                    'waktu_pemberian_pagi' => $validated['jam_pemberian_pagi'],
                    'waktu_pemberian_sore' => $validated['jam_pemberian_sore'],
                    'jumlah_ayam_per_pipe' => $validated['jumlah_ayam'],
                    'jumlah_pakan_per_ekor_gram' => $validated['jumlah_pakan_per_ekor_gram'],
                    'catatan' => $validated['catatan']
            ]);
           
            return redirect()
                    ->route('perhitungan-pakan.listdata')
                    ->with('success', 'Data Perhitungan Pakan berhasil disimpan!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data: '
         . $e->getMessage());
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
