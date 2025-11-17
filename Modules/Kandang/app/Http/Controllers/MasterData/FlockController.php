<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
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
        $datas = $this->flock
            ->with('pipes')
            ->paginate(request()->query('perPage', 10));

        return view('kandang::master-data.flock.index', compact('datas'));
    }

    /**
     * Menampilkan form untuk membuat Flock baru.
     * Mengambil seluruh data kandang untuk kebutuhan dropdown.
     */
    public function create()
    {
        Gate::authorize('Tambah Flock');

        $kandangs = Kandang::all();

        return view('kandang::master-data.flock.create', compact('kandangs'));
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
            'kandang_id'   => 'required|exists:kandang,id',
            'date_in'      => 'required|date',
            'pipe_count'   => 'required|integer|min:1',
            'pipe_keyword' => 'required|string|max:100',
        ]);

        // Membuat Flock baru
        $flock = Flock::create([
            'flock_name' => $validated['nama'],
            'kandang_id' => $validated['kandang_id'],
            'date_in'    => $validated['date_in'],
        ]);

        // Generate Pipe otomatis sesuai jumlah yang ditentukan
        $pipeCount = intval($validated['pipe_count']);
        $keyword   = $validated['pipe_keyword'];

        for ($i = 1; $i <= $pipeCount; $i++) {
            Pipe::create([
                'pipe_name'          => $keyword . '-' . $i,
                'flock_id'           => $flock->id,
                'capacity'           => 0,
                'initial_population' => 0,
            ]);
        }

        return redirect()
            ->route('master-data.flock.index')
            ->with('success', 'Flock dan Pipe berhasil dibuat!');
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

        $flock->load('pipes');
        $kandangs = Kandang::all();

        return view('kandang::master-data.flock.edit', compact('flock', 'kandangs'));
    }

    /**
     * Update data dasar Flock (nama dan date_in).
     */
    public function update(Request $request, Flock $flock)
    {
        Gate::authorize('Edit Flock');

        $validated = $request->validate([
            'nama'    => ['required', 'string', 'max:255'],
            'date_in' => ['required', 'date'],
        ]);

        $flock->update([
            'flock_name' => $validated['nama'],
            'date_in'    => $validated['date_in'],
        ]);

        return to_route('master-data.flock.index')
            ->with('success', 'Flock berhasil diperbarui.');
    }

    /**
     * Menghapus Flock beserta relasinya (cascade tergantung DB).
     */
    public function destroy(Flock $flock)
    {
        Gate::authorize('Hapus Flock');

        $flock->delete();

        return to_route('master-data.flock.index')
            ->with('danger', 'Data Flock berhasil dihapus.');
    }
}
