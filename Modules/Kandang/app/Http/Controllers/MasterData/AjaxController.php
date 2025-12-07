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

class AjaxController extends Controller
{
    public function __construct(
        private Kandang $kandang,
        private Flock $flock,
        private Pipe $pipe,
        private PengadaanAyamDistribusi $pengadaanAyamDistribusi,
        private PerhitunganPakan $perhitunganPakan,
        private PopulasiAyam $populasiAyam,
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
            ->get();

        $result = $tanggal->map(function($k){
            return [
                'id' => $k->id, 
                'text' => Carbon::parse($k->tanggal_pemberian_pakan)->format('d-m-Y'),
            ];
        });

        return response()->json(['results' => $result]);
    }

    public function DetailPengadaanByPipeId($tanggalId)
    {
        $perhitungan = $this->perhitunganPakan
            ->with('pipe.flock.kandang', 'jenis_pakan')
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

        $flocks = [];
        foreach($pipes as $pipe) {
            if($pipe && $pipe->flock) {
                $flocks[] = [
                    'id' => $pipe->flock->id,
                    'nama' => $pipe->flock->nama,
                ];
            }
        }

        $pipesArr = [];
        foreach($pipes as $pipe) {
            if($pipe) {
                $pipesArr[] = [
                    'id' => $pipe->id,
                    'nama' => $pipe->nama,
                    'kapasitas' =>$pipe->kapasitas
                ];
            }
        }

        $jenisPakan = $perhitungan->jenis_pakan;
        $pakanPerFlock = ($perhitungan->jumlah_ayam_per_pipe * $perhitungan->jumlah_pakan_per_ekor_gram) / 100;
        $pakanPerFlock = round($pakanPerFlock, 2);

        return response()->json([
            'results' => [
                'kandang' => $kandangs,
                'flock' => $flocks,
                'pipe' => $pipesArr,
                'jenis_pakan' => $jenisPakan->nama,
                'pakanPerFlock' => $pakanPerFlock 
            ]
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