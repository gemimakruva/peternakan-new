<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Models\BahanPakanPembelian;
use Modules\GudangPakan\Repositories\BahanPakanPembelianRepository;
use Modules\GudangPakan\Repositories\MasterData\BahanPakanRepository;
use Modules\GudangPakan\Repositories\SupplierRepository;

class BahanPakanPembelianController extends Controller
{
    public function __construct(
        private BahanPakanRepository $bahanPakanRepository,
        private BahanPakanPembelianRepository $repository,
        private SupplierRepository $supplierRepository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['supplier_id']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        $listSupplier = $this->supplierRepository->getSelectItems();
        return view('gudang-pakan::bahan-pakan-pembelian.index', compact([
            'datas',
            'listSupplier',
        ]));
    }

    public function create()
    {
        $listSupplier = $this->supplierRepository->getSelectItems();
        return view('gudang-pakan::bahan-pakan-pembelian.create', compact([
            'listSupplier',
        ]));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'supplier_id'       => ['required', 'exists:supplier,id'],
            'tanggal_pesan'     => ['required', 'date_format:Y-m-d'],
            'tanggal_datang'    => ['required', 'date_format:Y-m-d'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $bahanPakanPembelian = $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-pembelian.edit', $bahanPakanPembelian)
            ->with('success', 'Pembelian Bahan Pakan Berhasil Ditambahkan.');
    }

    public function edit(BahanPakanPembelian $bahanPakanPembelian)
    {
        $bahanPakanPembelian->load('bahanPakanPembelianItem');
        $data = $bahanPakanPembelian;
        $listSupplier = $this->supplierRepository->getSelectItems();
        $listBahanPakan = $this->bahanPakanRepository->getSelectItemsWithSatuan($bahanPakanPembelian->supplier_id);
        
        return view('gudang-pakan::bahan-pakan-pembelian.edit', compact([
            'data',
            'listSupplier',
            'listBahanPakan',
        ]));
    }

    public function update(Request $request, BahanPakanPembelian $bahanPakanPembelian) 
    {
        $validated = $request->validate([
            'tanggal_pesan'     => ['required', 'date_format:Y-m-d'],
            'tanggal_datang'    => ['required', 'date_format:Y-m-d'],
            'items.*'           => ['required', 'array'],
            'items.*.bahan_pakan_id'    => ['required', 'exists:bahan_pakan,id'],
            'items.*.harga_satuan'      => ['required', 'numeric', 'min:0'],
            'items.*.jumlah'            => ['required', 'numeric', 'min:0'],
        ]);

        $validated['id'] = $bahanPakanPembelian->id;
        $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-pembelian.index')
            ->with('success', 'Pembelian Pakan Berhasil Diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
