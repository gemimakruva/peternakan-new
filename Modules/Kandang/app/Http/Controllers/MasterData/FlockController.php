<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Peternakan;
use Modules\Kandang\Models\Pipe;

class FlockController extends Controller
{
    /**
     * Dependency Injection model Flock
     * Digunakan agar pemanggilan model lebih konsisten.
     */
    public function __construct(
        private Flock $flock,
    ) { }

    /**
     * Menampilkan daftar seluruh Flock.
     * Menggunakan pagination & eager load relasi pipes.
     */
    public function index()
    {
        $search = request()->input('search');
        $kandangId = request()->input('kandang_id');
        $peternakanId = request()->input('peternakan_id');
        $perPage = request()->query('perPage', 10);
        
        $datas = $this->flock
            ->with(['pipes', 'kandang.peternakan'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhereHas('kandang', function ($sub) use ($search) {
                            $sub->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->when($kandangId, function ($query) use ($kandangId) {
                $query->where('kandang_id', $kandangId);
            })
            ->when($peternakanId, function ($query) use ($peternakanId) {
                $query->whereHas('kandang', function ($q) use ($peternakanId) {
                    $q->where('peternakan_id', $peternakanId);
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        
        $peternakan = Peternakan::with('kandang')->get();
        
        return view('kandang::master-data.flock.index', compact('datas', 'peternakan', 'kandangId', 'peternakanId', 'search'));
    }

    /**
     * Menampilkan form untuk membuat Flock baru.
     * Mengambil seluruh data kandang untuk kebutuhan dropdown.
     */
    public function create()
    {
        Gate::authorize('Tambah Flock');
        $peternakan = Peternakan::with('kandang')->get();
        return view('kandang::master-data.flock.create', compact('peternakan'));
    }

    /**
     * Menyimpan Flock baru beserta auto-generate Pipe.
     * Pipe dibuat berdasarkan jumlah yang diminta dan keyword nama pipe.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'pipe_keyword' => 'required|string|max:100',
            'kandang_id'   => 'required|exists:kandang,id',
            'pipe_count'   => 'required|integer|min:1',
           
        ]);

        try {
         // Membuat Flock baru
            $flock = Flock::create([
                'nama' => $validated['nama'],
                'kandang_id' => $validated['kandang_id'],
                'kapasitas' => 0
            ]);

            $pipeCount = intval($validated['pipe_count']);
            $keyword   = $validated['pipe_keyword'];

            for ($i = 1; $i <= $pipeCount; $i++) {
                Pipe::create([
                    'nama'      => "{$keyword}-{$i}",
                    'flock_id'  => $flock->id,
                    'kapasitas' => 0,
                ]);
            }

            return redirect()
                ->route('master-data.flock.index')
                ->with('success', 'Flock dan Pipe berhasil dibuat!');
         }
            catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat menyimpan data, silahkan coba lagi' );
         }
    }

    /**
     * Menampilkan detail Flock (optional page).
     */
    public function show($id)
    {
        return view('kandang::master-data.flock.show');
    }

    /**
     * Menampilkan form edit Flock.
     * Sekaligus mengambil data pipes untuk ditampilkan.
     */
    public function edit(Flock $flock)
    {
        Gate::authorize('Edit Flock');
        $flock->load('kandang.peternakan');
        $peternakan = Peternakan::with('kandang')->get();
        return view('kandang::master-data.flock.edit', compact('flock', 'peternakan'));
    }

    /**
     * Update data dasar Flock (nama dan date_in).
     */
    public function update(Request $request, Flock $flock)
    {
        Gate::authorize('Edit Flock');

        $validated = $request->validate([
            'nama'=> ['required', 'string', 'max:255', Rule::exists('flock', 'nama')->whereNot('id', $flock->id)]
        ]);

        try {
            $flock->update([
                'nama' => $validated['nama'],
            ]);
        return to_route('master-data.flock.index')
            ->with('success', 'Flock berhasil diperbarui.');
        } catch (\Throwable $th) {
            return to_route('master-data.flock.index')
                ->with('danger', 'Flock gagal diperbarui. Silahkan coba lagi');
        }
    }

    /**
     * Menghapus Flock beserta relasinya (cascade tergantung DB).
     */
    public function destroy(Flock $flock)
    {
        Gate::authorize('Hapus Baris');

        if($flock->pipes()->exists()) {
            return to_route('master-data.flock.index')
                ->with('danger', 'Data Baris tidak dapat dihapus karena memiliki pipa terkait.');
        }

        $flock->delete();

        return to_route('master-data.flock.index')
            ->with('danger', 'Data Baris berhasil dihapus.');
    }
}
