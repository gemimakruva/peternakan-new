<?php

namespace Modules\Kandang\Http\Controllers\Disinfektan;

use App\Http\Controllers\Controller;
use Modules\Kandang\Http\Requests\PenjadwalanDisinfektan\IndexRequest;
use Modules\Kandang\Http\Requests\PenjadwalanDisinfektan\StoreRequest;
use Modules\Kandang\Http\Requests\PenjadwalanDisinfektan\UpdateRequest;
use Modules\Kandang\Models\PenjadwalanDisinfektan;
use Modules\Kandang\Services\KandangService;
use Modules\Kandang\Services\PenjadwalanDisinfektanService;

class PenjadwalanDisinfektanController extends Controller
{
    public function __construct(
        private PenjadwalanDisinfektanService $service,
        private KandangService $kandangService
    ) {}

    public function index(IndexRequest $request)
    {
        $data    = $this->service->getDatatable($request->validated());
        $kandang = $this->kandangService->all();

        return view('kandang::penjadwalan-disinfektan.index', compact('data', 'kandang'));
    }

    public function create()
    {
        $jenisDisinfektan = $this->service->getJenisDisinfektan()->toArray();

        return view('kandang::penjadwalan-disinfektan.create', compact('jenisDisinfektan'));
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

        return redirect()->route('penjadwalan-disinfektan.index');
    }

    public function show(PenjadwalanDisinfektan $penjadwalanDisinfektan) {}

    public function getDetail(PenjadwalanDisinfektan $penjadwalanDisinfektan)
    {
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil.',
            'data'    => $penjadwalanDisinfektan->load(['kandang', 'penjadwalanFlocks.flock', 'penjadwalanFlocks.jenisDisinfektan']),
        ]);
    }

    public function edit(PenjadwalanDisinfektan $penjadwalanDisinfektan)
    {
        $jenisDisinfektan = $this->service->getJenisDisinfektan()->toArray();

        return view('kandang::penjadwalan-disinfektan.edit', compact('penjadwalanDisinfektan', 'jenisDisinfektan'));
    }

    public function update(UpdateRequest $request, PenjadwalanDisinfektan $penjadwalanDisinfektan)
    {
        try {
            $this->service->update($request->validated(), $penjadwalanDisinfektan);
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Gagal memperbarui data karena ' . $th->getMessage());
        }

        return redirect()->route('penjadwalan-disinfektan.index')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy(PenjadwalanDisinfektan $model)
    {
        $this->service->delete($model);

        return redirect()->route('penjadwalan-disinfektan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
