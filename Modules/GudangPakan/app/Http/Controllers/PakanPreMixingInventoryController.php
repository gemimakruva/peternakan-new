<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Models\BahanPakanFormulasi;
use Modules\GudangPakan\Repositories\PakanPreMixingInventoryRepository;
use Modules\GudangPakan\Repositories\PakanPreMixingInventoryShowRepository;

class PakanPreMixingInventoryController extends Controller
{
    public function __construct(
        private PakanPreMixingInventoryRepository $repository,
        private PakanPreMixingInventoryShowRepository $showRepository,
    ) {
        $this->middleware('can:gudang-pakan.pakan-pre-mixing-inventory.menu-pakan-pre-mixing-inventory');
    }
    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('gudang-pakan::pakan-pre-mixing-inventory.index', compact(['datas']));
    }

    public function show(Request $request, BahanPakanFormulasi $bahanPakanFormulasi)
    {
        $data = $bahanPakanFormulasi;
        $datas = $this->showRepository
            ->setContext($bahanPakanFormulasi->id)
            ->paginate(
                null, null, null,
                $request->query('perPage', 10),
            );
        return view('gudang-pakan::pakan-pre-mixing-inventory.show', compact([
            'data', 'datas',
        ]));
    }
}
