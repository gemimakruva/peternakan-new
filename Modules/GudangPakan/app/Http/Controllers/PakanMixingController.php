<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Models\BahanPakanFormulasi;
use Modules\GudangPakan\Models\PakanMixing;
use Modules\GudangPakan\Repositories\BahanPakanFormulasiRepository;
use Modules\GudangPakan\Repositories\PakanMixingRepository;
use Modules\GudangPakan\Services\MixingPakanService;

class PakanMixingController extends Controller
{
    public function __construct(
        private PakanMixingRepository $repository,
        private BahanPakanFormulasiRepository $formulasiRepository,
    ) {
        $this->middleware('can:gudang-pakan.pakan-mixing.menu-pakan-mixing');
    }
    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('gudang-pakan::pakan-mixing.index', compact(['datas']));
    }

    public function create()
    {
        $listFormulasi = $this->formulasiRepository->getSelectItems3();
        return view('gudang-pakan::pakan-mixing.create', compact(['listFormulasi']));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'formulasi_mix_id'   => ['required', 'exists:bahan_pakan_formulasi,id'],
            'tanggal'               => ['required', 'date_format:Y-m-d\TH:i'],
            'jumlah_campuran'       => ['required', 'numeric', 'min:0', function ($attr, $value, $fail) use($request) {
                $errorMessage = app(MixingPakanService::class)->validateStokKebutuhanMixing($request->integer('formulasi_mix_id'), (float) $value);
                if ($errorMessage) $fail($errorMessage);
            }],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $pakanMixing = $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-mixing.edit', $pakanMixing->id)
            ->with('success', 'Data Mixing Pakan Berhasil Disimpan.');
    }

    public function edit(PakanMixing $pakanMixing)
    {
        $pakanMixing->load([
            'pakanMixingItem.bahanPakan',
            'pakanMixingItem.formulasiPremix',
        ]);
        $data = $pakanMixing;
        $listFormulasi = $this->formulasiRepository->getSelectItems3();
        return view('gudang-pakan::pakan-mixing.edit', compact([
            'data',
            'listFormulasi',
        ]));
    }

    public function update(Request $request, PakanMixing $pakanMixing)
    {
        $validated = $request->validate([
            'formulasi_mix_id'   => ['required', 'exists:bahan_pakan_formulasi,id'],
            'tanggal'               => ['required', 'date_format:Y-m-d\TH:i'],
            'jumlah_campuran'       => ['required', 'numeric', 'min:0', function ($attr, $value, $fail) use($request, $pakanMixing) {
                $errorMessage = app(MixingPakanService::class)->validateStokKebutuhanMixing(
                    $request->integer('formulasi_mix_id'), 
                    (float) $value,
                    'pakan_mixing_item_id',
                    $pakanMixing->pakanMixingItem->pluck('id')->toArray()
                );
                if ($errorMessage) $fail($errorMessage);
            }],
        ]);

        $validated['id'] = $pakanMixing->id;
        $validated['pic_user_id'] = $pakanMixing->pic_user_id;
        $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-mixing.index')
            ->with('success', 'Data Mixing Pakan Berhasil Diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
