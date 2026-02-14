<?php

namespace Modules\Kandang\Http\Controllers\MonitoringKesehatan;

use App\Http\Controllers\Controller;
use Modules\Kandang\Http\Requests\MonitoringKesehatan\IndexRequest;
use Modules\Kandang\Http\Requests\MonitoringKesehatan\StoreRequest;
use Modules\Kandang\Http\Requests\MonitoringKesehatan\UpdateRequest;
use Modules\Kandang\Models\MonitoringKesehatan;
use Modules\Kandang\Services\KandangService;
use Modules\Kandang\Services\MonitoringKesehatanService;

class MonitoringKesehatanController extends Controller
{
    public function __construct(
        private MonitoringKesehatanService $service,
        private KandangService $kandangService
    ) {
        $this->middleware('can:kandang.monitoring.menu-monitoring-kesehatan');
    }

    public function index(IndexRequest $request)
    {
        $data    = $this->service->getDatatable($request->validated());
        $kandang = $this->kandangService->all();

        return view('kandang::monitoring-kesehatan.index', compact('data', 'kandang'));
    }

    public function create()
    {
        return view('kandang::monitoring-kesehatan.create');
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

        return redirect()->route('monitoring-kesehatan.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show(MonitoringKesehatan $monitoringKesehatan)
    {
        return view('kandang::monitoring-kesehatan.show', compact('monitoringKesehatan'));
    }

    public function edit(MonitoringKesehatan $monitoringKesehatan)
    {
        return view('kandang::monitoring-kesehatan.edit', compact('monitoringKesehatan'));
    }

    public function update(UpdateRequest $request, MonitoringKesehatan $monitoringKesehatan)
    {
        try {
            $this->service->update($request->validated(), $monitoringKesehatan);
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Gagal memperbarui data karena ' . $th->getMessage());
        }

        return redirect()->route('monitoring-kesehatan.index')
            ->with('success', 'Data berhasil diubah');
    }

    public function destroy($id) {}
}
