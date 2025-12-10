<?php

namespace Modules\Kandang\Http\Controllers\Disinfektan;

use App\Http\Controllers\Controller;
use Modules\Kandang\Http\Requests\PenjadwalanDisinfektan\StoreRequest;
use Modules\Kandang\Http\Requests\PenjadwalanDisinfektan\UpdateRequest;
use Modules\Kandang\Models\PenjadwalanDisinfektan;
use Modules\Kandang\Services\PenjadwalanDisinfektanService;

class PenjadwalanDisinfektanController extends Controller
{
    public function __construct(private PenjadwalanDisinfektanService $service) {}

    public function index()
    {
        return view('kandang::penjadwalan-disinfektan.index');
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

        return redirect()->route('kandang::penjadwalan-disinfektan.index');
    }

    public function show(PenjadwalanDisinfektan $penjadwalanDisinfektan)
    {
        dd($penjadwalanDisinfektan->toArray());
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

        return redirect()->route('kandang.penjadwalan-disinfektan.index')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy(PenjadwalanDisinfektan $model)
    {
        $this->service->delete($model);

        return redirect()->route('kandang.penjadwalan-disinfektan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
