<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\KarantinaPopulasi;
use Modules\Kandang\Models\PengadaanAyamDistribusi;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Services\KandangService;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\JenisPakan;

class AjaxController extends Controller
{
    public function __construct(
        private Kandang $kandang,
        private Flock $flock,
        private Pipe $pipe,
        private PengadaanAyamDistribusi $pengadaanAyamDistribusi,
        private PerhitunganPakan $perhitunganPakan,
        private PopulasiAyam $populasiAyam,
        private JenisPakan $jenisPakan,
        private KarantinaPopulasi $karantinaPopulasi,
    ) { }

    public function kandang()
    {
        $kandangs = $this->kandang
            ->getQuery()
            ->select('id', 'nama')
            ->when(request()->query('q'), function($query, $q) {
                $query->where('nama', 'like', "%$q%");
            })
            ->get();
        $results = $kandangs->map(function($k) {
            return ['id' => $k->id, 'text' => $k->nama];
        });
        return response()->json(['results' => $results]);
    }

    public function flock($kandangId)
    {
        $flocks = $this->flock
            ->when(request()->query('q'), function($query, $q) {
                $query->where('nama', 'like', "%$q%");
            })
            ->where('kandang_id', $kandangId)
            ->select('id', 'nama')
            ->get();

        $results = $flocks->map(function($f) {
            return ['id' => $f->id, 'text' => $f->nama];
        });

        return response()->json(['results' => $results]);
    }

    public function pipe($flockId)
    {
        $pipes = $this->pipe->where('flock_id', $flockId)->select('id', 'nama')->get();
        $results = $pipes->map(function($p) {
            return ['id' => $p->id, 'text' => $p->nama];
        });
        return response()->json(['results' => $results]);
    }

    public function umur_ayam($pipeId)
    {
        $pengadaanAyam = $this->pengadaanAyamDistribusi
            ->with('pengadaanAyam:id,tanggal,umur_ayam')
            ->where('pipe_id', '=', $pipeId)
            ->firstOrFail(['pengadaan_ayam_id', 'pipe_id'])->pengadaanAyam;

        $tanggalPerbandingan = request()->has('tanggal_perbandingan') 
            ? request()->date('tanggal_perbandingan')->diffInWeeks($pengadaanAyam->tanggal)
            : now()->diffInWeeks($pengadaanAyam->tanggal);

        $umurAyamSekarang = $pengadaanAyam->umur_ayam + floor(abs($tanggalPerbandingan));

        return [
            'tanggal_ayam_datang' => $pengadaanAyam->tanggal,
            'umur_ayam_datang' => $pengadaanAyam->umur_ayam,
            'umur_ayam_sekarang' => $umurAyamSekarang,
        ];
    }

    public function tanggalPerhitunganPakan()
    {
        $tanggal = $this->perhitunganPakan
            ->getQuery()
            ->select('id', 'tanggal_pemberian_pakan')
            ->when(request()->query('q'), function($query, $q) {
                $query->where('tanggal_pemberian_pakan', 'like', "%$q%");
            })
              ->latest()->get();

        $result = $tanggal->map(function($k){
            return [
                'id' => $k->id, 
                'text' => Carbon::parse($k->tanggal_pemberian_pakan)->format('d-m-Y'),
            ];
        });

        return response()->json(['results' => $result]);
    }


    public function getFlockByKandangId($kandangId)
    {
        $perhitungan = $this->perhitunganPakan
        ->with('pipe.flock.kandang')
        ->whereHas('pipe.flock.kandang', 
        function($q) use ($kandangId) {
            $q->where('id', $kandangId);
        })
        ->get();
          $flocks = [];
        
    foreach ($perhitungan as $pp) {
        if ($pp->pipe && $pp->pipe->flock) {
            $flocks[] = [
                'id' => $pp->pipe->flock->id,
                'nama' => $pp->pipe->flock->nama,
            ];
        }
    }

    

    $flocks = collect($flocks)->unique('id')->values()->all();
    
    return response()->json([
        'status' => true,
        'results' => $flocks
    ]);

    }

    public function getFlockByKandangTreatment($kandangId)
{
    $flocks = Flock::where('kandang_id', $kandangId)
        ->get(['id', 'nama']);

    return response()->json([
        'status' => true,
        'results' => $flocks
    ]);
}


