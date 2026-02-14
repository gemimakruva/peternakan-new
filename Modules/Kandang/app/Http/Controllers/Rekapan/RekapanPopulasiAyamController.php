<?php

namespace Modules\Kandang\Http\Controllers\Rekapan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\Rekapan\RekapanProduksiRepository;

class RekapanPopulasiAyamController extends Controller
{
    public function __construct(
        private RekapanProduksiRepository $rekapanProduksiRepository,
        private Kandang $kandang,
    ) { 
        $this->middleware('can:kandang.populasi.menu-rekapan-populasi-ayam');
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

        $listKandang = $this->kandang->pluck('nama', 'id');

        return view('kandang::rekapan.populasi-ayam.index', compact(['datas', 'listKandang']));
    }
}
