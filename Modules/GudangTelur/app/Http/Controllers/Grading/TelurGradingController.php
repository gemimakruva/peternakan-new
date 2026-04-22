<?php

namespace Modules\GudangTelur\Http\Controllers\Grading;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Enums\TelurJenisTipe;
use Modules\GudangTelur\Models\TelurGrading;
use Modules\GudangTelur\Models\TelurJenis;
use Modules\GudangTelur\Repositories\Grading\TelurGradingRepository;
use Modules\Kandang\Repositories\Kandang\KandangRepository;

class TelurGradingController extends Controller
{
    public function __construct(
        private TelurGradingRepository $repository,
        private KandangRepository $kandangRepository,
    ) {
        $this->middleware('can:gudang-telur.grading-telur.menu-grading-telur');
    }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['kandang_id']),
            $request->collect('orders'),
            $request->query('perPage', 10)
        );
        $listKandang = $this->kandangRepository->getSelectItems();
        return view('gudang-telur::grading.index', compact([
            'datas',
            'listKandang',
        ]));
    }

    public function create()
    {
        $listKandang = $this->kandangRepository->getSelectItems();
        $listGrading = app(TelurJenis::class)
            ->where('tipe', '=', TelurJenisTipe::GRADING->value)
            ->pluck('nama', 'id');
        return view('gudang-telur::grading.create', compact([
            'listKandang',
            'listGrading',
        ]));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'kandang_id'    => ['required', 'exists:kandang,id'],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
            'grading.*'                 => ['required', 'array'],
            'grading.*.telur_jenis_id'  => ['required', 'exists:telur_jenis,id'],
            'grading.*.jumlah'          => ['nullable', 'numeric'],
        ]);

        $validated['pic_user_id'] = auth()->id();
        $telurGrading = $this->repository->save($validated);

        return to_route('gudang-telur.telur-grading.edit', $telurGrading)
            ->with('success', 'Data Grading Telur Berhasil Disimpan!');
    }

    public function edit(TelurGrading $telurGrading)
    {
        $listKandang = $this->kandangRepository->getSelectItems();
        $listGrading = app(TelurJenis::class)
            ->where('tipe', '=', TelurJenisTipe::GRADING->value)
            ->pluck('nama', 'id');
        $telurGrading->load('telurGradingItems');
        $data = $telurGrading;
        return view('gudang-telur::grading.edit', compact([
            'listKandang',
            'listGrading',
            'data',
        ]));
    }

    public function update(Request $request, $id) 
    {
        $validated = $request->validate([
            'kandang_id'    => ['required', 'exists:kandang,id'],
            'tanggal'       => ['required', 'date_format:Y-m-d'],
            'grading.*'                 => ['required', 'array'],
            'grading.*.telur_jenis_id'  => ['required', 'exists:telur_jenis,id'],
            'grading.*.jumlah'          => ['nullable', 'numeric'],
        ]);

        $validated['id'] = $id;
        $validated['pic_user_id'] = auth()->id();
        $this->repository->save($validated);

        return to_route('gudang-telur.telur-grading.index')
            ->with('success', 'Data Grading Telur Berhasil Diupdate!');
    }

    public function destroy(TelurGrading $telurGrading) 
    {
        $telurGrading->telurGradingItems()->delete();
        $telurGrading->delete();
        return back()->with('success', 'Data Grading Telur Berhasil Dihapus!');
    }
}
