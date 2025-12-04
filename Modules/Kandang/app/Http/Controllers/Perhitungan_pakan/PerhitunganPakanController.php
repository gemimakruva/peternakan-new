<?php

namespace Modules\Kandang\Http\Controllers\Perhitungan_pakan;

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
        'pemberianPakanSisaPakan', 
        'pipe.flock.kandang'
    ])->latest();

     if ($request->filled('tanggal')) {
        $query->where('id', $request->tanggal);
    }

    if ($request->filled('kandang')) {
        $query->whereHas('pipe.flock.kandang',
         function($q) use ($request) {
            $q->where('id', $request->kandang);
        });
    }

    if ($request->filled('flock')) {
        $query->whereHas('pipe.flock', function($q) use ($request) {
            $q->where('id', $request->flock); 
        });
    }

   if ($request->filled('jenis_pakan')) {
        $query->whereHas('jenis_pakan', function($q) use ($request) {
            $q->where('nama', $request->jenis_pakan);
        });
    }

    $perhitunganPakan = $query->get();
    $jenisPakanList = JenisPakan::all();

    // dd($perhitunganPakan);

    return view('kandang::perhitungan-pakan.index', compact('perhitunganPakan','jenisPakanList'));
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
             return redirect()->back()->with('success',
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerhitunganPakan $perhitunganPakan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerhitunganPakan $perhitunganPakan)
    {
        //
    }

    public function createSisaPakan()
    {
        return view("kandang::sisa-pakan.create");
    }

   public function storeSisaPakan(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'tanggal'      => 'required|exists:perhitungan_pakan,id',
                'pemberian_pakan'  => 'required|numeric|min:0',
                'sisa_pakan'      => 'required|numeric|min:0',
            ]);
            
                PemberianPakanSisaPakan::create([
                    'perhitungan_pakan_id' => $validated["tanggal"],
                    'pemberian_pakan_flock_kg' => $validated['pemberian_pakan'],
                    'sisa_pakan_per_flock' => $validated["sisa_pakan"]
                ]);
            return redirect()
                ->back()
                ->with('success', 'Data pemberian & 
                            sisa pakan berhasil disimpan!');
            } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi!');
        };
    }
}