    public function getPemberianPakanByFlockId($tanggal,$flockId)
    {
         $perhitungan = $this->perhitunganPakan
        ->where('tanggal_pemberian_pakan', $tanggal)
        ->first();

           if (!$perhitungan) {
        return response()->json([
            'status' => false,
            'message' => 'Data perhitungan pakan tidak ditemukan untuk tanggal tersebut',
            'result' => 0,
        ]);
    }
        
        $totalPakan = DB::table('perhitungan_pakan as pp')
            ->join('pipe as p', 'pp.pipe_id', '=', 'p.id')
            ->join('flock as f', 'p.flock_id', '=', 'f.id')
            ->where('pp.tanggal_pemberian_pakan', $tanggal) 
            ->where('f.id', $flockId)
            ->selectRaw('(SUM(pp.jumlah_ayam_per_pipe * 
            pp.jumlah_pakan_per_ekor_gram) / 1000) as total_pakan_kg')
            ->value('total_pakan_kg');
        
   
        return response()->json([
        'status' => true,
        'message' => 'Total pakan berhasil diambil',
        'result' => $totalPakan ?? 0 ,
    ]);
    }

    public function umurAyamByFlock($flockId, Request $request)
    {
        $distribusi = $this->pengadaanAyamDistribusi
            ->with('pengadaanAyam:id,tanggal,umur_ayam')
            ->where('flock_id', '=', $flockId)
            ->firstOrFail(['pengadaan_ayam_id', 'flock_id']);

        $pengadaanAyam = $distribusi->pengadaanAyam;

        $targetDate = $request->input('tanggal') 
            ? Carbon::parse($request->input('tanggal'))->startOfDay() 
            : Carbon::now()->startOfDay();

        $tanggalPerbandingan = floor($pengadaanAyam->tanggal->diffInDays($targetDate) / 7);
        
        return response()->json([
            'usia_ayam_saat_ini' => $tanggalPerbandingan
        ]);
    }

    public function umurAyamByKandang($kandangId, Request $request)
    {
        // Ambil distribusi melalui relasi pipe -> flock -> kandang
        $distribusi = $this->pengadaanAyamDistribusi
            ->with([
                'pengadaanAyam:id,tanggal,umur_ayam',
                'pipe.flock:id,kandang_id'
            ])
            ->whereHas('pipe.flock', function($query) use ($kandangId) {
                $query->where('kandang_id', $kandangId);
            })
            ->firstOrFail(['id', 'pengadaan_ayam_id', 'pipe_id']);

        $pengadaanAyam = $distribusi->pengadaanAyam;

        // Validasi apakah tanggal pengadaan ada
        if (!$pengadaanAyam || !$pengadaanAyam->tanggal) {
            return response()->json([
                'error' => 'Data pengadaan ayam tidak ditemukan'
            ], 404);
        }

        $targetDate = $request->input('tanggal')
            ? Carbon::parse($request->input('tanggal'))->startOfDay()
            : Carbon::now()->startOfDay();

        // Hitung umur ayam dalam minggu
        $tanggalPengadaan = Carbon::parse($pengadaanAyam->tanggal)->startOfDay();
        $umurAyamSaatPengadaan = $pengadaanAyam->umur_ayam; // dalam minggu
        $selisihHariDariPengadaan = $tanggalPengadaan->diffInDays($targetDate);
        $selisihMingguDariPengadaan = floor($selisihHariDariPengadaan / 7);

        $usiaAyamSaatIni = $umurAyamSaatPengadaan + $selisihMingguDariPengadaan;

        return response()->json([
            'usia_ayam_saat_ini' => $usiaAyamSaatIni,
            'umur_saat_pengadaan' => $umurAyamSaatPengadaan,
            'tambahan_minggu' => $selisihMingguDariPengadaan,
            'tanggal_pengadaan' => $tanggalPengadaan->format('Y-m-d'),
            'tanggal_perhitungan' => $targetDate->format('Y-m-d')
        ]);
    }

    public function jumlahAyamSehat($startDate)
    {
        $populasi_ayam = PopulasiAyam::whereDate('tanggal', '=', $startDate)
        ->pluck('ayam_sehat')
        ->first();

        if ($populasi_ayam === null) {
            return response()->json([
                'ayam_sehat' => 0
            ]);
        }
        return response()->json([
            'ayam_sehat' => $populasi_ayam
        ]);
    }

    public function kesehatan_ayam(KandangService $kandangService, $pipeId)
    {
        $tanggalPerbandingan = request()->date('tanggal_perbandingan');
        if ($tanggalPerbandingan === null) {
            abort(400, 'tanggal perbandingan tidak valid');
        }
 
        $jumlahAyamSehat = $kandangService->getCurrentAyamSehatByPipe($pipeId, $tanggalPerbandingan);
        
        return [
            'total_ayam_sehat_terakhir' => $jumlahAyamSehat,
        ];
    }

    public function populasi_kandang_karantina(KandangService $kandangService, $kandangId)
    {
        $tanggalPerbandingan = request()->date('tanggal_perbandingan');

        return [
            'total_ayam_karantina_terakhir' => $kandangService->getCurrentAyamKarantinaByKandang(
                $kandangId, 
                $tanggalPerbandingan
            ),
        ];
    }

    public function ayamKarantina($kandangId, $tanggal)
    {
        return $this->karantinaPopulasi
            ->getQuery()
            ->where('kandang_id', '=', $kandangId)
            ->whereDate('tanggal', '=', $tanggal)
            ->firstOrFail();
    }

       public function getKandangByTanggalId($tanggal)
    {
        $tanggal = Carbon::parse($tanggal)->format('Y-m-d');
        $kandang = $this->perhitunganPakan
        ->where('tanggal_pemberian_pakan', $tanggal)
        ->with('pipe.flock.kandang') // relasi
        ->get();
        $data = $kandang->map(function ($item) {
                return [
                    'id'   => $item->id,
                    'nama' => $item->pipe->flock->kandang->nama ?? null,
                ];
        });

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diambil',
            'data'    => $data
        ]);
    }

    public function getJumlahAyamPerKandang(Request $request)
    {
        $jumlahAyam = pengadaanAyamDistribusi::whereHas('pengadaanAyam', function ($q) use ($request) {
                $q->whereDate('tanggal', $request->tanggal);
            })
            ->whereHas('pipe.flock.kandang', function ($q) use ($request) {
                $q->where('id', $request->kandang_id);
            })
            ->join('pengadaan_ayam', 'pengadaan_ayam.id', '=', 'pengadaan_ayam_distribusi.pengadaan_ayam_id')
            ->value('pengadaan_ayam.jumlah_ayam_masuk_kandang');

        return response()->json([
            'jumlah_ayam' => $jumlahAyam ?? 0,
        ]);
    }

}