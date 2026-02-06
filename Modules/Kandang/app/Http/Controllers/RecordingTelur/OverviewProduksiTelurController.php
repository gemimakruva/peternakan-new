<?php

namespace Modules\Kandang\Http\Controllers\RecordingTelur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\ProduksiTelur\OverviewProduksiTelurRepository;

class OverviewProduksiTelurController extends Controller
{
    public function __construct(
        private OverviewProduksiTelurRepository $repository,
        private Kandang $kandang,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        $listKandang = $this->kandang->orderBy('nama')->pluck('nama', 'id')->toArray();

        return view('kandang::overview.produksi-telur.index', compact(['datas', 'listKandang']));
    }
}
