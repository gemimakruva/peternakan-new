<?php

namespace Modules\Kandang\Http\Controllers\Rekapan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\Rekapan\RekapanPakanHarianRepository;

class RekapanPakanHarianController extends Controller
{
    public function __construct(
        private RekapanPakanHarianRepository $repository,
        private Kandang $kandang,
    ) {
        $this->middleware('can:kandang.pakan.menu-rekapan-pakan-harian');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id']),
            $request->collect('orders'),
            $request->query('perPage', 10)
        );

        $listKandang = $this->kandang->pluck('nama', 'id')->toArray();
        
        return view('kandang::rekapan.pakan.index', compact(['datas', 'listKandang']));
    }
}
