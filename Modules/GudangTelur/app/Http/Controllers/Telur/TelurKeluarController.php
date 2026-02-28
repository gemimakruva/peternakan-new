<?php

namespace Modules\GudangTelur\Http\Controllers\Telur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Enums\TelurJenisTipe;
use Modules\GudangTelur\Models\TelurKeluar;
use Modules\GudangTelur\Repositories\Kemasan\KemasanInventoryRepository;
use Modules\GudangTelur\Repositories\MasterData\TelurJenisRepository;
use Modules\GudangTelur\Repositories\Telur\TelurKeluarRepository;
use Modules\GudangTelur\Repositories\Telur\TelurTujuanRepository;

class TelurKeluarController extends Controller
{
    public function __construct(
        private TelurKeluarRepository $repository,
        private TelurJenisRepository $telurJenisRepository,
        private TelurTujuanRepository $telurTujuanRepository,
        private KemasanInventoryRepository $kemasanInventoryRepository,
    ) { }

    public function index(Request $request)
    {
        $dateStart  = $request->query('date_start', now()->startOfYear()->format('Y-m-d'));
        $dateEnd    = $request->query('date_end', now()->endOfYear()->format('Y-m-d'));

        $request->merge([
            'date_start'    => $dateStart,
            'date_end'      => $dateEnd,
        ]);

        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['date_start', 'date_end']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        return view('gudang-telur::telur.keluar.index', compact([
            'dateStart',
            'dateEnd',
            'datas',
        ]));
    }

    public function create()
    {
        $listTelurJenis = $this->telurJenisRepository
            ->getModel()
            ->where('tipe', '=', TelurJenisTipe::KELUAR->value)
            ->get(['id', 'nama']);
        $listTujuanTelur = $this->telurTujuanRepository->getSelectItems();
        $listKemasanInventory = $this->kemasanInventoryRepository->getQuery()->get();

        return view('gudang-telur::telur.keluar.create', compact([
            'listTelurJenis',
            'listTujuanTelur',
            'listKemasanInventory',
        ]));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'telur_tujuan_id'   => ['required'],
            'tanggal'           => ['required', 'date_format:Y-m-d'],
            'items.*'                   => ['array'],
            'items.*.id'                => ['nullable', 'exists:telur_inventory,id'],
            'items.*.telur_jenis_id'    => ['required', 'exists:telur_jenis,id'],
            'items.*.jumlah'            => ['nullable', 'numeric', 'min:0'],
            'kemasan_items.*.'              => ['array'],
            'kemasan_items.*.id'            => ['nullable', 'exists:kemasan_inventory,id'],
            'kemasan_items.*.kemasan_id'    => ['required', 'exists:kemasan,id'],
            'kemasan_items.*.jumlah'        => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $telurKeluar = $this->repository->save($validated);

        return to_route('gudang-telur.telur-keluar.edit', $telurKeluar)
            ->with('success', 'Data Telur Keluar Berhasil Ditambahkan.');
    }

    public function edit(TelurKeluar $telurKeluar)
    {
        $telurKeluar->load([
            'telurInventory.telurJenis',
            'kemasanOutput.kemasanInventory'
        ]);
        $listTelurJenis = $this->telurJenisRepository
            ->getModel()
            ->where('tipe', '=', TelurJenisTipe::KELUAR->value)
            ->get(['id', 'nama']);
        $listTujuanTelur = $this->telurTujuanRepository->getSelectItems();
        $listKemasanInventory = $this->kemasanInventoryRepository->context($telurKeluar->kemasan_output_id)->getQuery()->get();
        $data = $telurKeluar;

        return view('gudang-telur::telur.keluar.edit', compact([
            'data',
            'listTelurJenis',
            'listTujuanTelur',
            'listKemasanInventory',
        ]));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kemasan_output_id' => ['required'],
            'telur_tujuan_id'   => ['required'],
            'tanggal'           => ['required', 'date_format:Y-m-d'],
            'items.*'                   => ['array'],
            'items.*.id'                => ['nullable', 'exists:telur_inventory,id'],
            'items.*.telur_jenis_id'    => ['required', 'exists:telur_jenis,id'],
            'items.*.jumlah'            => ['nullable', 'numeric', 'min:0'],
            'kemasan_items.*.'              => ['array'],
            'kemasan_items.*.id'            => ['nullable', 'exists:kemasan_inventory,id'],
            'kemasan_items.*.kemasan_id'    => ['required', 'exists:kemasan,id'],
            'kemasan_items.*.jumlah'        => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['id'] = $id;
        $validated['pic_user_id'] = auth()->id();
        $this->repository->save($validated);

        return to_route('gudang-telur.telur-keluar.index')
            ->with('success', 'Data Telur Keluar Berhasil Diupdate.');
    }

    public function destroy(TelurKeluar $telurKeluar)
    {
        $telurKeluar->telurInventory()->delete();
        $telurKeluar->delete();

        return back()->with('success', 'Data Telur Keluar Berhasil Dihapus.');
    }
}
