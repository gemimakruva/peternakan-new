<?php

namespace Modules\Kandang\Http\Controllers\PopulasiAyam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Repositories\PopulasiAyamRepository;
use Modules\Kandang\Services\PopulasiAyamService;

class PopulasiAyam2Controller extends Controller
{
    public function __construct(
        private PopulasiAyamRepository $repository,
        private KandangRepository $kandangRepository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            null,
            $request->collect(['kandang_id', 'tanggal']),
            $request->collect('orders'),
            $request->query('perPage', 10)
        );
        $listKandang = $this->kandangRepository->getSelectItems();
        return view('kandang::populasi-ayam-2.index', compact(['datas', 'listKandang']));
    }

    public function create()
    {
        $listKandang = $this->kandangRepository->getSelectItems();
        return view('kandang::populasi-ayam-2.create', compact(['listKandang']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kandang_id'    => ['required', 'exists:kandang,id'],
            'tanggal'       => ['required', 'date_format:Y-m-d', function ($attr, $value, $fail) use($request) {
                // invalid karena recording populasi sudah dilakukan sebelumnya.
                $isExists = $this->repository
                    ->getModel()
                    ->where('kandang_id', '=', $request->input('kandang_id'))
                    ->where('tanggal', '=', $request->input('tanggal'))
                    ->exists();
                if ($isExists) {
                    $fail('Recording Populasi Ayam Sudah Dilakukan Sebelumnya.');
                }
                
                // invalid karena tanggal data populasi terbaru.
                $isExists = $this->repository
                    ->getModel()
                    ->where('kandang_id', '=', $request->input('kandang_id'))
                    ->where('tanggal', '>', $request->input('tanggal'))
                    ->exists();
                if ($isExists) {
                    $fail('Tanggal recording populasi ayam tidak valid, tanggal kurang dari tanggal terakhir.');
                }
            }],
        ]);

        return to_route('populasi-ayam-2.create.detail', [$validated['kandang_id'], $validated['tanggal']])
            ->with('success', 'Inputkan Detail Populasi Ayam');
    }

    public function createDetail($kandangId, $tanggal)
    {
        $kandang = $this->kandangRepository->find($kandangId);
        return view('kandang::populasi-ayam-2.create-detail', compact(['kandang']));
    }

    public function edit($kandangId, $tanggal)
    {
        $kandang = $this->kandangRepository->find($kandangId);
        return view('kandang::populasi-ayam-2.edit', compact(['kandang']));
    }

    public function update(Request $request, $kandangId, $tanggal)
    {
        $request->validate([
            'items.*.ayam_mati' => [function ($attr, $value, $fail) use($request) {
                $index = explode('.', $attr)[1];
                $ayamSehatBefore = $request->integer("items.$index.ayam_sehat_before");
                $ayamMati = $request->integer("items.$index.ayam_mati");
                if ($ayamMati > $ayamSehatBefore) {
                    $fail("Ayam Mati tidak boleh lebih besar dari ayam sehat sebelumnya");
                }
            }],
            'items.*.ayam_afkir' => [function ($attr, $value, $fail) use($request) {
                $index = explode('.', $attr)[1];
                $ayamSehatBefore = $request->integer("items.$index.ayam_sehat_before");
                $ayamAfkir = $request->integer("items.$index.ayam_afkir");
                if ($ayamAfkir > $ayamSehatBefore) {
                    $fail("Ayam Afkir tidak boleh lebih besar dari ayam sehat sebelumnya");
                }
            }],
            'items.*.ayam_masuk_karantina' => [function ($attr, $value, $fail) use($request) {
                $index = explode('.', $attr)[1];
                $ayamSehatBefore = $request->integer("items.$index.ayam_sehat_before");
                $ayamMasukKarantina = $request->integer("items.$index.ayam_masuk_karantina");
                if ($ayamMasukKarantina > $ayamSehatBefore) {
                    $fail("Ayam Afkir tidak boleh lebih besar dari ayam sehat sebelumnya");
                }
            }],
            'items.*.ayam_keluar_karantina' => [function ($attr, $value, $fail) use($request) {
                $index = explode('.', $attr)[1];
                $ayamSakitSebelumnya = $request->integer("total_ayam_karantina");
                $ayamKeluarKarantina = $request->integer("items.$index.ayam_keluar_karantina");
                if ($ayamKeluarKarantina > $ayamSakitSebelumnya) {
                    $fail("Ayam Keluar Karantina tidak boleh lebih besar dari ayam sakit sebelumnya.");
                }
            }],
        ]);

        $items = $request->collect('items')->map(function($item) use($request, $kandangId, $tanggal) {
            $item['kandang_id'] = $kandangId;
            $item['tanggal']    = $tanggal;
            $item['umur_ayam']  = $request->input('umur_ayam');
            return $item;
        });

        DB::beginTransaction();
        try {
            app(PopulasiAyamService::class)->savePopulasiAyam2($items);
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
}