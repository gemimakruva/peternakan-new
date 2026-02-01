<?php

namespace Modules\Kandang\Http\Controllers\PerhitunganPakan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Kandang\Repositories\Pakan\OverviewPakanHarianRepository;

class OverviewPakanHarianController extends Controller
{
    public function __construct(
        private OverviewPakanHarianRepository $repository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders')
        );
        
        return view('kandang::overview.pakan.index', compact('datas'));
    }
}
