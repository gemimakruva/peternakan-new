<?php

namespace Modules\GudangTelur\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Models\Kemasan;
use Modules\GudangTelur\Repositories\Kemasan\KemasanInventoryRepository;
use Modules\GudangTelur\Repositories\Kemasan\KemasanInventoryShowReposotory;

class KemasanInventoryController extends Controller
{
    public function __construct(
        private Kemasan $kemasan,
        private KemasanInventoryRepository $repository,
        private KemasanInventoryShowReposotory $repository2,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10)
        );
        return view('gudang-telur::kemasan.inventory.index', compact('datas'));
    }

    public function show(Request $request, $kemasanId)
    {
        $data = $this->kemasan->findOrFail($kemasanId);
        $datas = $this->repository2
            ->setContext($kemasanId)
            ->paginate(
                $request->query('search'),
                null,
                null,
                $request->query('perPage', 10)
            );
        return view('gudang-telur::kemasan.inventory.show', compact(['data', 'datas']));
    }
}
