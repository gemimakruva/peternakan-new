<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Kandang\Models\Kandang;

class KandangController extends Controller
{
    public function __construct(
        private Kandang $kandang,
    ) { }

    public function index()
    {
        Gate::authorize('Lihat Semua Kandang');

        $datas = $this->kandang
            ->query()
            ->when(request()->query('search'), function($query, $search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(request()->get('perPage', 10));

        return view('kandang::master-data.kandang.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('Tambah Kandang');

        return view('kandang::master-data.kandang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        Gate::authorize('Tambah Kandang');

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:1000'],
        ]);

        $this->kandang->create($request->all());

        return to_route('master-data.kandang.index')->with('success', 'Data Berhasil Ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        Gate::authorize('Edit Kandang');

        $data = $this->kandang->findOrFail($id);

        return view('kandang::master-data.kandang.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        Gate::authorize('Edit Kandang');

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:1000'],
        ]);

        $kandang = $this->kandang->findOrFail($id);
        $kandang->nama = $request->input('nama');
        $kandang->alamat = $request->input('alamat');
        $kandang->save();

        return to_route('master-data.kandang.index')->with('success', 'Data Berhasil Diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        Gate::authorize('Hapus Kandang');

        $kandang = $this->kandang->findOrFail($id);
        $kandang->delete();

        return to_route('master-data.kandang.index')->with('danger', 'Data Berhasil Dihapus.');
    }
}
