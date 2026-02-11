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

    public function create()
    {
        $listKandang = $this->kandangRepository->getSelectItems();
        return view('kandang::populasi-ayam-2.create', compact(['listKandang']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kandang_id'    => ['required', 'exists:kandang,id'],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
        ]);

        return to_route('populasi-ayam-2.create.detail', [$validated['kandang_id'], $validated['tanggal']])
            ->with('success', 'Inputkan Detail Populasi Ayam');
    }

    public function createDetail($kandangId, $tanggal)
    {
        $kandang = $this->kandangRepository->find($kandangId);
        return view('kandang::populasi-ayam-2.create-detail', compact(['kandang']));
    }

    public function edit($kandangId, $tanggal)
    {
        $kandang = $this->kandangRepository->find($kandangId);
        return view('kandang::populasi-ayam-2.edit', compact(['kandang']));
    }

    public function update(Request $request, $kandangId, $tanggal)
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