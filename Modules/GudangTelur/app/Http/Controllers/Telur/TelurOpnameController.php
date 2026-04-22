<?php

namespace Modules\GudangTelur\Http\Controllers\Telur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Models\TelurOpname;
use Modules\GudangTelur\Repositories\Telur\TelurInventoryRepository;
use Modules\GudangTelur\Repositories\Telur\TelurOpnameRepository;

class TelurOpnameController extends Controller
{
    public function __construct(
        private TelurOpnameRepository $repository,
        private TelurInventoryRepository $telurInventoryRepository,
    ) {
        $this->middleware('can:gudang-telur.telur-opname.menu-telur-opname');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect(['orders']),
            $request->query('perPage', 10)
        );
        return view('gudang-telur::telur.opname.index', compact(['datas']));
    }

    public function create()
    {
        $latestInventory = $this->telurInventoryRepository
            ->getQuery()
            ->orderBy("x.tanggal", 'desc')
            ->orderBy("x.created_at", 'desc')
            ->orderBy("x.id", 'desc')
            ->first();
        
        return view('gudang-telur::telur.opname.create', compact(['latestInventory']));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'opname'    => ['required', 'numeric'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $telurOpname = $this->repository->save($validated);

        return to_route('gudang-telur.telur-opname.edit', $telurOpname)
            ->with('success', 'Data Telur Opname Berhasil Disimpan!');
    }

    public function edit(TelurOpname $telurOpname)
    {
        $telurOpname->load('telurInventory');
        $data = $telurOpname;

        $latestInventory = $this->telurInventoryRepository
            ->getQuery()
            ->where('x.id', '!=', $telurOpname->telurInventory->id)
            ->orderBy("x.tanggal", 'desc')
            ->orderBy("x.created_at", 'desc')
            ->orderBy("x.id", 'desc')
            ->first();

        return view('gudang-telur::telur.opname.edit', compact([
            'data',
            'latestInventory',
        ]));
    }

    public function update(Request $request, $id) 
    {
        $validated = $request->validate([
            'tanggal'   => ['required', 'date_format:Y-m-d'],
            'opname'    => ['required', 'numeric'],
        ]);

        $validated['id'] = $id;
        $validated['pic_user_id'] = auth()->id();
        $telurOpname = $this->repository->save($validated);

        return to_route('gudang-telur.telur-opname.edit', $telurOpname)
            ->with('success', 'Data Telur Opname Berhasil Diupdate!');
    }

    public function destroy(TelurOpname $telurOpname) 
    {
        $telurOpname->telurInventory()->delete();
        $telurOpname->delete();
        return back()->with('success', 'Data Telur Opname Berhasil Dihapus!');
    }
}
