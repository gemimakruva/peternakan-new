<?php

namespace Modules\Kandang\Http\Controllers\Rekapan;

use App\Exports\RekapanProduksiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanProduksiRepository;
use Modules\Kandang\Services\Report\ReportDailyService;

class ProduksiController extends Controller
{
    public function __construct(
        private RekapanProduksiRepository $rekapanProduksiRepository,
        private KandangRepository $kandangRepository,
        private ReportDailyService $reportDailyService,
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

    public function detail()
    {

    }

    public function exportIndex()
    {
        return Excel::download(new RekapanProduksiExport(), 'rekapan-produksi.xlsx');
    }

    public function reportDaily(Request $request)
    {
        $tanggal        = $request->date('tanggal', 'Y-m-d') ?? today();
        $kandangId      = $request->integer('kandang_id');
        $listKandang    = $this->kandangRepository->getSelectItems();
        $kandang        = $this->kandangRepository->find($kandangId, null, ['id', 'nama']);

        if ($kandang === null) {
            // Data Populasi Ayam Hari Ini
            $populasiAyamPerKandang = $this->reportDailyService->populasiAyamPerKandang($tanggal);
            $populasiAyamSemuaKandang = $this->reportDailyService->populasiAyamSemuaKandang($tanggal);
            // Data Akumulasi Kematian Ayam
            $akumulasiKematianAyamPerKandang = $this->reportDailyService->akumulasiKematianAyamPerKandang($tanggal);
            $akumulasiKematianAyamSemuaKandang = $this->reportDailyService->akumulasiKematianAyamSemuaKandang($tanggal);
            $persentaseAkumulasiKematianAyamPerKandang = $this->reportDailyService->persentaseAkumulasiKematianAyamPerKandang($tanggal);
            // echo json_encode($persentaseAkumulasiKematianAyamPerKandang);die;
            return view('kandang::rekapan.produksi.report-daily-per-kandang', compact([
                'tanggal',
                'listKandang',
                'populasiAyamPerKandang',
                'populasiAyamSemuaKandang',
                'akumulasiKematianAyamPerKandang',
                'akumulasiKematianAyamSemuaKandang',
                'persentaseAkumulasiKematianAyamPerKandang',
            ]));
        }

        return view('kandang::rekapan.produksi.report-daily-per-flock', compact([
            'tanggal',
            'listKandang',
            'kandang',
        ]));
    }
    
    public function reportWeekly(Request $request)
    {
        $tanggal        = $request->date('tanggal', 'Y-m-d') ?? today();
        $kandangId      = $request->integer('kandang_id');
        $listKandang    = $this->kandangRepository->getSelectItems();
        $kandang        = $this->kandangRepository->find($kandangId, null, ['id', 'nama']);

        if ($kandang === null) {
            return view('kandang::rekapan.produksi.report-weekly-per-kandang', compact([
                'tanggal',
                'listKandang',
            ]));
        }

        return view('kandang::rekapan.produksi.report-weekly-per-flock', compact([
            'tanggal',
            'listKandang',
            'kandang',
        ]));
    }
}
