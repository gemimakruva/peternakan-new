<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Models\PakanFinishedGoodDistribusi;
use Modules\GudangPakan\Repositories\BahanPakanFormulasiRepository;
use Modules\GudangPakan\Repositories\PakanFinishedGoodDistribusiRepository;

class PakanFinishedGoodDistribusiController extends Controller
{
    public function __construct(
        private PakanFinishedGoodDistribusiRepository $repository,
        private BahanPakanFormulasiRepository $bahanPakanFormulasiRepository,
    ) {
        $this->middleware('can:gudang-pakan.pakan-finished-good-distribusi.menu-pakan-finished-good-distribusi');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null, null,
            $request->query('perPage', 10)
        );
        return view('gudang-pakan::pakan-finished-good-distribusi.index', compact(['datas']));
    }

    public function create()
    {
        $listFormulasi = $this->bahanPakanFormulasiRepository->getSelectItems3();
        return view('gudang-pakan::pakan-finished-good-distribusi.create', compact(['listFormulasi']));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'formulasi_mix_id' => ['required', 'exists:bahan_pakan_formulasi,id'],
            'tanggal' => ['required', 'date_format:Y-m-d\TH:i'],
            'jumlah' => ['required', 'integer', 'min:0'],
            'tujuan' => ['required', 'string'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $distribusi = $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-finished-good-distribusi.edit', $distribusi)
            ->with('success', 'Data Distribusi Paka Jadi Berhasil Disimpan.');
    }

    public function edit(PakanFinishedGoodDistribusi $pakanFinishedGoodDistribusi)
    {
        $data = $pakanFinishedGoodDistribusi;
        $listFormulasi = $this->bahanPakanFormulasiRepository->getSelectItems3();
        return view('gudang-pakan::pakan-finished-good-distribusi.edit', compact([
            'data', 'listFormulasi',
        ]));
    }

    public function update(Request $request, PakanFinishedGoodDistribusi $pakanFinishedGoodDistribusi)
    {
        $validated = $request->validate([
            'formulasi_mix_id' => ['required', 'exists:bahan_pakan_formulasi,id'],
            'tanggal' => ['required', 'date_format:Y-m-d\TH:i'],
            'jumlah' => ['required', 'integer', 'min:0'],
            'tujuan' => ['required', 'string'],
        ]);

        $validated['id'] = $pakanFinishedGoodDistribusi->id;
        $validated['pic_user_id'] = auth()->id();
        $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-finished-good-distribusi.index')
            ->with('success', 'Data Distribusi Paka Jadi Berhasil Diupdate.');
    }

    public function destroy(PakanFinishedGoodDistribusi $pakanFinishedGoodDistribusi) 
    {
        $pakanFinishedGoodDistribusi->delete();

        return to_route('gudang-pakan.pakan-finished-good-distribusi.index')
            ->with('success', 'Data Distribusi Paka Jadi Berhasil Dihapus.');
    }
}
