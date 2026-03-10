<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Models\BahanPakanFormulasi;
use Modules\GudangPakan\Repositories\PakanFinishedGoodInventoryRepository;
use Modules\GudangPakan\Repositories\PakanFinishedGoodInventoryShowRepository;

class PakanFinishedGoodInventoryController extends Controller
{
    public function __construct(
        private PakanFinishedGoodInventoryRepository $repository,
        private PakanFinishedGoodInventoryShowRepository $showRepository,
    ) {
        $this->middleware('can:gudang-pakan.pakan-finished-good-inventory.menu-pakan-finished-good-inventory');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            null, 
            $request->query('perPage', 10),
        );
        return view('gudang-pakan::pakan-finished-good-inventory.index', compact(['datas']));
    }

    public function show(Request $request, BahanPakanFormulasi $bahanPakanFormulasi)
    {
        $data = $bahanPakanFormulasi;
        $datas = $this->showRepository
            ->setContenxt($bahanPakanFormulasi->id)
            ->paginate(
                $request->query('search'),
                null, null,
                $request->query('perPage', 10)
            );
        return view('gudang-pakan::pakan-finished-good-inventory.show', compact([
            'data', 'datas',
        ]));
    }
}
