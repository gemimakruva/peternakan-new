<?php

namespace Modules\Kandang\Http\Controllers\Rekapan;

use App\Exports\RekapanProduksiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanPerFlockProduksiRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanProduksiRepository;
use Modules\Kandang\Services\Report\ReportDailyKandangService;
use Modules\Kandang\Services\Report\ReportDailySemuaKandangService;

class ProduksiController extends Controller
{
    public function __construct(
        private RekapanProduksiRepository $rekapanProduksiRepository,
        private RekapanPerFlockProduksiRepository $rekapanPerFlockProduksiRepository,
        private KandangRepository $kandangRepository,
        private ReportDailySemuaKandangService $reportDailySemuaKandangService,
        private ReportDailyKandangService $reportDailyKandangService,
    ) { 
        $this->middleware('can:kandang.rekapan.menu-rekapan-produksi');
    }

    public function index(Request $request)
    {
        $datas = $this->rekapanProduksiRepository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id', 'tanggal']),
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

    public function detail(Request $request)
    {
        $request->validate([
            'kandang_id'    => ['required', 'exists:kandang,id'],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
        ]);

        $kandang = $this->kandangRepository->find($request->query('kandang_id'));
        $tanggal = $request->date('tanggal');

        $datas = $this->rekapanPerFlockProduksiRepository
            ->setContext(
                $request->query('kandang_id'), 
                $request->date('tanggal')
            )
            ->paginate(
                $request->query('search'),
                null,
                $request->collect('orders'),
                $request->query('perPage', 10)
            );

        $datas->transform(function($item) {
            if ($item->tanggal) {
                $item->tanggal = Carbon::createFromFormat('Y-m-d', $item->tanggal);
            }
            return $item;
        });

        return view('kandang::rekapan.produksi.detail', compact([
            'kandang',
            'tanggal',
            'datas',
        ]));
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
            $populasiAyamPerKandang                     = $this->reportDailySemuaKandangService->populasiAyamPerKandang($tanggal);
            $populasiAyamSemuaKandang                   = $this->reportDailySemuaKandangService->populasiAyamSemuaKandang($tanggal);
            // Data Akumulasi Kematian Ayam
            $akumulasiKematianAyamPerKandang            = $this->reportDailySemuaKandangService->akumulasiKematianAyamPerKandang($tanggal);
            $akumulasiKematianAyamSemuaKandang          = $this->reportDailySemuaKandangService->akumulasiKematianAyamSemuaKandang($tanggal);
            $persentaseAkumulasiKematianAyamPerKandang  = $this->reportDailySemuaKandangService->persentaseAkumulasiKematianAyamPerKandang($tanggal);
            // Data Konsumsi Ayam
            $konsumsiAyam                               = $this->reportDailySemuaKandangService->konsumsiAyamPerKandang($tanggal);
            $produksiTelurSemuaKandang                  = $this->reportDailySemuaKandangService->produksiTelurSemuaKandang($tanggal);
            // KPI Produksi
            $kpiProduksi                                = $this->reportDailySemuaKandangService->kpiProduksi($tanggal);
            // echo json_encode($kpiProduksi);die;
            return view('kandang::rekapan.produksi.report-daily-per-kandang', compact([
                'tanggal',
                'listKandang',
                'populasiAyamPerKandang',
                'populasiAyamSemuaKandang',
                'akumulasiKematianAyamPerKandang',
                'akumulasiKematianAyamSemuaKandang',
                'persentaseAkumulasiKematianAyamPerKandang',
                'konsumsiAyam',
                'produksiTelurSemuaKandang',
                'kpiProduksi',
            ]));
        }

        // Data Populasi Ayam Hari Ini
        $rekapanFlock = app(RekapanPerFlockProduksiRepository::class)
            ->setContext($kandangId, $tanggal)
            ->getQuery()
            ->get();
        $rekapanKandang = app(RekapanProduksiRepository::class)
            ->getQuery()
            ->whereDate('xpaq.tanggal', '=', $tanggal)
            ->first();

        return view('kandang::rekapan.produksi.report-daily-per-flock', compact([
            'tanggal',
            'listKandang',
            'kandang',

            'rekapanFlock',
            'rekapanKandang',
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
