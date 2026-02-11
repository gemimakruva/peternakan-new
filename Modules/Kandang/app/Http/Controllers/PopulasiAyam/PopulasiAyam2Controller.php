<?php

namespace Modules\Kandang\Http\Controllers\PopulasiAyam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Repositories\PopulasiAyamRepository;
use Modules\Kandang\Services\PopulasiAyamService;

class PopulasiAyam2Controller extends Controller
{
    public function __construct(
        private PopulasiAyamRepository $repository,
        private KandangRepository $kandangRepository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            null,
            $request->collect(['kandang_id', 'tanggal']),
            $request->collect('orders'),
            $request->query('perPage', 10)
        );
        $listKandang = $this->kandangRepository->getSelectItems();
        return view('kandang::populasi-ayam-2.index', compact(['datas', 'listKandang']));
    }

    public function create($kandangId, $tanggal)
    {
        $kandang = $this->kandangRepository->find($kandangId);
        return view('kandang::populasi-ayam-2.create', compact(['kandang']));
    }

    public function store(Request $request, $kandangId, $tanggal)
    {
        $items = $request->collect('items')->map(function($item) use($request, $kandangId, $tanggal) {
            $item['kandang_id'] = $kandangId;
            $item['tanggal']    = $tanggal;
            $item['umur_ayam']  = $request->input('umur_ayam');
            return $item;
        });

        DB::beginTransaction();
        try {
            app(PopulasiAyamService::class)->savePopulasiAyam2($items);
            DB::commit();
            return back()->with('success', 'Data populasi berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return back()
                ->withInput()
                ->with('danger', 'Data populasi gagal disimpan.');
        }
    }
}