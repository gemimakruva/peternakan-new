<?php

namespace Modules\GudangTelur\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\GudangTelur\Enums\JenisPengiriman;
use Modules\GudangTelur\Enums\SupplierTipe;
use Modules\GudangTelur\Models\Supplier;
use Modules\GudangTelur\Repositories\MasterData\KemasanRepository;
use Modules\GudangTelur\Repositories\Supplier\SupplierRepository;

class SupplierController extends Controller
{
    public function __construct(
        private SupplierRepository $repository,
        private KemasanRepository $kemasanRepository,
    ) {
        $this->middleware('can:gudang-telur.supplier-kemasan.menu-supplier-kemasan');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        return view('gudang-telur::supplier.index', compact('datas'));
    }

    public function create()
    {
        return view('gudang-telur::supplier.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama'          => ['required', 'string', Rule::unique('supplier', 'nama')->where('tipe', SupplierTipe::KEMASAN->value)],
            'badan_usaha'   => ['nullable', 'string'],
            'kontak'        => ['nullable', 'string'],
            'alamat'        => ['nullable', 'string'],
            'lokasi'        => ['nullable', 'string'],
        ]);

        $validated['tipe']  = SupplierTipe::KEMASAN->value;
        $supplier = $this->repository->getModel()->create($validated);

        return to_route('gudang-telur.supplier.edit', $supplier)
            ->with('success', 'Data Supplier Berhasil Disimpan.');
    }

    public function edit(Supplier $supplier)
    {
        $supplier->load('supplierKemasan');
        $data = $supplier;
        $listKemasan = $this->kemasanRepository->getSelectItems();
        $listJenisPengiriman = JenisPengiriman::getSelectItems();
        return view('gudang-telur::supplier.edit', compact([
            'data', 
            'listKemasan',
            'listJenisPengiriman',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier) 
    {
        $request->validate([
            'nama'          => ['required', 'string', Rule::unique('supplier', 'nama')->where('tipe', SupplierTipe::KEMASAN->value)->ignoreModel($supplier)],
            'badan_usaha'   => ['nullable', 'string'],
            'kontak'        => ['nullable', 'string'],
            'alamat'        => ['nullable', 'string'],
            'lokasi'        => ['nullable', 'string'],
            'items.*'       => ['nullable', 'array'],
            'items.*.id'            => ['sometimes', 'numeric', 'exists:supplier_kemasan,id'],
            'items.*.kemasan_id'    => ['required', 'numeric', 'exists:kemasan,id'],
            'items.*.kode_barang'   => ['required', 'string'],
            'items.*.jenis_pengiriman'  => ['required', Rule::in(JenisPengiriman::getArrayValues())],
        ]);

        $supplier->fill($request->only(['nama', 'badan_usaha', 'kontak', 'alamat', 'lokasi']));
        $supplier->save();

        $savedSupplierKemasanIds = [];
        foreach ($request->input('items', []) as $item) {
            $supplierKemasan = $supplier->supplierKemasan()->updateOrCreate([
                'id'                => @$item['id'],
            ], [
                'kemasan_id'        => @$item['kemasan_id'],
                'kode_barang'       => @$item['kode_barang'],
                'jenis_pengiriman'  => @$item['jenis_pengiriman'],
            ]);
            $savedSupplierKemasanIds[] = $supplierKemasan->id;
        }
        $supplier->supplierKemasan()->whereNotIn('id', $savedSupplierKemasanIds)->delete();

        return to_route('gudang-telur.supplier.index')
            ->with('success', 'Data Supplier Berhasil Diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
