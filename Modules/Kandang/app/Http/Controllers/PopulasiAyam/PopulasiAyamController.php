<?php
namespace Modules\Kandang\Http\Controllers\PopulasiAyam;

use App\Http\Controllers\Controller;
use Modules\Kandang\Enums\JenisPemeriksaan;
use Modules\Kandang\Models\AyamAfkir;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\KarantinaPopulasi;
use Modules\Kandang\Models\KarantinaPopulasiPipe;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;
use Modules\Kandang\Services\KandangService;

class PopulasiAyamController extends Controller
{
    public function __construct(
        private Kandang $kandang,
        private PopulasiAyam $populasiAyam,
        private KarantinaPopulasi $karantinaPopulasi,
        private KarantinaPopulasiPipe $karantinaPopulasiPipe,
        private AyamAfkir $ayamAfkir,
        private Pipe $pipe,
    ) { }
    
    public function index()
    {
       return view("kandang::populasi-ayam.index");
    }

    /**
     * Show the form for creating a new resource.
     */

     /**
     * Show the list of pengadaan
     */
    
    public function create()
    {
        $list_kandang = Kandang::all();
        return view("kandang::populasi-ayam.list-tanggal-pengadaan", compact('list_kandang'));
    }

    public function createByDate($kandangId)
    {
        $kandang = $this->kandang->findOrFail($kandangId);
        return view("kandang::populasi-ayam.create", compact('kandang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'ayam_sehat' => $request->input('jumlah_ayam_sehat_pada_pipa_saat_ini', 0)
                - $request->input('ayam_mati')
                - $request->input('ayam_afkir')
                - $request->input('ayam_masuk_karantina')
                + $request->input('ayam_masuk_karantina')
        ]);

        $validated = $request->validate([
            'tanggal_transaksi' => ['required', 'date'],
            'kandang_id' => ['required', 'exists:kandang,id'],
            'flock_id' => ['required', 'exists:flock,id'],
            'pipe_id' => ['required', 'exists:pipe,id', function($attr, $value, $fail) {
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
            'umur_ayam_record' => ['required', 'min:1'],
            'ayam_sehat' => ['nullable', 'min:0'],
            'ayam_mati' => ['nullable', 'min:0'],
            'ayam_afkir' => ['nullable', 'min:0'],
            'ayam_masuk_karantina' => ['nullable', 'min:0', function($attr, $value, $fail) {
                $value = (int) $value;

                if ($value > app(KandangService::class)->getCurrentAyamSehatByPipe(request()->input('pipe_id'))) {
                    $fail('ayam masuk karantina tidak boleh melebihi populasi ayam.');
                }
            }],
            'ayam_keluar_karantina' => ['nullable', 'min:0', function($attr, $value, $fail) {
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
            'ayam_mati'             => @$validated['ayam_mati'] ?? 0,
            'ayam_afkir'            => @$validated['ayam_afkir'] ?? 0,
            'ayam_masuk_karantina'  => @$validated['ayam_masuk_karantina'] ?? 0,
            'ayam_keluar_karantina' => @$validated['ayam_keluar_karantina'] ?? 0,
            'catatan'               => $validated['catatan'] ?? null,
        ]);

        if (@$validated['ayam_afkir'] > 0) {
            $this->ayamAfkir->create([
                'populasi_ayam_id' => $populasiAyam->id,
                'pic_user_id' => auth()->id(),
                'tanggal' => $validated['tanggal_transaksi'],
                'umur_ayam' => $validated['umur_ayam_record'],
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
                'tanggal' => $populasiAyam->tanggal,
                'pipe_asal_id' => @$validated['ayam_masuk_karantina'] ? $validated['pipe_id'] : null,
                'ayam_masuk_karantina' => @$validated['ayam_masuk_karantina'],
                'pipe_tujuan_id' => @$validated['ayam_keluar_karantina'] ? @$validated['pipe_id'] : null,
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
                'tanggal' => $populasiAyam->tanggal,
            ], [
                'pic_user_id' => $populasiAyam->pic_user_id,
                'total_ayam_karantina' => $currentKarantinaPopulasi,
            ]);
        }

        return back()->with('success', 'Data populasi berhasil disimpan.');
    }

    public function getRecordedPopulasi($kandangId, $tanggal)
    {
        return $this->populasiAyam
            ->whereRelation('pipe.flock', 'kandang_id', '=', $kandangId)
            ->where('tanggal', '=', $tanggal)
            ->with('pipe:id,nama')
            ->get();
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
