<?php

namespace Modules\GudangTelur\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Models\KemasanOutput;
use Modules\GudangTelur\Repositories\Kemasan\KemasanInventoryRepository;
use Modules\GudangTelur\Repositories\Kemasan\KemasanOutputRepository;

class KemasanOutputController extends Controller
{
    public function __construct(
        private KemasanInventoryRepository $kemasanInventoryRepository,
        private KemasanOutputRepository $repository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10)
        );
        return view('gudang-telur::kemasan.output.index', compact('datas'));
    }

    public function create()
    {
        $listKemasanInventory = $this->kemasanInventoryRepository->getQuery()->get();
        return view('gudang-telur::kemasan.output.create', compact(['listKemasanInventory']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.kemasan_id'    => ['nullable', 'numeric', 'exists:kemasan,id'],
            'items.*.jumlah'        => ['nullable', 'numeric'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $kemasanOutput = $this->repository->save($validated);

        return to_route('gudang-telur.kemasan-output.edit', $kemasanOutput)
            ->with('success', 'Data Kemasan Berhasil Disimpan.');
    }
    

    public function edit(KemasanOutput $kemasanOutput)
    {
        $kemasanOutput->load('kemasanInventory');
        $data = $kemasanOutput;
        $listKemasanInventory = $this->kemasanInventoryRepository->context($kemasanOutput->id)->getQuery()->get();
        return view('gudang-telur::kemasan.output.edit', compact(['data', 'listKemasanInventory']));
    }

    public function update(Request $request, $id) 
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.id'            => ['nullable', 'numeric'],
            'items.*.kemasan_id'    => ['nullable', 'numeric', 'exists:kemasan,id'],
            'items.*.jumlah'        => ['nullable', 'numeric'],
        ]);

        $validated['id']    = $id;
        $kemasanOutput = $this->repository->save($validated);

        return to_route('gudang-telur.kemasan-output.edit', $kemasanOutput)
            ->with('success', 'Data Kemasan Berhasil Diupdate.');
    }

    public function destroy(KemasanOutput $kemasanOutput)
    {
        $kemasanOutput->kemasanInventory()->delete();
        $kemasanOutput->delete();

        return back()->with('success', 'Data Kemasan Opname Berhasil Dihapus.');
    }
}
