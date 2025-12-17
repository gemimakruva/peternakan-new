<?php

namespace Modules\Kandang\Http\Controllers\PerhitunganObat;

use App\Http\Controllers\Controller;
use Modules\Kandang\Http\Requests\VitaminObatMinum\IndexRequest;
use Modules\Kandang\Http\Requests\VitaminObatMinum\StoreRequest;
use Modules\Kandang\Http\Requests\VitaminObatMinum\UpdateRequest;
use Modules\Kandang\Models\VitaminObatMinum;
use Modules\Kandang\Services\KandangService;
use Modules\Kandang\Services\PerhitunganObat\VitaminObatMinumService;

class VitaminObatMinumController extends Controller
{
    public function __construct(
        private VitaminObatMinumService $service,
        private KandangService $kandangService
    ) {}

    public function index(IndexRequest $request)
    {
        $data    = $this->service->getDatatable($request->validated());
        $kandang = $this->kandangService->all();

        return view('kandang::vitamin-obat-minum.index', compact('data', 'kandang'));
    }

    public function create()
    {
        $jenisTreatment = $this->service->getJenisTreatment();

        return view('kandang::vitamin-obat-minum.create', compact('jenisTreatment'));
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->service->store($request->validated());
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Gagal Menyimpan karena ' . $th->getMessage());
        }

        return redirect()->route('perhitungan-obat.vitamin-obat-minum.index');
    }

    public function show($id)
    {
        return view('kandang::vitamin-obat-minum.show');
    }

    public function edit(VitaminObatMinum $vitaminObatMinum)
    {
        $jenisTreatment                         = $this->service->getJenisTreatment();
        $vitaminObatMinum->jumlah_ovk_per_baris = round($vitaminObatMinum->jumlah_air_di_tong_per_baris * ($vitaminObatMinum->dosis_pemberian / $vitaminObatMinum->satuan_per_dosis), 3);

        return view('kandang::vitamin-obat-minum.edit', compact('vitaminObatMinum', 'jenisTreatment'));
    }

    public function update(UpdateRequest $request, VitaminObatMinum $vitaminObatMinum)
    {
        try {
            $this->service->update($request->validated(), $vitaminObatMinum);
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Gagal memperbarui data karena ' . $th->getMessage());
        }

        return redirect()->route('perhitungan-obat.vitamin-obat-minum.index')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy($id) {}
}
