<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Models\PakanPreMixingOpname;
use Modules\GudangPakan\Repositories\PakanPreMixingInventoryRepository;
use Modules\GudangPakan\Repositories\PakanPreMixingOpnameRepository;

class PakanPreMixingOpnameController extends Controller
{
    public function __construct(
        private PakanPreMixingOpnameRepository $repository,
        private PakanPreMixingInventoryRepository $pakanPreMixingInventoryRepository,
    ) {
        $this->middleware('can:gudang-pakan.pakan-pre-mixing-opname.menu-pakan-pre-mixing-opname');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null, 
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('gudang-pakan::pakan-pre-mixing-opname.index', compact('datas'));
    }

    public function create()
    {
        $listPreMixing = $this->pakanPreMixingInventoryRepository->getQuery()->orderBy('nama_formulasi')->get();
        return view('gudang-pakan::pakan-pre-mixing-opname.create', compact('listPreMixing'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.id'                    => ['nullable', 'numeric'],
            'items.*.formulasi_premix_id'   => ['required', 'exists:bahan_pakan_formulasi,id'],
            'items.*.jumlah'                => ['required', 'numeric'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $opname = $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-pre-mixing-opname.edit', $opname)
            ->with('success', 'Data Opname Pre-Mixing Berhasil Disimpan.');
    }

    public function edit(PakanPreMixingOpname $pakanPreMixingOpname)
    {
        $pakanPreMixingOpname->load('pakanPreMixingInventory');
        $listPreMixing = $this->pakanPreMixingInventoryRepository
            ->getQuery()
            ->where('tanggal', '<=', $pakanPreMixingOpname->tanggal)
            ->orderBy('nama_formulasi')
            ->get();
        $pakanPreMixingOpname->pakanPreMixingInventory->transform(function($item) use($listPreMixing) {
            $xx = $listPreMixing->first(fn($x) => $x->id == $item['formulasi_premix_id']);
            $item->real = $xx->jumlah + $item->jumlah;
            return $item;
        });
        $data = $pakanPreMixingOpname;
        return view('gudang-pakan::pakan-pre-mixing-opname.edit', compact('data', 'listPreMixing'));
    }

    public function update(Request $request, PakanPreMixingOpname $pakanPreMixingOpname)
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.id'                    => ['nullable', 'numeric'],
            'items.*.formulasi_premix_id'   => ['required', 'exists:bahan_pakan_formulasi,id'],
            'items.*.jumlah'                => ['required', 'numeric'],
        ]);

        $validated['id'] = $pakanPreMixingOpname->id;
        $validated['pic_user_id'] = $pakanPreMixingOpname->pic_user_id;
        $opname = $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-pre-mixing-opname.edit', $opname)
            ->with('success', 'Data Opname Pre-Mixing Berhasil Diupdate.');
    }

    public function destroy(PakanPreMixingOpname $pakanPreMixingOpname)
    {
        $pakanPreMixingOpname->delete();
        return back()->with('success', 'Data Opname Pre-Mixing Berhasil Dihapus.');
    }
}
