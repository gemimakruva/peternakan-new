<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Kandang\Models\Kandang;

class KandangController extends Controller
{
    /**
     * Dependency Injection model Kandang
     */
    public function __construct(
        private Kandang $kandang,
    ) { }

    /**
     * Menampilkan seluruh data kandang dengan fitur search, sort, dan pagination.
     */
    public function index()
    {
        Gate::authorize('Lihat Semua Kandang');

        $datas = $this->kandang
            ->with('flocks')
            ->when(request()->query('search'), function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(request()->get('perPage', 10));

        return view('kandang::master-data.kandang.index', compact('datas'));
    }

    /**
     * Menampilkan form untuk menambah data kandang.
     */
    public function create()
    {
        Gate::authorize('Tambah Kandang');

        return view('kandang::master-data.kandang.create');
    }

    /**
     * Menyimpan data kandang baru ke database.
     */
    public function store(Request $request)
    {
        Gate::authorize('Tambah Kandang');

        $validated = $request->validate([
            'nama'   => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:1000'],
        ]);

        $this->kandang->create($validated);

        return to_route('master-data.kandang.index')
            ->with('success', 'Data Berhasil Ditambahkan.');
    }

    /**
     * Menampilkan form edit data kandang.
     */
    public function edit($id)
    {
        Gate::authorize('Edit Kandang');

        $data = $this->kandang->findOrFail($id);

        return view('kandang::master-data.kandang.edit', compact('data'));
    }

    /**
     * Mengupdate data kandang di database.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('Edit Kandang');

        $validated = $request->validate([
            'nama'   => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:1000'],
        ]);

        $kandang = $this->kandang->findOrFail($id);
        $kandang->update($validated);

        return to_route('master-data.kandang.index')
            ->with('success', 'Data Berhasil Diubah.');
    }

    /**
     * Menghapus data kandang dari database.
     */
    public function destroy($id)
    {
        Gate::authorize('Hapus Kandang');

        $kandang = $this->kandang->findOrFail($id);
        $kandang->delete();

        return to_route('master-data.kandang.index')
            ->with('danger', 'Data Berhasil Dihapus.');
    }
}
