<?php

namespace Modules\Kandang\Http\Controllers\Rekapan;

use App\Exports\RekapanProduksiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanProduksiRepository;

class ProduksiController extends Controller
{
    public function __construct(
        private RekapanProduksiRepository $rekapanProduksiRepository,
        private KandangRepository $kandangRepository,
    ) { 
        $this->middleware('can:kandang.rekapan.menu-rekapan-produksi');
    }

    public function index(Request $request)
    {
        $datas = $this->rekapanProduksiRepository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id']),
            $request->collect('orders'),
            $request->query('perPage', 10)
        );

        $datas->transform(function($item) {
            if ($item->tanggal) {
                $item->tanggal = Carbon::createFromFormat('Y-m-d', $item->tanggal);
            }
            return $item;
        });

        $listKandang = $this->kandangRepository->getSelectItems();

        return view('kandang::rekapan.produksi.index', compact(['datas', 'listKandang']));
    }

    public function exportIndex()
    {
        return Excel::download(new RekapanProduksiExport(), 'rekapan-produksi.xlsx');
    }

    public function report(Request $request)
    {
        $tanggal        = $request->date('tanggal', 'Y-m-d');
        $kandangId      = $request->integer('kandang_id');
        $listKandang    = $this->kandangRepository->getSelectItems();
        $kandang        = $this->kandangRepository->find($kandangId, null, ['id', 'nama']);
        return view('kandang::rekapan.produksi.report-per-kandang', compact([
            'tanggal',
            'listKandang',
            'kandang',
        ]));
    }
}
