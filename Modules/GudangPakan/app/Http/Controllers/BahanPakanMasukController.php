<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\GudangPakan\Enums\BahanPakanMasukAsal;
use Modules\GudangPakan\Models\BahanPakanMasuk;
use Modules\GudangPakan\Repositories\BahanPakanMasukRepository;
use Modules\GudangPakan\Repositories\MasterData\BahanPakanRepository;
use Modules\GudangPakan\Repositories\SupplierRepository;

class BahanPakanMasukController extends Controller
{
    public function __construct(
        private BahanPakanMasukRepository $repository,
        private BahanPakanRepository $bahanPakanRepository,
        private SupplierRepository $supplierRepository,
    ) { 
        $this->middleware('can:gudang-pakan.bahan-pakan-masuk.menu-bahan-pakan-masuk');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['supplier_id', 'asal']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        $listAsal = BahanPakanMasukAsal::getSelectItems();
        $listSupplier = $this->supplierRepository->getSelectItems();
        return view('gudang-pakan::bahan-pakan-masuk.index', compact([
            'datas',
            'listAsal',
            'listSupplier',
        ]));
    }

    public function create()
    {
        $listSupplier = $this->supplierRepository->getSelectItems();
        $listAsal = BahanPakanMasukAsal::getSelectItems2();
        return view('gudang-pakan::bahan-pakan-masuk.create', compact([
            'listSupplier',
            'listAsal',
        ]));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'supplier_id'   => ['nullable', 'exists:supplier,id'],
            'asal'          => ['required', Rule::in(BahanPakanMasukAsal::getArrayValues())],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $bahanPakanMasuk = $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-masuk.edit', $bahanPakanMasuk)
            ->with('success', 'Data Bahan Pakan Masuk Berhasil Disimpan.');
    }

    public function edit(BahanPakanMasuk $bahanPakanMasuk)
    {
        if ($bahanPakanMasuk->asal === BahanPakanMasukAsal::DARI_PEMBELIAN) {
            return to_route('gudang-pakan.bahan-pakan-pembelian.edit', $bahanPakanMasuk->bahan_pakan_pembelian_id);
        }
        $bahanPakanMasuk->load('bahanPakanInventory');
        $data = $bahanPakanMasuk;
        $listSupplier = $this->supplierRepository->getSelectItems();
        $listAsal = BahanPakanMasukAsal::getSelectItems2();
        $listBahanPakan = $this->bahanPakanRepository->getSelectItemsWithSatuan($bahanPakanMasuk->supplier_id);

        return view('gudang-pakan::bahan-pakan-masuk.edit', compact([
            'data',
            'listSupplier',
            'listAsal',
            'listBahanPakan',
        ]));
    }

    public function update(Request $request, BahanPakanMasuk $bahanPakanMasuk) 
    {
        $validated = $request->validate([
            'supplier_id'   => ['sometimes', 'exists:supplier,id'],
            'asal'          => ['required', Rule::in(BahanPakanMasukAsal::getArrayValues())],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
            'items.*'       => ['required', 'array'],
            'items.*.bahan_pakan_id'    => ['required', 'exists:bahan_pakan,id'],
            'items.*.jumlah'            => ['required', 'numeric'],
        ]);

        $validated['id']    = $bahanPakanMasuk->id;
        $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-masuk.index')
            ->with('success', 'Data Bahan Pakan Masuk Berhasil Diupdate.');
    }

    public function destroy($id) 
    {
        $this->repository->delete($id);
        return to_route('gudang-pakan.bahan-pakan-masuk.index')
            ->with('success', 'Data Bahan Pakan Masuk Berhasil Dihapus.');
    }
}
