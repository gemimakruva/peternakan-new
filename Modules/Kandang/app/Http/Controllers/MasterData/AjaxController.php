<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
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
        private JenisPakan $jenisPakan
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

    public function getKandangByTanggalId($tanggalId){
        $perhitungan = $this->perhitunganPakan
            ->with('pipe.flock.kandang')
            ->findOrFail($tanggalId);
         $pipes = $perhitungan->pipe ? [$perhitungan->pipe] : [];
         $kandangs = [];
            foreach($pipes as $pipe) {
                if($pipe && $pipe->flock && $pipe->flock->kandang) {
                    $kandangs[] = [
                            'id' => $pipe->flock->kandang->id,
                            'nama' => $pipe->flock->kandang->nama,
                    ];
                }
            }
            return response()->json([
                'status' => true,
                'results' => $kandangs
    ]); 
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

    public function getPemberianPakanByFlockId($tanggalId,$flockId)
    {
        $tanggal = $this->perhitunganPakan->findOrFail($tanggalId);
         $tanggalValue = $tanggal->tanggal_pemberian_pakan;
        
        $totalPakan = DB::table('perhitungan_pakan as pp')
            ->join('pipe as p', 'pp.pipe_id', '=', 'p.id')
            ->join('flock as f', 'p.flock_id', '=', 'f.id')
            ->where('pp.tanggal_pemberian_pakan', $tanggalValue) 
            ->where('f.id', $flockId)
            ->selectRaw('(SUM(pp.jumlah_ayam_per_pipe * 
            pp.jumlah_pakan_per_ekor_gram) / 1000) as total_pakan_kg')
            ->value('total_pakan_kg');
        
             $jenisPakan = $this->jenisPakan->all();
   
        return response()->json([
        'status' => true,
        'message' => 'Total pakan berhasil diambil',
        'result' => $totalPakan ?? 0 ,
        'jenisPakan' => $jenisPakan
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
        $distribusi = $this->pengadaanAyamDistribusi
            ->with('pengadaanAyam:id,tanggal,umur_ayam')
            ->where('kandang_id', '=', $kandangId)
            ->firstOrFail(['pengadaan_ayam_id', 'kandang_id']);

        $pengadaanAyam = $distribusi->pengadaanAyam;

        $targetDate = $request->input('tanggal') 
            ? Carbon::parse($request->input('tanggal'))->startOfDay() 
            : Carbon::now()->startOfDay();

        $tanggalPerbandingan = floor($pengadaanAyam->tanggal->diffInDays($targetDate) / 7);
        
        return response()->json([
            'usia_ayam_saat_ini' => $tanggalPerbandingan
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
}