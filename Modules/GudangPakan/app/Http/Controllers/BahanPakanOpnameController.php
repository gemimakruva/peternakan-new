<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Models\BahanPakanOpname;
use Modules\GudangPakan\Repositories\BahanPakanInventoryRepository;
use Modules\GudangPakan\Repositories\BahanPakanOpnameRepository;

class BahanPakanOpnameController extends Controller
{
    public function __construct(
        private BahanPakanOpnameRepository $repository,
        private BahanPakanInventoryRepository $bahanPakanInventoryRepository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null, 
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('gudang-pakan::bahan-pakan-opname.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listBahanPakan = $this->bahanPakanInventoryRepository->getQuery()->orderBy('nama_bahan_pakan')->get();
        return view('gudang-pakan::bahan-pakan-opname.create', compact('listBahanPakan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.id'                => ['nullable', 'numeric'],
            'items.*.bahan_pakan_id'    => ['required', 'exists:bahan_pakan,id'],
            'items.*.jumlah'            => ['required', 'numeric'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $kemasanOpname = $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-opname.edit', $kemasanOpname)
            ->with('success', 'Data Bahan Pakan Opname Berhasil Disimpan.');
    }

    public function edit(BahanPakanOpname $bahanPakanOpname)
    {
        $listBahanPakan = $this->bahanPakanInventoryRepository->getQuery()->orderBy('nama_bahan_pakan')->get(); // harusnya saat tanggal terpilih
        $bahanPakanOpname->load('bahanPakanInventory');
        $bahanPakanOpname->bahanPakanInventory->transform(function($item) use($listBahanPakan) {
            $xx = $listBahanPakan->first(fn($x) => $x->id == $item['bahan_pakan_id']);
            $item->real = $xx->jumlah + $item->jumlah;
            return $item;
        });
        $data = $bahanPakanOpname;
        return view('gudang-pakan::bahan-pakan-opname.edit', compact('data', 'listBahanPakan'));
    }

    public function update(Request $request, BahanPakanOpname $bahanPakanOpname)
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'items.*'   => ['required', 'array'],
            'items.*.id'                => ['nullable', 'numeric'],
            'items.*.bahan_pakan_id'    => ['required', 'exists:bahan_pakan,id'],
            'items.*.jumlah'            => ['required', 'numeric'],
        ]);
        
        $validated['id'] = $bahanPakanOpname->id;
        $validated['pic_user_id'] = $bahanPakanOpname->pic_user_id;
        $this->repository->save($validated);

        return to_route('gudang-pakan.bahan-pakan-opname.index')
            ->with('success', 'Data Bahan Pakan Opname Berhasil Disimpan.');
    }

    public function destroy(BahanPakanOpname $bahanPakanOpname)
    {
        $bahanPakanOpname->delete();
        return back()->with('success', 'Data Bahan Pakan Opname Berhasil Dihapus.');
    }
}
