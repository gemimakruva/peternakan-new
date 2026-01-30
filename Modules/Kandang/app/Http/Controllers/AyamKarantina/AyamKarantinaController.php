<?php

namespace Modules\Kandang\Http\Controllers\AyamKarantina;

use App\Http\Controllers\Controller;
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
        $listKarantinaPopulasi = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        return view('kandang::ayam-karantina.index', compact('listKarantinaPopulasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KarantinaPopulasi $karantinaPopulasi)
    {
        $listKandang = $this->kandang->get();
        $karantinaPopulasi->load([
            'kandang:id,nama',
            'picUser:id,name',
        ]);
        $data = $karantinaPopulasi;

        return view("kandang::ayam-karantina.edit", compact(['listKandang', 'data']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, KarantinaPopulasi $karantinaPopulasi)
    {
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
        $listAyamKarantina = KarantinaPopulasi::orderBy('created_at', 'desc')->limit(5)->get();
        return view('kandang::ayam-karantina.overview', compact('listAyamKarantina'));
    }
}
