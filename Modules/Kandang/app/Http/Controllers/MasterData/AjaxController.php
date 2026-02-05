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
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Services\KandangService;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\JenisPakan;
use Modules\Kandang\Services\PopulasiAyamService;

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
        private KandangRepository $kandangRepository,
    ) { }

    public function kandang()
    {
        $kandangs = $this->kandangRepository->getModel()
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

    public function umurAyamByPipe(PopulasiAyamService $populasiAyamService, $pipeId, Request $request)
    {
        $targetDate = $request->input('tanggal')
            ? Carbon::parse($request->input('tanggal'))->startOfDay()
            : Carbon::now()->startOfDay();

        $result = $populasiAyamService->getUmurAyamByPipeId($pipeId, $targetDate);
        
        if ($result === null) {
            return response()->json([
                'error' => 'Data pengadaan ayam tidak ditemukan'
            ], 404);
        }

        return $result;
    }

    public function umurAyamByFlock(PopulasiAyamService $populasiAyamService, $flockId, Request $request)
    {
        $targetDate = $request->input('tanggal')
            ? Carbon::parse($request->input('tanggal'))->startOfDay()
            : Carbon::now()->startOfDay();

        $result = $populasiAyamService->getUmurAyamByFlockId($flockId, $targetDate);
        
        if ($result === null) {
            return response()->json([
                'error' => 'Data pengadaan ayam tidak ditemukan'
            ], 404);
        }

        return $result;
    }

    public function umurAyamByKandang(PopulasiAyamService $populasiAyamService, $kandangId, Request $request)
    {
        $targetDate = $request->input('tanggal')
            ? Carbon::parse($request->input('tanggal'))->startOfDay()
            : Carbon::now()->startOfDay();

        $result = $populasiAyamService->getUmurAyamByKandangId($kandangId, $targetDate);
        
        if ($result === null) {
            return response()->json([
                'error' => 'Data pengadaan ayam tidak ditemukan'
            ], 404);
        }

        return $result;
    }

    public function populasiByPipe(PopulasiAyamService $populasiAyamService, $pipeId, $tanggal)
    {
        $tanggal = Carbon::createFromFormat('Y-m-d', $tanggal);
        $jumlahAyamSehat = $populasiAyamService->getCurrentAyamSehatByPipe($pipeId, $tanggal);
        $pipe = $this->pipe->find($pipeId, ['id', 'flock_id']);
        $latestTotalKarantinaPopulasi = $populasiAyamService->getLatestKarantinaPopulasi($pipe->flock->kandang_id, $tanggal);
        
        return [
            'total_ayam_sehat_terakhir' => $jumlahAyamSehat,
            'total_ayam_sakit_terakhir' => $latestTotalKarantinaPopulasi,
        ];
    }

    public function populasiByFlock(PopulasiAyamService $populasiAyamService, $flockId, $tanggal)
    {
        $tanggal = Carbon::createFromFormat('Y-m-d', $tanggal);
        $jumlahAyamSehat = $populasiAyamService->getCurrentAyamSehatByFlock($flockId, $tanggal);
        $pipe = $this->pipe->find($flockId, ['id', 'flock_id']);
        $latestTotalKarantinaPopulasi = $populasiAyamService->getLatestKarantinaPopulasi($pipe->flock->kandang_id, $tanggal);
        
        return [
            'total_ayam_sehat_terakhir' => $jumlahAyamSehat,
            'total_ayam_sakit_terakhir' => $latestTotalKarantinaPopulasi,
        ];
    }

    public function populasiByKandang(PopulasiAyamService $populasiAyamService, $kandangId, $tanggal)
    {
        $tanggal = Carbon::createFromFormat('Y-m-d', $tanggal);
        $jumlahAyamSehat = $populasiAyamService->getCurrentAyamSehatByKandang($kandangId, $tanggal);
        $latestTotalKarantinaPopulasi = $populasiAyamService->getLatestKarantinaPopulasi($kandangId, $tanggal);
        
        return [
            'total_ayam_sehat_terakhir' => $jumlahAyamSehat,
            'total_ayam_sakit_terakhir' => $latestTotalKarantinaPopulasi,
        ];
    }

    public function ayamKarantina($kandangId, $tanggal)
    {
        // take latest or today populasi karantina
        return $this->karantinaPopulasi
            ->getQuery()
            ->where('kandang_id', '=', $kandangId)
            ->whereDate('tanggal', '<=', $tanggal)
            ->orderByDesc('tanggal')
            ->orderByDesc('updated_at')
            ->firstOrFail();
    }
}