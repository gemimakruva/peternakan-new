<?php
namespace Modules\Kandang\Http\Controllers\PopulasiAyam;
use App\Http\Controllers\Controller;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Kandang\Models\Pengadaan_ayam;
class PopulasiAyamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     */

     /**
     * Show the list of pengadaan
     */
    
    public function create()
    {
        $ListPengadaanAyam = Pengadaan_ayam::all();
         return view("kandang::populasi-ayam.list-tanggal-pengadaan",
          compact('ListPengadaanAyam'));
    }
    public function createByDate($pengadaan_ayam)
    {
         $DataPengadaanAyam = Pengadaan_ayam::with([
        'distribusi.kandang', 
        'distribusi.flock',  
        'distribusi.pipe'
    ])->findOrFail($pengadaan_ayam);
    return view('kandang::populasi-ayam.create', compact('DataPengadaanAyam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $populasi = json_decode($request->populasi_record, true);
        $request->merge(['populasi_record' => $populasi]);
        $validated = $request->validate([
            'jenis_pemeriksaan' => ['required', 'string'],
            'tanggal_pencatatan' => ['required', 'date'],
            'pengadaan_ayam_id'=> ['required','integer'],
            'populasi_record' => ['required', 'array'],
            'populasi_record.*.kandang_id'=> ['required', 'integer'],
            'populasi_record.*.flock_id'=> ['required', 'integer'],
            'populasi_record.*.pipe_id'=> ['required', 'integer'],
            'catatan' => ['nullable', 'string', 'max:255'],
            'populasi_record.*.ayam_sehat'=> ['required', 'integer', 'min:0'],
            'populasi_record.*.ayam_mati' => ['required', 'integer', 'min:0'],
            'populasi_record.*.ayam_sakit' => ['required', 'integer', 'min:0'],
            'populasi_record.*.ayam_afkir'=> ['required', 'integer', 'min:0'],
            'populasi_record.*.ayam_masuk_karantina'=> ['required', 'integer', 'min:0'],
            'populasi_record.*.ayam_keluar_karantina' => ['required', 'integer', 'min:0'],
        ]);

        $userid = Auth::id();

        foreach ($validated['populasi_record'] as $row) {
            PopulasiAyam::create([
                'pengadaan_ayam_distribusi_id' => $validated['pengadaan_ayam_id'],
                'jenis_pemeriksaan'     => $validated['jenis_pemeriksaan'],
                'tanggal'               => $validated['tanggal_pencatatan'],
                'pic_user_id'           => $userid,
                'kandang_id'            => $row['kandang_id'],
                'flock_id'              => $row['flock_id'],
                'pipe_id'               => $row['pipe_id'],
                'ayam_mati'             => $row['ayam_mati'],         
                'ayam_sehat'            => $row['ayam_sehat'],
                'ayam_sakit'            => $row['ayam_sakit'],
                'ayam_afkir'            => $row['ayam_afkir'],
                'ayam_masuk_karantina'  => $row['ayam_masuk_karantina'],
                'ayam_keluar_karantina' => $row['ayam_keluar_karantina'],
                'catatan'               => $validated['catatan'] ?? null,
            ]);
        }
         return redirect() ->route('populasi-ayam.index')
         ->with('success', 'Data populasi berhasil disimpan.');
         
        // - hitung ada berapa arrays di json 
        // - buat loop dengan arrays jumlah tersebut 
        // - input record data sesuai loop dengan data yang sama keculi di populasi record
        //   tertutama pada kadang id , flock id dan pipe id , ayam_sehat, ayam_sakit_ayam_mati , 
        // masuk kandang karantina , dan keluar kandang karantina
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
    public function edit(PopulasiAyam $populasiAyam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PopulasiAyam $populasiAyam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PopulasiAyam $populasiAyam)
    {
        //
    }
}
