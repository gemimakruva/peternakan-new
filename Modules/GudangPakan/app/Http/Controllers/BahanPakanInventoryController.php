<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangPakan\Enums\BahanPakanTipe;
use Modules\GudangPakan\Models\BahanPakan;
use Modules\GudangPakan\Repositories\BahanPakanInventoryRepository;
use Modules\GudangPakan\Repositories\BahanPakanInventoryShowRepository;

class BahanPakanInventoryController extends Controller
{
    public function __construct(
        private BahanPakanInventoryRepository $repository,
        private BahanPakanInventoryShowRepository $bahanPakanInventoryShowRepository,
    ) {
        $this->middleware('can:gudang-pakan.bahan-pakan-inventory.menu-bahan-pakan-inventory');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['tipe']),
            $request->collect('orders'),
            $request->query('perPage', 10)
        );
        $datas->transform(function($item) {
            $item->tipe = BahanPakanTipe::tryFrom($item->tipe)?->title() ?? 'hehe';
            return $item;
        });
        $listTipe = BahanPakanTipe::getSelectItems();
        return view('gudang-pakan::bahan-pakan-inventory.index', compact([
            'datas',
            'listTipe',
        ]));
    }

    public function show(Request $request, BahanPakan $bahanPakan)
    {
        $bahanPakan->load('satuan');
        $data = $bahanPakan;
        $datas = $this->bahanPakanInventoryShowRepository
            ->setContext($bahanPakan->id)
            ->paginate(
                $request->query('search'),
                null,
                null,
                $request->query('perPage', 10)
            );
        return view('gudang-pakan::bahan-pakan-inventory.show', compact([
            'data',
            'datas',
        ]));
    }
}
