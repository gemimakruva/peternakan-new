<?php

namespace Modules\GudangPakan\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\GudangPakan\Models\BahanBaku;
use Modules\GudangPakan\Repositories\MasterData\BahanBakuRepository;
use Modules\GudangTelur\Enums\BahanBakuTipe;

class BahanBakuController extends Controller
{
    public function __construct(
        private BahanBakuRepository $repository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['tipe']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        $listTipe = BahanBakuTipe::getSelectItems();
        return view('gudang-pakan::master-data.bahan-baku.index', compact([
            'datas',
            'listTipe',
        ]));
    }

    public function create()
    {
        $listTipe = BahanBakuTipe::getSelectItems();
        return view('gudang-pakan::master-data.bahan-baku.create', compact(['listTipe']));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'tipe'  => ['required', 'string', Rule::in(BahanBakuTipe::getArrayValues())],
            'nama'  => ['required', 'string', Rule::unique('bahan_baku', 'nama')],
        ]);

        $bahanBaku = $this->repository->save($validated);

        return to_route('gudang-pakan.master-data.bahan-baku.edit', $bahanBaku)
            ->with('success', 'Bahan Baku Berhasil Disimpan.');
    }

    public function edit(BahanBaku $bahanBaku)
    {
        $data = $bahanBaku;
        $listTipe = BahanBakuTipe::getSelectItems();
        return view('gudang-pakan::master-data.bahan-baku.edit', compact([
            'data',
            'listTipe',
        ]));
    }

    public function update(Request $request, BahanBaku $bahanBaku) 
    {
        $validated = $request->validate([
            'tipe'  => ['required', 'string', Rule::in(BahanBakuTipe::getArrayValues())],
            'nama'  => ['required', 'string', Rule::unique('bahan_baku', 'nama')->ignoreModel($bahanBaku)],
        ]);

        $validated['id'] = $bahanBaku->id;
        $this->repository->save($validated);

        return to_route('gudang-pakan.master-data.bahan-baku.index')
            ->with('success', 'Bahan Baku Berhasil Diupdate.');
    }

    public function destroy(BahanBaku $bahanBaku) 
    {
        $bahanBaku->delete();

        return back()->with('success', 'Bahan Baku Berhasil Dihapus');
    }
}
