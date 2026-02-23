<?php

namespace Modules\Kandang\Http\Controllers\Rekapan;

use App\Exports\RekapanProduksiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Kandang\Enums\CatatanLaporanTipe;
use Modules\Kandang\Models\CatatanLaporan;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanMingguanProduksiRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanPerFlockMingguanProduksiRepository;
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
        private CatatanLaporan $catatanLaporan,
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

        $catatanLaporan = $this->catatanLaporan
            ->when($request->query('kandang_id'), function ($query, $kandangId) {
                $query->where('kandang_id', '=', $kandangId);
            })
            ->whereDate('tanggal', '=', $tanggal)
            ->first();

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
                'catatanLaporan',
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
            ->where('xpaq.kandang_id', '=', $kandangId)
            ->first();

        return view('kandang::rekapan.produksi.report-daily-per-flock', compact([
            'tanggal',
            'listKandang',
            'kandang',

            'rekapanFlock',
            'rekapanKandang',
            'catatanLaporan',
        ]));
    }
    
    public function reportWeekly(Request $request)
    {
        $umur           = $request->integer('umur', 13);
        $kandangId      = $request->integer('kandang_id');
        $listKandang    = $this->kandangRepository->getSelectItems();
        $kandang        = $this->kandangRepository->find($kandangId, null, ['id', 'nama']);


        $catatanLaporan = $this->catatanLaporan
            ->when($request->query('kandang_id'), function ($query, $kandangId) {
                $query->where('kandang_id', '=', $kandangId);
            })
            ->where('umur', '=', $umur)
            ->first();

        if ($kandang === null) {
            $rekapanKandang = app(RekapanMingguanProduksiRepository::class)
                ->setContext(null, $umur)
                ->getQuery()
                ->get();
            return view('kandang::rekapan.produksi.report-weekly-per-kandang', compact([
                'umur',
                'listKandang',
                'rekapanKandang',
                'catatanLaporan',
            ]));
        }

        $rekapanFlock = app(RekapanPerFlockMingguanProduksiRepository::class)
            ->setContext($kandangId, $umur)
            ->getQuery()
            ->get();
        $rekapanKandang = app(RekapanMingguanProduksiRepository::class)
            ->setContext($kandangId, $umur)
            ->getQuery()
            ->first();

        return view('kandang::rekapan.produksi.report-weekly-per-flock', compact([
            'umur',
            'listKandang',
            'kandang',
            'rekapanFlock',
            'rekapanKandang',
            'catatanLaporan',
        ]));
    }

    /**
     * Generate PDF for weekly report
     */
    public function reportWeeklyPdf(Request $request)
    {
        $umur           = $request->integer('umur', 13);
        $kandangId      = $request->integer('kandang_id');
        $kandang        = $this->kandangRepository->find($kandangId, null, ['id', 'nama']);

        $catatanLaporan = $this->catatanLaporan
            ->when($kandangId, function ($query, $kandangId) {
                $query->where('kandang_id', '=', $kandangId);
            })
            ->where('umur', '=', $umur)
            ->first();

        // Get chart images from request (sent from client-side)
        $chartImages = json_decode($request->input('chart_images', '{}'), true);

        if ($kandang === null) {
            $rekapanKandang = app(RekapanMingguanProduksiRepository::class)
                ->setContext(null, $umur)
                ->getQuery()
                ->get();

            return view('kandang::rekapan.produksi.report-weekly-per-kandang-print', [
                'umur'              => $umur,
                'kandang'           => $kandang,
                'rekapanKandang'    => $rekapanKandang,
                'catatanLaporan'    => $catatanLaporan,
                'chartImages'       => $chartImages,
            ]);
        }

        // Per Flock view (specific kandang)
        $rekapanFlock = app(RekapanPerFlockMingguanProduksiRepository::class)
            ->setContext($kandangId, $umur)
            ->getQuery()
            ->get();
        $rekapanKandang = app(RekapanMingguanProduksiRepository::class)
            ->setContext($kandangId, $umur)
            ->getQuery()
            ->first();

        return view('kandang::rekapan.produksi.report-weekly-per-flock-print', [
            'umur'              => $umur,
            'kandang'           => $kandang,
            'rekapanFlock'      => $rekapanFlock,
            'rekapanKandang'    => $rekapanKandang,
            'catatanLaporan'    => $catatanLaporan,
            'chartImages'       => $chartImages,
        ]);
    }

    /**
     * Generate PDF for daily report
     */
    public function reportDailyPdf(Request $request)
    {
        $tanggal        = $request->date('tanggal', 'Y-m-d') ?? today();
        $kandangId      = $request->integer('kandang_id');
        $kandang        = $this->kandangRepository->find($kandangId, null, ['id', 'nama']);

        $catatanLaporan = $this->catatanLaporan
            ->when($kandangId, function ($query, $kandangId) {
                $query->where('kandang_id', '=', $kandangId);
            })
            ->whereDate('tanggal', '=', $tanggal)
            ->first();

        // Get chart images from request (sent from client-side)
        $chartImages = json_decode($request->input('chart_images', '{}'), true);

        if ($kandang === null) {
            // Per Kandang view (all kandang)
            // Get umur from any rekapan data for the date
            $rekapanKandangForUmur = app(RekapanProduksiRepository::class)
                ->getQuery()
                ->whereDate('xpaq.tanggal', '=', $tanggal)
                ->first();
            $umur = $rekapanKandangForUmur?->umur ?? null;

            return view('kandang::rekapan.produksi.report-daily-per-kandang-print', [
                'tanggal'           => $tanggal,
                'kandang'           => $kandang,
                'umur'              => $umur,
                'catatanLaporan'    => $catatanLaporan,
                'chartImages'       => $chartImages,
            ]);
        }

        // Per Flock view (specific kandang)
        $rekapanFlock = app(RekapanPerFlockProduksiRepository::class)
            ->setContext($kandangId, $tanggal)
            ->getQuery()
            ->get();
        $rekapanKandang = app(RekapanProduksiRepository::class)
            ->getQuery()
            ->whereDate('xpaq.tanggal', '=', $tanggal)
            ->first();

        return view('kandang::rekapan.produksi.report-daily-per-flock-print', [
            'tanggal'           => $tanggal,
            'kandang'           => $kandang,
            'umur'              => $rekapanKandang?->umur ?? null,
            'rekapanFlock'      => $rekapanFlock,
            'rekapanKandang'    => $rekapanKandang,
            'catatanLaporan'    => $catatanLaporan,
            'chartImages'       => $chartImages,
        ]);
    }

    public function saveCatatan(Request $request)
    {
        $validated = $request->validate([
            'tipe'                      => ['required', Rule::in(CatatanLaporanTipe::getArrayValues())],
            'kandang_id'                => ['nullable', 'exists:kandang,id'],
            'umur'                      => ['sometimes', 'min:1'],
            'tanggal'                   => ['sometimes', 'date'],
            'catatan_populasi'          => ['nullable', 'string', 'max:1000'],
            'catatan_kematian'          => ['nullable', 'string', 'max:1000'],
            'catatan_konsumsi'          => ['nullable', 'string', 'max:1000'],
            'catatan_produksi_telur'    => ['nullable', 'string', 'max:1000'],
            'catatan_kpi_produksi'      => ['nullable', 'string', 'max:1000'],
            'catatan_keseluruhan'       => ['nullable', 'string', 'max:1000'],
        ]);

        $this->catatanLaporan->updateOrCreate([
            'tipe'                      => $validated['tipe'],
            'kandang_id'                => @$validated['kandang_id'],
            'umur'                      => @$validated['umur'],
            'tanggal'                   => @$validated['tanggal'],
        ], [
            'creator_user_id'           => auth()->id(),
            'catatan_populasi'          => $validated['catatan_populasi'],
            'catatan_kematian'          => $validated['catatan_kematian'],
            'catatan_konsumsi'          => $validated['catatan_konsumsi'],
            'catatan_produksi_telur'    => $validated['catatan_produksi_telur'],
            'catatan_kpi_produksi'      => $validated['catatan_kpi_produksi'],
            'catatan_keseluruhan'       => $validated['catatan_keseluruhan'],
        ]);

        return back()->with('success', 'Catatan Laporan Berhasil Disimpan.');
    }
}
