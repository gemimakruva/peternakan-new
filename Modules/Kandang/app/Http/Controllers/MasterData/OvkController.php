<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\Ovk;
use Modules\Kandang\Repositories\Treatment\JenisOvkRepository;
use Modules\Kandang\Repositories\Treatment\OvkRepository;
use Modules\Kandang\Repositories\Treatment\SatuanRepository;

class OvkController extends Controller
{
    public function __construct(
        private OvkRepository $repository,
        private JenisOvkRepository $jenisOvkRepository,
        private SatuanRepository $satuanRepository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10),
        );
        return view('kandang::master-data.ovk.index', compact('datas'));
    }

    public function create()
    {
        $listJenisOvk = $this->jenisOvkRepository->getSelectItems();
        $listSatuan = $this->satuanRepository->getModel()->get();
        return view('kandang::master-data.ovk.create', compact(['listJenisOvk', 'listSatuan']));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'jenis_ovk_id'                  => ['required', 'numeric', 'exists:jenis_ovk,id'],
            'nama'                          => ['required', 'string', 'unique:ovk,nama'],
            'dosis_pembilang'               => ['required', 'numeric', 'min:0'],
            'dosis_pembilang_satuan_id'     => ['required', 'numeric', 'exists:satuan,id'],
            'dosis_penyebut'                => ['required', 'numeric', 'min:0'],
            'dosis_penyebut_satuan_id'      => ['required', 'numeric', 'exists:satuan,id'],
            'penggunaan_per_hari'           => ['required', 'numeric', 'min:0'],
            'penggunaan_per_hari_satuan_id' => ['required', 'numeric', 'exists:satuan,id'],
            'harga'                         => ['required', 'numeric', 'min:0'],
            'harga_per_satuan'              => ['required', 'numeric', 'min:0'],
            'harga_per_satuan_id'           => ['required', 'numeric', 'exists:satuan,id'],
        ]);

        $this->repository->getModel()->create($validated);

        return to_route('master-data.ovk.index')->with('success', 'Data OVK Berhasil Ditambahkan.');
    }

    public function edit(Ovk $ovk)
    {
        $data = $ovk;
        $listJenisOvk = $this->jenisOvkRepository->getSelectItems();
        $listSatuan = $this->satuanRepository->getModel()->get();
        return view('kandang::master-data.ovk.edit', compact(['data', 'listJenisOvk', 'listSatuan']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ovk $ovk) {
        $validated = $request->validate([
            'jenis_ovk_id'                  => ['required', 'numeric', 'exists:jenis_ovk,id'],
            'nama'                          => ['required', 'string', Rule::unique('ovk', 'nama')->ignore($ovk->id)],
            'dosis_pembilang'               => ['required', 'numeric', 'min:0'],
            'dosis_pembilang_satuan_id'     => ['required', 'numeric', 'exists:satuan,id'],
            'dosis_penyebut'                => ['required', 'numeric', 'min:0'],
            'dosis_penyebut_satuan_id'      => ['required', 'numeric', 'exists:satuan,id'],
            'penggunaan_per_hari'           => ['required', 'numeric', 'min:0'],
            'penggunaan_per_hari_satuan_id' => ['required', 'numeric', 'exists:satuan,id'],
            'harga'                         => ['required', 'numeric', 'min:0'],
            'harga_per_satuan'              => ['required', 'numeric', 'min:0'],
            'harga_per_satuan_id'           => ['required', 'numeric', 'exists:satuan,id'],
        ]);

        $ovk->fill($validated);
        $ovk->save();

        return to_route('master-data.ovk.index')->with('success', 'Data OVK Berhasil Diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ovk $ovk) {
        $ovk->delete();
        return to_route('master-data.ovk.index')->with('success', 'Data OVK Berhasil Dihapus.');
    }
}
