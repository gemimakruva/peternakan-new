<?php

namespace Modules\GudangTelur\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Models\KemasanInput;
use Modules\GudangTelur\Repositories\Kemasan\KemasanInputRepository;
use Modules\GudangTelur\Repositories\Supplier\SupplierRepository;
use Modules\Kandang\Repositories\User\UserRepository;

class KemasanInputController extends Controller
{
    public function __construct(
        private KemasanInputRepository $repository,
        private UserRepository $userRepository,
        private SupplierRepository $supplierRepository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['pic_user_id', 'supplier_id']),
            $request->collect('orders'),
            $request->query('perPage', 10), 
        );
        $listUsers = $this->userRepository->getSelectItems('name');
        $listSupplier = $this->supplierRepository->getSelectItems();
        return view('gudang-telur::kemasan.input.index', compact([
            'datas', 
            'listUsers', 
            'listSupplier'
        ]));
    }

    public function create()
    {
        $listSupplier = $this->supplierRepository->getSelectItems();
        return view('gudang-telur::kemasan.input.create', compact([
            'listSupplier',
        ]));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id'   => ['required', 'exists:supplier,id'],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
            'items.*'       => ['required', 'array'],
            'items.*.kemasan_id'    => ['required', 'exists:kemasan,id'],
            'items.*.jumlah'        => ['required', 'numeric'],
        ]);

        $validated['pic_user_id'] = auth()->id();

        $kemasanInput = $this->repository->save($validated);

        return to_route('gudang-telur.kemasan-input.edit', $kemasanInput->id)
            ->with('success', 'Kemasan Input Berhasil Disimpan.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('gudangtelur::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KemasanInput $kemasanInput)
    {
        $listSupplier = $this->supplierRepository->getSelectItems();
        $kemasanInput->load('kemasanInventory');
        $data = $kemasanInput;
        return view('gudang-telur::kemasan.input.edit', compact(['listSupplier', 'data']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KemasanInput $kemasanInput)
    {
        $validated = $request->validate([
            'supplier_id'   => ['required', 'exists:supplier,id'],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
            'items.*'       => ['required', 'array'],
            'items.*.kemasan_id'    => ['required', 'exists:kemasan,id'],
            'items.*.jumlah'        => ['required', 'numeric'],
        ]);

        $validated['id'] = $kemasanInput->id;
        $validated['pic_user_id'] = auth()->id();

        $kemasanInput = $this->repository->save($validated);

        return to_route('gudang-telur.kemasan-input.edit', $kemasanInput->id)
            ->with('success', 'Kemasan Input Berhasil Disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
