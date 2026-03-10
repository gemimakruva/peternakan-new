<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\GudangPakan\Enums\BahanPakanKeluarTujuan;
use Modules\GudangPakan\Models\BahanPakanKeluar;
use Modules\GudangPakan\Repositories\BahanPakanKeluarRepository;
use Modules\GudangPakan\Repositories\MasterData\BahanPakanRepository;

class BahanPakanKeluarController extends Controller
{
    public function __construct(
        private BahanPakanKeluarRepository $repository,
        private BahanPakanRepository $bahanPakanRepository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['tujuan']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        $listTujuan = BahanPakanKeluarTujuan::getSelectItems2();
        return view('gudang-pakan::bahan-pakan-keluar.index', compact([
            'datas', 'listTujuan'
        ]));
    }

    public function create()
    {
        $listTujuan = BahanPakanKeluarTujuan::getSelectItems2();
        return view('gudang-pakan::bahan-pakan-keluar.create', compact(['listTujuan']));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'tujuan' => ['required', 'string', Rule::in(BahanPakanKeluarTujuan::getArrayValues())],
            'tanggal' => ['required', 'date_format:Y-m-d'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $bahanPakanKeluar = $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-keluar.edit', $bahanPakanKeluar)
            ->with('success', 'Data Bahan Pakan Berhasil Disimpan.');
    }

    public function edit(BahanPakanKeluar $bahanPakanKeluar)
    {
        $data = $bahanPakanKeluar;
        $listTujuan = BahanPakanKeluarTujuan::getSelectItems2();
        $listBahanPakan = $this->bahanPakanRepository->getSelectItemsWithSaldo();
        return view('gudang-pakan::bahan-pakan-keluar.edit', compact([
            'data', 'listTujuan', 'listBahanPakan',
        ]));
    }

    public function update(Request $request, BahanPakanKeluar $bahanPakanKeluar)
    {
        $validated = $request->validate([
            'tujuan' => ['required', 'string', Rule::in(BahanPakanKeluarTujuan::getArrayValues())],
            'tanggal' => ['required', 'date_format:Y-m-d'],
            'items.*' => ['nullable', 'array'],
            'items.*.id' => ['nullable', 'exists:bahan_pakan_inventory,id'],
            'items.*.bahan_pakan_id' => ['required', 'exists:bahan_pakan,id'],
            'items.*.jumlah' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['id'] = $bahanPakanKeluar->id;
        $validated['pic_user_id'] = auth()->id();
        $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-keluar.index')
            ->with('success', 'Data Bahan Pakan Keluar Berhasil Diupdate.');
    }

    public function destroy(BahanPakanKeluar $bahanPakanKeluar)
    {
        $bahanPakanKeluar->delete();
        return back()->with('success', 'Data Bahan Pakan Keluar Berhasil Dihapus.');
    }
}
