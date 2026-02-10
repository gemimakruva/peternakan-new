<?php

namespace Modules\Kandang\Http\Controllers\PopulasiAyam;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Enums\JenisPemeriksaan;
use Modules\Kandang\Http\Requests\PopulasiAyam\GetSummaryRequest;
use Modules\Kandang\Http\Requests\PopulasiAyam\PopulasiAyamStore;
use Modules\Kandang\Http\Requests\PopulasiAyam\PopulasiAyamUpdate;
use Modules\Kandang\Models\AyamAfkir;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\KarantinaPopulasi;
use Modules\Kandang\Models\KarantinaPopulasiPipe;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Repositories\Kandang\FlockRepository;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Services\KandangService;
use Modules\Kandang\Services\PopulasiAyamService;

class PopulasiAyamController extends Controller
{
    public function __construct(
        private Kandang $kandang,
        private PopulasiAyam $populasiAyam,
        private KarantinaPopulasi $karantinaPopulasi,
        private KarantinaPopulasiPipe $karantinaPopulasiPipe,
        private AyamAfkir $ayamAfkir,
        private Pipe $pipe,
        private PopulasiAyamService $service,
        private KandangRepository $kandangRepository,
        private FlockRepository $flockRepository,
    ) {}

    public function index()
    {
        $listKandang = $this->kandangRepository
            ->populasiAyam(request()->collect())
            ->whereNotNull('terakhir_diperharui')
            ->with([
                'latestPengadaanAyam.distribusi:pengadaan_ayam_id,pipe_id',
                'latestPengadaanAyam.distribusi.latestPopulasiAyam:pipe_id,ayam_sehat',
            ])
            ->paginate(request()->query('perPage', 10));

        $listKandang->transform(function($item) {
            $item->terakhir_diperharui = Carbon::createFromFormat('Y-m-d', $item->terakhir_diperharui);
            return $item;
        });

        return view('kandang::populasi-ayam.index', compact('listKandang'));
    }

    public function flockIndex(Kandang $kandang)
    {
        request()->merge(['kandang_id' => $kandang->id]);

        $kandang = $this->kandangRepository
            ->populasiAyam(collect([]))
            ->where('kandang.id', '=', $kandang->id)
            ->first();

        $listFlock = $this->flockRepository
            ->populasiAyam(request()->collect())
            ->paginate(request()->query('perPage', 10));

        $listFlock->transform(function($item) {
            $item->tanggal = $item->tanggal 
                ? Carbon::createFromFormat('Y-m-d', $item->tanggal) 
                : null;
            $item->terakhir_diperharui = $item->terakhir_diperharui 
                ? Carbon::createFromFormat('Y-m-d', $item->terakhir_diperharui) 
                : null;
            $item->ayam_sehat = (int) $item->ayam_sehat;
            $item->ayam_mati = (int) $item->ayam_mati;
            $item->ayam_afkir = (int) $item->ayam_afkir;
            return $item;
        });

        return view('kandang::populasi-ayam.flock-index', compact(['kandang', 'listFlock']));
    }

    public function flockPipeIndex(Kandang $kandang, Flock $flock)
    {
        $listPopulasiAyam = $this->populasiAyam
            ->query()
            ->with([
                'picUser:id,name',
                'pipe:id,nama'
            ])
            ->whereRelation('pipe', 'flock_id', '=', $flock->id)
            ->orderByDesc('tanggal')
            ->paginate(request()->query('perPage', 10))
            ->withQueryString()
            ->onEachSide(3);
        
        return view('kandang::populasi-ayam.pipe-index', compact(['kandang', 'flock', 'listPopulasiAyam']));
    }

    public function create(Kandang $kandang)
    {
        $kandangId = $kandang->id;
        return view('kandang::populasi-ayam.create', compact(['kandang', 'kandangId']));
    }

    public function store(PopulasiAyamStore $request)
    {
        DB::beginTransaction();
        try {
            app(PopulasiAyamService::class)->savePopulasiAyam($request);
            DB::commit();
            return back()->with('success', 'Data populasi berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return back()
                ->withInput()
                ->with('danger', 'Data populasi gagal disimpan.');
        }
    }

    public function edit(PopulasiAyam $populasiAyam)
    {
        $populasiAyam->load([
            'pipe:id,flock_id,nama',
            'pipe.flock:id,kandang_id,nama',
            'pipe.flock.kandang:id,nama',
        ]);

        $data = $populasiAyam;
        $pipe = $data->pipe;
        $flock = $pipe->flock;
        $kandang = $flock->kandang;
        $kandangId = $kandang->id;

        return view('kandang::populasi-ayam.edit', compact([
            'data',
            'pipe',
            'flock',
            'kandang',
            'kandangId',
        ]));
    }

    public function update(PopulasiAyamUpdate $request, PopulasiAyam $populasiAyam)
    {
        DB::beginTransaction();
        try {
            app(PopulasiAyamService::class)->savePopulasiAyam($request);
            DB::commit();
            return back()->with('success', 'Data populasi berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return back()->with('danger', 'Data populasi gagal diupdate.');
        }

    }

    public function getRecordedPopulasi($kandangId, $tanggal)
    {
        return $this->populasiAyam
            ->whereRelation('pipe.flock', 'kandang_id', '=', $kandangId)
            ->where('tanggal', '=', $tanggal)
            ->with('pipe:id,nama')
            ->get();
    }
}
