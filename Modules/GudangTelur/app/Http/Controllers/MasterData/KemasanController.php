<?php

namespace Modules\GudangTelur\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\GudangTelur\Models\Kemasan;
use Modules\GudangTelur\Repositories\MasterData\KemasanRepository;
use Modules\GudangTelur\Repositories\MasterData\SatuanRepository;

class KemasanController extends Controller
{
    public function __construct(
        private KemasanRepository $repository,
        private SatuanRepository $satuanRepository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        return view('gudang-telur::master-data.kemasan.index', compact('datas'));
    }

    public function create()
    {
        $listSatuan = $this->satuanRepository->getSelectItems();
        return view('gudang-telur::master-data.kemasan.create', compact(['listSatuan']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'satuan_id' => ['required', 'int', 'exists:satuan,id'],
            'nama'      => ['required', 'string', 'unique:kemasan,nama'],
        ]);

        $kemasan = $this->repository->create($validated);

        return to_route('gudang-telur.master-data.kemasan.edit', $kemasan)
            ->with('success', 'Data Kemasan Berhasil Disimpan.');
    }

    public function edit(Kemasan $kemasan)
    {
        $data = $kemasan;
        $listSatuan = $this->satuanRepository->getSelectItems();
        return view('gudang-telur::master-data.kemasan.edit', compact(['listSatuan', 'data']));
    }

    public function update(Request $request, Kemasan $kemasan)
    {
        $validated = $request->validate([
            'satuan_id' => ['required', 'int', 'exists:satuan,id'],
            'nama'      => ['required', 'string', Rule::unique('kemasan', 'nama')->ignoreModel($kemasan)],            
        ]);

        $kemasan->fill($validated);
        $kemasan->save();

        return to_route('gudang-telur.master-data.kemasan.edit', $kemasan)
            ->with('success', 'Data Kemasan Berhasil Diupdate.');
    }
}