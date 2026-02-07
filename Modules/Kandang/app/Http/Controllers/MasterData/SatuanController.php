<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\Satuan;
use Modules\Kandang\Repositories\Treatment\SatuanRepository;

class SatuanController extends Controller
{
    public function __construct(
        private SatuanRepository $repository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10)
        );
        return view('kandang::master-data.satuan.index', compact('datas'));
    }

    public function create()
    {
        return view('kandang::master-data.satuan.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => ['required', 'string', 'unique:satuan,nama'],
            'standar_terkecil_satuan' => ['required', 'numeric', 'min:0'],
        ]);

        $this->repository
            ->getModel()
            ->create($request->only('nama', 'standar_terkecil_satuan'));

        return to_route('master-data.satuan.index')->with('success', 'Data Satuan Berhasil Ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        $data = $satuan;
        return view('kandang::master-data.satuan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Satuan $satuan) {
        $request->validate([
            'nama' => ['required', 'string', Rule::unique('satuan', 'nama')->ignore($satuan->id)],
            'standar_terkecil_satuan' => ['required', 'numeric', 'min:0'],
        ]);

        $satuan->fill($request->only('nama', 'standar_terkecil_satuan'));
        $satuan->save();

        return to_route('master-data.satuan.index')->with('success', 'Data Satuan Berhasil Diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan) {
        $satuan->delete();

        return to_route('master-data.satuan.index')->with('success', 'Data Satuan Berhasil Dihapus.');
    }
}
