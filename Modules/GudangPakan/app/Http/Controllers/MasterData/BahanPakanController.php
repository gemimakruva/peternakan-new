<?php

namespace Modules\GudangPakan\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\GudangPakan\Models\BahanPakan;
use Modules\GudangPakan\Repositories\MasterData\BahanPakanRepository;
use Modules\GudangPakan\Enums\BahanPakanTipe;

class BahanPakanController extends Controller
{
    public function __construct(
        private BahanPakanRepository $repository,
    ) {
        $this->middleware('can:master-data.master-data.menu-bahan-pakan');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['tipe']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        $listTipe = BahanPakanTipe::getSelectItems();
        return view('gudang-pakan::master-data.bahan-pakan.index', compact([
            'datas',
            'listTipe',
        ]));
    }

    public function create()
    {
        $listTipe = BahanPakanTipe::getSelectItems();
        return view('gudang-pakan::master-data.bahan-pakan.create', compact(['listTipe']));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'tipe'  => ['required', 'string', Rule::in(BahanPakanTipe::getArrayValues())],
            'nama'  => ['required', 'string', Rule::unique('bahan_pakan', 'nama')],
        ]);

        $bahanPakan = $this->repository->save($validated);

        return to_route('gudang-pakan.master-data.bahan-pakan.edit', $bahanPakan)
            ->with('success', 'Bahan Pakan Berhasil Disimpan.');
    }

    public function edit(BahanPakan $bahanPakan)
    {
        $data = $bahanPakan;
        $listTipe = BahanPakanTipe::getSelectItems();
        return view('gudang-pakan::master-data.bahan-pakan.edit', compact([
            'data',
            'listTipe',
        ]));
    }

    public function update(Request $request, BahanPakan $bahanPakan) 
    {
        $validated = $request->validate([
            'tipe'  => ['required', 'string', Rule::in(BahanPakanTipe::getArrayValues())],
            'nama'  => ['required', 'string', Rule::unique('bahan_pakan', 'nama')->ignoreModel($bahanPakan)],
        ]);

        $validated['id'] = $bahanPakan->id;
        $this->repository->save($validated);

        return to_route('gudang-pakan.master-data.bahan-pakan.index')
            ->with('success', 'Bahan Pakan Berhasil Diupdate.');
    }

    public function destroy(BahanPakan $bahanPakan) 
    {
        $bahanPakan->delete();

        return back()->with('success', 'Bahan Pakan Berhasil Dihapus');
    }
}
