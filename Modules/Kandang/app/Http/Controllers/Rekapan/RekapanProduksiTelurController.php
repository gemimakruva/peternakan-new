<?php

namespace Modules\Kandang\Http\Controllers\Rekapan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\ProduksiTelur\OverviewProduksiTelurRepository;

class RekapanProduksiTelurController extends Controller
{
    public function __construct(
        private OverviewProduksiTelurRepository $repository,
        private Kandang $kandang,
    ) {
        $this->middleware('can:kandang.telur.menu-rekapan-produksi-telur');
    }

    public function index(Request $request)
    {
        Gate::authorize('kandang.telur.menu-rekapan-produksi-telur');

        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id', 'tanggal']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        $listKandang = $this->kandang->orderBy('nama')->pluck('nama', 'id')->toArray();

        return view('kandang::overview.produksi-telur.index', compact(['datas', 'listKandang']));
    }
}
