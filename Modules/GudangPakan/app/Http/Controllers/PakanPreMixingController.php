<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Models\PakanPreMixing;
use Modules\GudangPakan\Repositories\BahanPakanFormulasiRepository;
use Modules\GudangPakan\Repositories\PakanPreMixingRepository;

class PakanPreMixingController extends Controller
{
    public function __construct(
        private PakanPreMixingRepository $repository,
        private BahanPakanFormulasiRepository $bahanPakanFormulasiRepository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('gudang-pakan::pakan-pre-mixing.index', compact(['datas']));
    }

    public function create()
    {
        $listFormulasi = $this->bahanPakanFormulasiRepository->getSelectItems2();
        return view('gudang-pakan::pakan-pre-mixing.create', compact([
            'listFormulasi',
        ]));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'formulasi_premix_id'   => ['required', 'exists:bahan_pakan_formulasi,id'],
            'tanggal'               => ['required', 'date_format:Y-m-d\TH:i'],
            'jumlah_campuran'       => ['required', 'numeric', 'min:0'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $pakanPreMixing = $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-pre-mixing.edit', $pakanPreMixing)
            ->with('success', 'Data Pakan Pre-Mixing Berhasil Disimpan.');
    }

    public function edit(PakanPreMixing $pakanPreMixing)
    {
        $pakanPreMixing->load('pakanPreMixingItem.bahanPakan');
        $data = $pakanPreMixing;
        $listFormulasi = $this->bahanPakanFormulasiRepository->getSelectItems2();
        return view('gudang-pakan::pakan-pre-mixing.edit', compact([
            'data',
            'listFormulasi',
        ]));
    }

    public function update(Request $request, PakanPreMixing $pakanPreMixing) 
    {
        $validated = $request->validate([
            'formulasi_premix_id'   => ['required', 'exists:bahan_pakan_formulasi,id'],
            'tanggal'               => ['required', 'date_format:Y-m-d\TH:i'],
            'jumlah_campuran'       => ['required', 'numeric', 'min:0'],
        ]);

        $validated['id'] = $pakanPreMixing->id;
        $validated['pic_user_id'] = $pakanPreMixing->pic_user_id;
        $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-pre-mixing.index')
            ->with('success', 'Data Pakan Pre-Mixing Berhasil Diupdate.');
    }

    public function destroy(PakanPreMixing $pakanPreMixing) 
    {
        $pakanPreMixing->pakanPreMixingItem->each(function ($item) {
            $item->bahanPakanInventoryKeluar()->delete();
            $item->bahanPakanInventoryMasuk()->delete();
        });

        $pakanPreMixing->pakanPreMixingItem()->delete();
        $pakanPreMixing->delete();

        return back()->with('success', 'Data Pakan Pre-Mixing Berhasil Dihapus.');
    }
}
