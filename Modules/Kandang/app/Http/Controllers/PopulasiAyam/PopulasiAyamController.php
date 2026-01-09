<?php

namespace Modules\Kandang\Http\Controllers\PopulasiAyam;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Kandang\Enums\JenisPemeriksaan;
use Modules\Kandang\Http\Requests\PopulasiAyam\GetSummaryRequest;
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

        $listFlock = $this->flockRepository
            ->populasiAyam(request()->collect())
            ->paginate(request()->query('perPage', 10));

        $listFlock->transform(function($item) {
            $item->tanggal = Carbon::createFromFormat('Y-m-d', $item->tanggal);
            $item->terakhir_diperharui = Carbon::createFromFormat('Y-m-d', $item->terakhir_diperharui);
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

    public function store(Request $request)
    {
        $request->merge([
            'ayam_sehat' => $request->input('jumlah_ayam_sehat_pada_pipa_saat_ini', 0)
                - $request->input('ayam_mati')
                - $request->input('ayam_afkir')
                - $request->input('ayam_masuk_karantina')
                + $request->input('ayam_masuk_karantina'),
        ]);

        $validated = $request->validate([
            'tanggal_transaksi' => ['required', 'date'],
            'kandang_id'        => ['required', 'exists:kandang,id'],
            'flock_id'          => ['required', 'exists:flock,id'],
            'pipe_id'           => ['required', 'exists:pipe,id', function ($attr, $value, $fail) {
                $isExist = $this->populasiAyam
                    ->getQuery()
                    ->where('pipe_id', '=', $value)
                    ->where('tanggal', '=', request()->input('tanggal_transaksi'))
                    ->exists();
                if ($isExist) {
                    $pipe = $this->pipe->find($value);
                    $fail("Recording untuk pipe $pipe->nama sudah dilakukan.");
                }
            }],
            'umur_ayam_record'     => ['required', 'min:1'],
            'ayam_sehat'           => ['nullable', 'min:0'],
            'ayam_mati'            => ['nullable', 'min:0'],
            'ayam_afkir'           => ['nullable', 'min:0'],
            'ayam_masuk_karantina' => ['nullable', 'min:0', function ($attr, $value, $fail) {
                $value = (int) $value;

                if ($value > app(KandangService::class)->getCurrentAyamSehatByPipe(request()->input('pipe_id'))) {
                    $fail('ayam masuk karantina tidak boleh melebihi populasi ayam.');
                }
            }],
            'ayam_keluar_karantina' => ['nullable', 'min:0', function ($attr, $value, $fail) {
                $value = (int) $value;

                if ($value > app(KandangService::class)->getCurrentAyamKarantinaByKandang(request()->input('kandang_id'))) {
                    $fail('ayam keluar karantina tidak boleh melebihi populasi karantina.');
                }

                if ($value > app(KandangService::class)->getCurrentKapasitasPipeTersedia(request()->input('pipe_id'))) {
                    $fail('ayam keluar karantina tidak boleh melebihi kapasitas pipe.');
                }
            }],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $populasiAyam = $this->populasiAyam->create([
            'pic_user_id'           => auth()->id(),
            'pipe_id'               => $validated['pipe_id'],
            'jenis_pemeriksaan'     => JenisPemeriksaan::HARIAN,
            'umur_ayam_record'      => $validated['umur_ayam_record'],
            'tanggal'               => $validated['tanggal_transaksi'],
            'ayam_sehat'            => $validated['ayam_sehat'],
            'ayam_mati'             => @$validated['ayam_mati']             ?? 0,
            'ayam_afkir'            => @$validated['ayam_afkir']            ?? 0,
            'ayam_masuk_karantina'  => @$validated['ayam_masuk_karantina']  ?? 0,
            'ayam_keluar_karantina' => @$validated['ayam_keluar_karantina'] ?? 0,
            'catatan'               => $validated['catatan']                ?? null,
        ]);

        if (@$validated['ayam_afkir'] > 0) {
            $this->ayamAfkir->create([
                'populasi_ayam_id'  => $populasiAyam->id,
                'pic_user_id'       => auth()->id(),
                'tanggal'           => $validated['tanggal_transaksi'],
                'umur_ayam'         => $validated['umur_ayam_record'],
                'jumlah_ayam_afkir' => $validated['ayam_afkir'],
            ]);
        }

        if (@$validated['ayam_masuk_karantina'] || @$validated['ayam_keluar_karantina']) {
            $currentKarantinaPopulasi = $this->karantinaPopulasi->getQuery()
                ->where('kandang_id', '=', $populasiAyam->pipe->flock->kandang_id)
                ->where('tanggal', '=', $populasiAyam->tanggal)
                ->value('total_ayam_karantina') ?? 0;

            $this->karantinaPopulasiPipe->create([
                'populasi_ayam_asal_id' => $populasiAyam->id,
                'tanggal'               => $populasiAyam->tanggal,
                'pipe_asal_id'          => @$validated['ayam_masuk_karantina'] ? $validated['pipe_id'] : null,
                'ayam_masuk_karantina'  => @$validated['ayam_masuk_karantina'],
                'pipe_tujuan_id'        => @$validated['ayam_keluar_karantina'] ? @$validated['pipe_id'] : null,
                'ayam_keluar_karantina' => @$validated['ayam_keluar_karantina'],
            ]);

            if (@$validated['ayam_masuk_karantina'] > 0) {
                $currentKarantinaPopulasi += $validated['ayam_masuk_karantina'];
            }

            if (@$validated['ayam_keluar_karantina'] > 0) {
                $currentKarantinaPopulasi -= $validated['ayam_keluar_karantina'];
            }

            $this->karantinaPopulasi->updateOrCreate([
                'kandang_id' => $populasiAyam->pipe->flock->kandang_id,
                'tanggal'    => $populasiAyam->tanggal,
            ], [
                'pic_user_id'          => $populasiAyam->pic_user_id,
                'total_ayam_karantina' => $currentKarantinaPopulasi,
            ]);
        }

        return back()->with('success', 'Data populasi berhasil disimpan.');
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

    public function update(Request $request, PopulasiAyam $populasiAyam)
    {
        $request->merge([
            'ayam_sehat' => $request->input('jumlah_ayam_sehat_pada_pipa_saat_ini', 0)
                - $request->input('ayam_mati')
                - $request->input('ayam_afkir')
                - $request->input('ayam_masuk_karantina')
                + $request->input('ayam_masuk_karantina'),
        ]);

        $validated = $request->validate([
            'tanggal_transaksi' => ['required', 'date'],
            'kandang_id'        => ['required', 'exists:kandang,id'],
            'flock_id'          => ['required', 'exists:flock,id'],
            'pipe_id'           => ['required', 'exists:pipe,id', function ($attr, $value, $fail) use($populasiAyam) {
                $isExist = $this->populasiAyam
                    ->getQuery()
                    ->where('pipe_id', '=', $value)
                    ->where('tanggal', '=', request()->input('tanggal_transaksi'))
                    ->where('id', '<>', $populasiAyam->id)
                    ->exists();
                if ($isExist) {
                    $pipe = $this->pipe->find($value);
                    $fail("Recording untuk pipe $pipe->nama sudah dilakukan.");
                }
            }],
            'umur_ayam_record'     => ['required', 'min:1'],
            'ayam_sehat'           => ['nullable', 'min:0'],
            'ayam_mati'            => ['nullable', 'min:0'],
            'ayam_afkir'           => ['nullable', 'min:0'],
            'ayam_masuk_karantina' => ['nullable', 'min:0', function ($attr, $value, $fail) {
                $value = (int) $value;

                if ($value > app(KandangService::class)->getCurrentAyamSehatByPipe(request()->input('pipe_id'))) {
                    $fail('ayam masuk karantina tidak boleh melebihi populasi ayam.');
                }
            }],
            'ayam_keluar_karantina' => ['nullable', 'min:0', function ($attr, $value, $fail) {
                $value = (int) $value;

                if ($value > app(KandangService::class)->getCurrentAyamKarantinaByKandang(request()->input('kandang_id'))) {
                    $fail('ayam keluar karantina tidak boleh melebihi populasi karantina.');
                }

                if ($value > app(KandangService::class)->getCurrentKapasitasPipeTersedia(request()->input('pipe_id'))) {
                    $fail('ayam keluar karantina tidak boleh melebihi kapasitas pipe.');
                }
            }],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $populasiAyam->update([
            'pic_user_id'           => auth()->id(),
            'pipe_id'               => $validated['pipe_id'],
            'jenis_pemeriksaan'     => JenisPemeriksaan::HARIAN,
            'umur_ayam_record'      => $validated['umur_ayam_record'],
            'tanggal'               => $validated['tanggal_transaksi'],
            'ayam_sehat'            => $validated['ayam_sehat'],
            'ayam_mati'             => @$validated['ayam_mati']             ?? 0,
            'ayam_afkir'            => @$validated['ayam_afkir']            ?? 0,
            'ayam_masuk_karantina'  => @$validated['ayam_masuk_karantina']  ?? 0,
            'ayam_keluar_karantina' => @$validated['ayam_keluar_karantina'] ?? 0,
            'catatan'               => $validated['catatan']                ?? null,
        ]);

        if (@$validated['ayam_afkir'] > 0) {
            $this->ayamAfkir->updateOrCreate([
                'populasi_ayam_id'  => $populasiAyam->id,
            ], [
                'pic_user_id'       => auth()->id(),
                'tanggal'           => $validated['tanggal_transaksi'],
                'umur_ayam'         => $validated['umur_ayam_record'],
                'jumlah_ayam_afkir' => $validated['ayam_afkir'],
            ]);
        }

        if (@$validated['ayam_masuk_karantina'] || @$validated['ayam_keluar_karantina']) {
            $currentKarantinaPopulasi = $this->karantinaPopulasi->getQuery()
                ->where('kandang_id', '=', $populasiAyam->pipe->flock->kandang_id)
                ->where('tanggal', '=', $populasiAyam->tanggal)
                ->value('total_ayam_karantina') ?? 0;

            $this->karantinaPopulasiPipe->updateOrCreate([
                'populasi_ayam_asal_id' => $populasiAyam->id,
            ], [
                'pipe_asal_id'          => @$validated['ayam_masuk_karantina'] ? $validated['pipe_id'] : null,
                'tanggal'               => $populasiAyam->tanggal,
                'ayam_masuk_karantina'  => @$validated['ayam_masuk_karantina'],
                'pipe_tujuan_id'        => @$validated['ayam_keluar_karantina'] ? @$validated['pipe_id'] : null,
                'ayam_keluar_karantina' => @$validated['ayam_keluar_karantina'],
            ]);

            if (@$validated['ayam_masuk_karantina'] > 0) {
                $currentKarantinaPopulasi += $validated['ayam_masuk_karantina'];
            }

            if (@$validated['ayam_keluar_karantina'] > 0) {
                $currentKarantinaPopulasi -= $validated['ayam_keluar_karantina'];
            }

            $this->karantinaPopulasi->updateOrCreate([
                'kandang_id' => $populasiAyam->pipe->flock->kandang_id,
                'tanggal'    => $populasiAyam->tanggal,
            ], [
                'pic_user_id'          => $populasiAyam->pic_user_id,
                'total_ayam_karantina' => $currentKarantinaPopulasi,
            ]);
        }

        return back()->with('success', 'Data populasi berhasil diupdate.');
    }

    public function getRecordedPopulasi($kandangId, $tanggal)
    {
        return $this->populasiAyam
            ->whereRelation('pipe.flock', 'kandang_id', '=', $kandangId)
            ->where('tanggal', '=', $tanggal)
            ->with('pipe:id,nama')
            ->get();
    }

    public function getSummary(GetSummaryRequest $request): JsonResponse
    {
        return response()->json($this->service->getChickensPerRow($request->validated()));
    }
}
