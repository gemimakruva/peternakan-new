<?php

namespace Modules\Kandang\Http\Controllers\PerhitunganPakan;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Repositories\Pakan\PemberianPakanSisaPakanRepository;

class PemberianPakanSisaPakanController extends Controller
{
    public function __construct(
        private PemberianPakanSisaPakanRepository $repository,
    ) {
        $this->middleware('can:kandang.pakan.menu-pemberian-pakan-dan-sisa-pakan');
    }

    public function index(Request $request)
    {
        // column: tanggal, kandang, jenis pakan, pelaksana, pemberian pakan, sisa pakan
        // filter: kandang_id, user_executor_id
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            // $request->collect(['kandang_id', 'user_executor_id']),
            $request->collect('orders'),
            $request->query('perPage', 10)
        );

        $datas->transform(function($item) {
            $item->tanggal_pemberian_pakan = Carbon::createFromFormat('Y-m-d', $item->tanggal_pemberian_pakan);
            return $item;
        });

        return view('kandang::pemberian-pakan-sisa-pakan.index', compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'perhitungan_pakan_id'              => ['required', 'exists:perhitungan_pakan,id'],
            'items'                             => ['required', 'array'],
            'items.*.flock_id'                  => ['required', 'exists:flock,id'],
            'items.*.sisa_pakan_per_flock_kg'   => ['required', 'min:0'],
        ]);

        foreach ($validated['items'] as $item) {
            $this->repository->getModel()
                ->updateOrCreate([
                    'perhitungan_pakan_id'  => $validated['perhitungan_pakan_id'],
                    'flock_id'              => $item['flock_id'],
                ], [
                    'sisa_pakan_per_flock_kg' => $item['sisa_pakan_per_flock_kg'],
                ]);
        }

        return back()->with('success', 'Data pemberian pakan dan sisa pakan berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerhitunganPakan $perhitunganPakan)
    {
        $perhitunganPakan->load([
            'kandang',
            'perhitunganPakanItems.flock',
            'userCreator',
            'userExecutor',
            'jenisPakan',
            'pemberianPakanSisaPakan'
        ]);

        $flockIds = $perhitunganPakan->perhitunganPakanItems->pluck('flock_id')->unique()->values();

        if ($flockIds->count() === 0) {
            return to_route('pemberian-pakan-sisa-pakan.index')->with('danger', 'Pemberian Pakan Belum Ditambahkan.');
        }

        foreach ($flockIds as $id) {
            $collectByFlock = $perhitunganPakan->perhitunganPakanItems->filter(fn($item) => $item->flock_id == $id);
            $tables[$id]['flock_id']                 = $id;
            $tables[$id]['nama_flock']               = $perhitunganPakan->perhitunganPakanItems->first(fn($item) => $item->flock_id == $id)->flock->nama;
            $tables[$id]['jumlah_ayam']              = $collectByFlock->sum('jumlah_ayam');
            $tables[$id]['pemberian_pakan_kg']       = $collectByFlock->sum(fn($item2) => $item2->jumlah_ayam*$item2->pemberian_pakan_per_ekor)/1000;
            $tables[$id]['pemberian_pakan_pagi_kg']  = $tables[$id]['pemberian_pakan_kg'] * ($perhitunganPakan->proporsi_pemberian_pagi/100);
            $tables[$id]['pemberian_pakan_sore_kg']  = $tables[$id]['pemberian_pakan_kg'] * ($perhitunganPakan->proporsi_pemberian_sore/100);
            $tables[$id]['sisa_pakan_per_flock_kg']  = $perhitunganPakan->pemberianPakanSisaPakan->first(fn($item) => $item->flock_id == $id)?->sisa_pakan_per_flock_kg ?? 0;
        }
        $tables = collect($tables);
        return view('kandang::pemberian-pakan-sisa-pakan.edit', compact(['perhitunganPakan', 'tables']));
    }
}
