<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Peternakan;
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
        
        $search = request()->input('search');
        $flockId = request()->input('flock_id');
        $kandangId = request()->input('kandang_id');
        $peternakanId = request()->input('peternakan_id');
        $perPage = request()->query('perPage', 10);
        
        $datas = $this->pipe
<<<<<<< HEAD
            ->query()
            ->with(['flock', 'flock.kandang'])
            ->orderBy('updated_at', 'desc') 
            ->paginate(request()->query('perPage', 10));
=======
            ->with(['flock.kandang.peternakan'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhereHas('flock', function ($sub) use ($search) {
                            $sub->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->when($flockId, function ($query) use ($flockId) {
                $query->where('flock_id', $flockId);
            })
            ->when($kandangId, function ($query) use ($kandangId) {
                $query->whereHas('flock', function ($q) use ($kandangId) {
                    $q->where('kandang_id', $kandangId);
                });
            })
            ->when($peternakanId, function ($query) use ($peternakanId) {
                $query->whereHas('flock.kandang', function ($q) use ($peternakanId) {
                    $q->where('peternakan_id', $peternakanId);
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        
        $peternakan = Peternakan::with(['kandang.flocks'])->get();
>>>>>>> master

        return view('kandang::master-data.pipe.index', compact('datas', 'peternakan', 'flockId', 'kandangId', 'peternakanId', 'search'));
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
            'kapasitas' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $pipe->update($validated);
           return redirect()->route('master-data.pipe.byFlock', $pipe->flock_id)
            ->with('success', 'Data Pipe berhasil diperbarui!');
        } catch (\Exception $e) {
            // Tangkap error jika terjadi masalah
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data Pipe.');
        }
    }


    /**
     * Menghapus Pipe berdasarkan ID.
     * Biasanya digunakan jika admin ingin merapikan data atau ada Pipe yang tidak digunakan.
     */
    public function destroy(Pipe $pipe)
    {
        Gate::authorize('Hapus Pipe');
        
        if($this->pipe->pengadaanAyamDistribusi()->exists()) {
            return redirect()
                ->route('master-data.pipe.index')
                ->with('error', 'Tidak dapat menghapus Pipa yang memiliki Pengadaan Ayam Distribusi.');
        }

        $pipe->delete();

        return to_route('master-data.pipe.index')
            ->with('danger', 'Data Pipe berhasil dihapus.');
    }


      public function destroyByFlock(Pipe $pipe)
    {
        Gate::authorize('Hapus Pipe');
        $flockId = $pipe->flock_id;
        $pipe->delete();
        try {
        $pipe->delete();
        return redirect()->route('master-data.flock.pipes', $flockId)
            ->with('success', 'Data Pipe berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 
            'Terjadi kesalahan saat menghapus data Pipe.');
    }
    }
}
