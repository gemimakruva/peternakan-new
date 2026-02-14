<?php

namespace Modules\Kandang\Http\Controllers\AyamKarantina;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Kandang\Http\Requests\AyamKarantina\StoreRequest;
use Modules\Kandang\Http\Requests\AyamKarantina\UpdateRequest;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\KarantinaPopulasi;
use Illuminate\Http\Request;
use Modules\Kandang\Repositories\Karantina\KarantinaPopulasiRepository;

class AyamKarantinaController extends Controller
{
    public function __construct(
        private KarantinaPopulasiRepository $repository,
        private KarantinaPopulasi $karantinaPopulasi,
        private Kandang $kandang,
    ) { }

    public function index(Request $request)
    {
        Gate::authorize('kandang.populasi.menu-karantina-ayam');

        $listKarantinaPopulasi = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        $listKandang = $this->kandang->orderBy('nama')->pluck('nama', 'id')->toArray();

        return view('kandang::ayam-karantina.index', compact(['listKarantinaPopulasi', 'listKandang']));
    }

    public function create()
    {
        Gate::authorize('kandang.populasi.menu-karantina-ayam');

        $listKandang = $this->kandang->orderBy('nama')->pluck('nama', 'id')->toArray();

        return view("kandang::ayam-karantina.create", compact("listKandang"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KarantinaPopulasi $karantinaPopulasi)
    {
        Gate::authorize('kandang.populasi.menu-karantina-ayam');

        $karantinaPopulasi->load([
            'kandang:id,nama',
            'picUser:id,name',
        ]);

        $data = $karantinaPopulasi;

        return view("kandang::ayam-karantina.edit", compact('data'));
    }

    public function store(StoreRequest $request)
    {
        Gate::authorize('kandang.populasi.menu-karantina-ayam');

        $request->merge([
            'pic_user_id' => auth()->id(),
        ]);

        $this->karantinaPopulasi->fill($request->only([
            'kandang_id',
            'pic_user_id',
            'total_ayam_karantina',
            'tanggal',
            'ayam_mati',
            'ayam_afkir',
            'pemberian_pakan',
            'sisa_pakan',
            'jumlah_telur_bagus',
            'jumlah_telur_retak',
            'jumlah_telur_rusak',
            'berat_telur_bagus',
            'berat_telur_retak',
            'berat_telur_rusak',
            'pengobatan_yang_dilakukan',
            'jumlah_ayam_diobati',
            'penyemprotan',
            'vaksin',
            'catatan',
        ]));
        $this->karantinaPopulasi->save();
        return to_route('ayam-karantina.index')->with('success', 'Ayam Karantina berhasil dibuat.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, KarantinaPopulasi $karantinaPopulasi)
    {
        Gate::authorize('kandang.populasi.menu-karantina-ayam');

        $karantinaPopulasi->fill($request->only([
            "ayam_mati",
            "ayam_afkir",
            "pemberian_pakan",
            "sisa_pakan",
            "jumlah_telur_bagus",
            "jumlah_telur_retak",
            "jumlah_telur_rusak",
            "berat_telur_bagus",
            "berat_telur_retak",
            "berat_telur_rusak",
            "pengobatan_yang_dilakukan",
            "jumlah_ayam_diobati",
            "penyemprotan",
            "vaksin",
            "catatan",
        ]));
        $karantinaPopulasi->save();

        return to_route('ayam-karantina.index')->with('success', 'Ayam Karantina berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function overview()
    {
        Gate::authorize('kandang.populasi.menu-rekapan-karantina');
        $listAyamKarantina = KarantinaPopulasi::orderBy('created_at', 'desc')->limit(5)->get();
        return view('kandang::ayam-karantina.overview', compact('listAyamKarantina'));
    }
}
