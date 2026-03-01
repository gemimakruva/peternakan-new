<?php

namespace Modules\GudangTelur\Http\Controllers\Telur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Enums\TelurJenisTipe;
use Modules\GudangTelur\Models\TelurMasuk;
use Modules\GudangTelur\Repositories\MasterData\TelurJenisRepository;
use Modules\GudangTelur\Repositories\Telur\TelurAsalRepository;
use Modules\GudangTelur\Repositories\Telur\TelurMasukRepository;

class TelurMasukController extends Controller
{
    public function __construct(
        private TelurMasukRepository $repository,
        private TelurJenisRepository $telurJenisRepository,
        private TelurAsalRepository $telurAsalRepository,
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
            $request->collect(['tanggal']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('gudang-telur::telur.masuk.index', compact([
            'datas',
            'dateStart',
            'dateEnd',
        ]));
    }

    public function create()
    {
        $items = $this->telurJenisRepository
            ->setContext(TelurJenisTipe::MASUK->value)
            ->getQuery()
            ->get()
            ->map(function($item) {
                return [
                    'telur_jenis_id'    => $item->id,
                    'telur_jenis'        => $item,
                ];
            });
        $listAsalTelur = $this->telurAsalRepository->getSelectItems();

        return view('gudang-telur::telur.masuk.create', compact([
            'items',
            'listAsalTelur',
        ]));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            "telur_asal_id" => ['required'],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
            'items.*'       => ['array'],
            'items.*.id'                => ['nullable', 'exists:telur_inventory,id'],
            'items.*.telur_jenis_id'    => ['required', 'exists:telur_jenis,id'],
            'items.*.jumlah'            => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $telurMasuk = $this->repository->save($validated);

        return to_route('gudang-telur.telur-masuk.edit', $telurMasuk)
            ->with('success', 'Data Telur Masuk Berhasil Ditambahkan.');
    }

    public function edit(TelurMasuk $telurMasuk)
    {
        $telurMasuk->load('telurInventory.telurJenis');
        $data = $telurMasuk;
        $items = $this->telurJenisRepository
            ->setContext(TelurJenisTipe::MASUK->value)
            ->getQuery()
            ->get()
            ->map(function($item) use($telurMasuk) {
                $_telurMasuk = $telurMasuk
                    ->telurInventory
                    ->first(fn($item2) => $item2->telur_jenis_id == $item->id)
                    ?->toArray();
                return $_telurMasuk ?? [
                    'telur_jenis_id'    => $item->id,
                    'telur_jenis'       => $item,
                ];
            });
        $listAsalTelur = $this->telurAsalRepository->getSelectItems();

        return view('gudang-telur::telur.masuk.edit', compact([
            'data',
            'items',
            'listAsalTelur',
        ]));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "telur_asal_id" => ['required'],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
            'items.*'       => ['array'],
            'items.*.id'                => ['nullable', 'exists:telur_inventory,id'],
            'items.*.telur_jenis_id'    => ['required', 'exists:telur_jenis,id'],
            'items.*.jumlah'            => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['id'] = $id;
        $validated['pic_user_id'] = auth()->id();
        $this->repository->save($validated);

        return to_route('gudang-telur.telur-masuk.index')
            ->with('success', 'Data Telur Masuk Berhasil Diupdate.');
    }

    public function destroy(TelurMasuk $telurMasuk)
    {
        $telurMasuk->telurInventory()->delete();
        $telurMasuk->delete();

        return back()->with('success', 'Data Telur Masuk Berhasil Dihapus.');
    }
}
