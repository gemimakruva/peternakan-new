<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\JenisOvk;
use Modules\Kandang\Repositories\Treatment\JenisOvkRepository;

class JenisOvkController extends Controller
{
    public function __construct(
        private JenisOvkRepository $repository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10)
        );
        return view('kandang::master-data.jenis-ovk.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandang::master-data.jenis-ovk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'nama' => ['required', 'string', 'unique:jenis_ovk,nama'],
        ]);

        $this->repository
            ->getModel()
            ->create($request->only('nama'));

        return to_route('master-data.jenis-ovk.index')->with('success', 'OVK Baru Berhasil Ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisOvk $jenisOvk)
    {
        $data = $jenisOvk;
        return view('kandang::master-data.jenis-ovk.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisOvk $jenisOvk) {
        $request->validate([
            'nama' => ['required', 'string', Rule::unique('jenis_ovk', 'nama')->ignore($jenisOvk->id)],
        ]);

        $jenisOvk->fill($request->only('nama'));
        $jenisOvk->save();

        return to_route('master-data.jenis-ovk.index')->with('success', 'OVK Berhasil Diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisOvk $jenisOvk) {
        $jenisOvk->delete();

        return to_route('master-data.jenis-ovk.index')->with('success', 'OVK Berhasil Dihapus.');
    }
}
