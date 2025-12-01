<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Pipe;

class PipeController extends Controller
{
    /**
     * Inisialisasi model Pipe melalui Dependency Injection.
     * Memudahkan pemanggilan model di seluruh method.
     */
    public function __construct(
        private Pipe $pipe,
    ) { }

    /**
     * Menampilkan daftar seluruh Pipe dengan fitur pagination.
     * Biasanya digunakan untuk melihat semua Pipe dari seluruh Flock.
     */
    public function index()
    {
        Gate::authorize('Lihat Semua Pipe');
        $datas = $this->pipe
            ->query()
            ->with(['flock', 'flock.kandang'])
            ->orderBy('updated_at', 'desc') 
            ->paginate(request()->query('perPage', 10));

        return view('kandang::master-data.pipe.index', compact('datas'));
    }

    /**
     * Menampilkan daftar Pipe berdasarkan Flock tertentu.
     * Digunakan ketika user ingin melihat semua Pipe milik satu Flock (kandang).
     */
    public function indexByFlock(Flock $flock)
    {
        Gate::authorize('Lihat Semua Pipe');
        $flock->load('pipes');
        $pipes = $flock->pipes;

        return view(
            'kandang::master-data.pipe.index_by_flock',
            compact('flock', 'pipes')
        );
    }

    /**
     * Menampilkan form untuk membuat Pipe secara manual.
     * (Biasanya jarang digunakan jika Pipe digenerate otomatis saat membuat Flock)
     */
    public function create()
    {
        Gate::authorize('Tambah Pipe');

        return view('kandang::master-data.pipe.create');
    }

    /**
     * Menyimpan Pipe baru (jika fitur create digunakan).
     * Saat ini masih kosong karena Pipe biasanya di-generate otomatis.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Menampilkan detail satu Pipe (opsional).
     */
    public function show($id)
    {
        return view('kandang::master-data.pipe.show');
    }

    /**
     * Menampilkan form edit Pipe berdasarkan ID.
     */
    public function edit(Pipe $pipe)
    {
        Gate::authorize('Edit Pipe');
        return view('kandang::master-data.pipe.edit', compact('pipe'));
    }

    /**
     * Mengupdate data Pipe.
     * Method ini digunakan ketika admin ingin mengubah nama pipe atau kapasitas maksimal.
     */
    public function update(Request $request, Pipe $pipe)
    {
        Gate::authorize('Edit Pipe');
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kapasitas'  => ['required', 'numeric', 'min:0'],
        ]);
        $pipe->update($validated);

        return redirect()
            ->route('master-data.pipe.index')
            ->with('success', 'Data Pipe berhasil diperbarui!');
    }

    /**
     * Menghapus Pipe berdasarkan ID.
     * Biasanya digunakan jika admin ingin merapikan data atau ada Pipe yang tidak digunakan.
     */
    public function destroy($id)
    {
        Gate::authorize('Hapus Pipe');

        $pipe = $this->pipe->findOrFail($id);
        $pipe->delete();

        return to_route('master-data.pipe.index')
            ->with('danger', 'Data Pipe berhasil dihapus.');
    }
}
