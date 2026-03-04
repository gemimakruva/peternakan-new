<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\GudangPakan\Repositories\MasterData\BahanPakanRepository;
use Modules\GudangPakan\Repositories\SupplierRepository;
use Modules\GudangTelur\Enums\SupplierTipe;
use Modules\GudangTelur\Models\Supplier;

class SupplierBahanPakanController extends Controller
{
    public function __construct(
        private SupplierRepository $supplierRepository,
        private BahanPakanRepository $bahanPakanRepository,
    ) {
        $this->middleware('can:gudang-pakan.supplier-bahan-pakan.menu-supplier-bahan-pakan');
    }

    public function index(Request $request)
    {
        $datas = $this->supplierRepository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('gudang-pakan::supplier-bahan-pakan.index', compact(['datas']));
    }

    public function create()
    {
        return view('gudang-pakan::supplier-bahan-pakan.create');
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'nama'      => [
                'required',
                'string',
                Rule::unique('supplier', 'nama')->where('tipe', SupplierTipe::BAHAN_PAKAN->value)
            ],
            'badan_usaha'   => ['nullable', 'string'],
            'kontak'        => ['nullable', 'string'],
            'alamat'        => ['nullable', 'string'],
            'lokasi'        => ['nullable', 'string'],
        ]);

        $supplier = $this->supplierRepository->save($validated);

        return to_route('gudang-pakan.supplier-bahan-pakan.edit', $supplier)
            ->with('success', 'Data Supplier Bahan Pakan Berhasil Disimpan.');
    }

    public function edit(Supplier $supplier)
    {
        $data = $supplier;
        $listBahanPakan = $this->bahanPakanRepository->getSelectItems();
        return view('gudang-pakan::supplier-bahan-pakan.edit', compact([
            'data',
            'listBahanPakan',
        ]));
    }

    public function update(Request $request, Supplier $supplier) 
    {
        $validated = $request->validate([
            'nama'      => [
                'required',
                'string',
                Rule::unique('supplier', 'nama')->where('tipe', SupplierTipe::BAHAN_PAKAN->value)->ignoreModel($supplier)
            ],
            'badan_usaha'   => ['nullable', 'string'],
            'kontak'        => ['nullable', 'string'],
            'alamat'        => ['nullable', 'string'],
            'lokasi'        => ['nullable', 'string'],

            'items.*'       => ['required', 'array'],
            'items.*.id'    => ['nullable', 'exists:supplier_bahan_pakan,id'],
            'items.*.bahan_pakan_id' => ['nullable', 'exists:bahan_pakan,id'],
        ]);

        $validated['id']    = $supplier->id;
        $this->supplierRepository->save($validated);

        return to_route('gudang-pakan.supplier-bahan-pakan.index')
            ->with('success', 'Data Supplier Bahan Pakan Berhasil Diupdate.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->supplierBahanPakan()->delete();
        $supplier->delete();

        return back()->with('success', 'Data Supplier Bahan Pakan Berhasil Dihapus.');
    }
}
