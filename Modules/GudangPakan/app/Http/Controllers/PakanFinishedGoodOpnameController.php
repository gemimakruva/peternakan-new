<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Models\PakanFinishedGoodOpname;
use Modules\GudangPakan\Repositories\PakanFinishedGoodInventoryRepository;
use Modules\GudangPakan\Repositories\PakanFinishedGoodOpnameRepository;

class PakanFinishedGoodOpnameController extends Controller
{
    public function __construct(
        private PakanFinishedGoodOpnameRepository $repository,
        private PakanFinishedGoodInventoryRepository $pakanFinishedGoodInventoryRepository,
    ) {
        $this->middleware('can:gudang-pakan.pakan-finished-good-opname.menu-pakan-finished-good-opname');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('gudang-pakan::pakan-finished-good-opname.index', compact('datas'));
    }

    public function create()
    {
        $listPakanJadi = $this->pakanFinishedGoodInventoryRepository->getQuery()->orderBy('nama_formulasi')->get();
        return view('gudang-pakan::pakan-finished-good-opname.create', compact('listPakanJadi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.id'                    => ['nullable', 'numeric'],
            'items.*.formulasi_mix_id'   => ['required', 'exists:bahan_pakan_formulasi,id'],
            'items.*.jumlah'                => ['required', 'numeric'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $opname = $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-finished-good-opname.edit', $opname)
            ->with('success', 'Data Opname Pakan Jadi Berhasil Disimpan.');
    }

    public function edit(PakanFinishedGoodOpname $pakanFinishedGoodOpname)
    {
        $pakanFinishedGoodOpname->load('pakanFinishedGoodInventory');
        $listPakanJadi = $this->pakanFinishedGoodInventoryRepository
            ->getQuery()
            ->where('tanggal', '<=', $pakanFinishedGoodOpname->tanggal)
            ->orderBy('nama_formulasi')
            ->get();
        $pakanFinishedGoodOpname->pakanFinishedGoodInventory->transform(function($item) use($listPakanJadi) {
            $xx = $listPakanJadi->first(fn($x) => $x->id == $item['formulasi_mix_id']);
            $item->real = $xx->jumlah + $item->jumlah;
            return $item;
        });
        $data = $pakanFinishedGoodOpname;
        return view('gudang-pakan::pakan-finished-good-opname.edit', compact('data', 'listPakanJadi'));
    }

    public function update(Request $request, PakanFinishedGoodOpname $pakanFinishedGoodOpname)
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.id'                    => ['nullable', 'numeric'],
            'items.*.formulasi_mix_id'      => ['required', 'exists:bahan_pakan_formulasi,id'],
            'items.*.jumlah'                => ['required', 'numeric'],
        ]);

        $validated['id'] = $pakanFinishedGoodOpname->id;
        $validated['pic_user_id'] = $pakanFinishedGoodOpname->pic_user_id;
        $opname = $this->repository->save($validated);

        return to_route('gudang-pakan.pakan-finished-good-opname.edit', $opname)
            ->with('success', 'Data Opname Pakan Jadi Berhasil Diupdate.');
    }

    public function destroy(PakanFinishedGoodOpname $pakanFinishedGoodOpname)
    {
        $pakanFinishedGoodOpname->delete();
        return back()->with('success', 'Data Opname Pakan Jadi Berhasil Dihapus.');
    }
}
