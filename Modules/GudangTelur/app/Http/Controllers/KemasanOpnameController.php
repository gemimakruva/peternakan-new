<?php

namespace Modules\GudangTelur\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Models\KemasanOpname;
use Modules\GudangTelur\Repositories\Kemasan\KemasanInventoryRepository;
use Modules\GudangTelur\Repositories\Kemasan\KemasanOpnameRepository;
use Modules\GudangTelur\Repositories\MasterData\KemasanRepository;

class KemasanOpnameController extends Controller
{
    public function __construct(
        private KemasanOpnameRepository $repository,
        private KemasanInventoryRepository $kemasanInventoryRepository,
    ) {
        $this->middleware('can:gudang-telur.opname-kemasan.menu-opname-kemasan');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10)
        );
        return view('gudang-telur::kemasan.opname.index', compact(['datas']));
    }

    public function create()
    {
        $listKemasanInventory = $this->kemasanInventoryRepository->getQuery()->get();
        return view('gudang-telur::kemasan.opname.create', compact(['listKemasanInventory']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.id'            => ['nullable', 'numeric'],
            'items.*.kemasan_id'    => ['required', 'exists:kemasan,id'],
            'items.*.jumlah'        => ['required', 'numeric'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $kemasanOpname = $this->repository->save($validated);

        return to_route('gudang-telur.kemasan-opname.edit', $kemasanOpname)
            ->with('success', 'Data Kemasan Opname Berhasil Disimpan.');
    }

    public function edit(KemasanOpname $kemasanOpname)
    {
        $kemasanOpname->load('kemasanInventory');
        $data = $kemasanOpname;
        $listKemasanInventory = $this->kemasanInventoryRepository
            ->getQuery()
            ->where('kemasan_inventory.tanggal', '<=', $kemasanOpname->tanggal)
            ->orderBy('nama_kemasan')
            ->get();
        $data->kemasanInventory->transform(function ($item) use($listKemasanInventory) {
            $item->real = (int) $listKemasanInventory->first(fn($item2) => $item2->kemasan_id == $item->kemasan_id)->stok + $item->jumlah;
            return $item;
        });
        return view('gudang-telur::kemasan.opname.edit', compact([
            'data',
            'listKemasanInventory',
        ]));
    }

    public function update(Request $request, KemasanOpname $kemasanOpname) 
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.id'            => ['nullable', 'numeric'],
            'items.*.kemasan_id'    => ['required', 'exists:kemasan,id'],
            'items.*.jumlah'        => ['required', 'numeric'],
        ]);

        $validated['id'] = $kemasanOpname->id;
        $kemasanOpname = $this->repository->save($validated);

        return to_route('gudang-telur.kemasan-opname.edit', $kemasanOpname)
            ->with('success', 'Data Kemasan Opname Berhasil Disimpan.');
    }

    public function destroy(KemasanOpname $kemasanOpname)
    {
        $kemasanOpname->kemasanInventory()->delete();
        $kemasanOpname->delete();

        return back()->with('success', 'Data Kemasan Opname Berhasil Dihapus.');
    }
}
