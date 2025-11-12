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
    public function __construct(
        private Flock $flock,
    ) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = $this->flock
    ->with('pipes') // eager load pipes
    ->paginate(request()->query('perPage', 10));
        return view('kandang::master-data.flock.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    Gate::authorize('Tambah Flock');
    $kandangs = Kandang::all(); // ambil semua kandang
    return view('kandang::master-data.flock.create', compact('kandangs'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1️⃣ Validasi request
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'kandang_id' => 'required|exists:kandang,id',
        'date_in' => 'required|date',
        'pipe_count' => 'required|integer|min:1',
        'pipe_keyword' => 'required|string|max:100', // kata kunci nama pipe
    ]);

    // 2️⃣ Buat Flock
    $flock = Flock::create([
        'flock_name' => $validated['nama'],
        'kandang_id' => $validated['kandang_id'],
        'date_in' => $validated['date_in'],
    ]);

  

    // 3️⃣ Generate Pipe sesuai jumlah
   $pipeCount = intval($validated['pipe_count']);
    $keyword = $validated['pipe_keyword'];
    for ($i = 1; $i <= $pipeCount; $i++) {
        Pipe::create([
            'pipe_name' => $keyword . '-' . $i,
            'flock_id' => $flock->id,
            'capacity' => 0, 
            'initial_population' => 0,
        ]);
    }

    return redirect()->route('master-data.flock.index')
                     ->with('success', 'Flock dan Pipe berhasil dibuat!');
}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('kandang::master-data.flock.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Flock $flock)
{
    Gate::authorize('Edit Flock');
      $flock->load('pipes'); 
    $kandangs = Kandang::all();
    return view('kandang::master-data.flock.edit', compact('flock', 'kandangs'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flock $flock)
{
    Gate::authorize('Edit Flock');

    $validated = $request->validate([
        'nama'    => ['required', 'string', 'max:255'],
        'date_in' => ['required', 'date'],
    ]);

    $flock->update([
        'flock_name'    => $validated['nama'],
        'date_in' => $validated['date_in'],
    ]);

    return to_route('master-data.flock.index')
        ->with('success', 'Flock berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flock $flock) {
    Gate::authorize('Hapus Flock');
        $flock->delete();
    return to_route('master-data.flock.index')
        ->with('danger', 'Data Flock berhasil dihapus.');
    }
}
