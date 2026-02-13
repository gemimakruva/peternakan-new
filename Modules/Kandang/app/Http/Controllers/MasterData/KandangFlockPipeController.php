<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Peternakan;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\Strain;

class KandangFlockPipeController extends Controller
{

    public function __construct(
        private Strain $strain,
        private Peternakan $peternakan,
        private Kandang $kandang,
        private Flock $flock,
        private Pipe $pipe,
    ) {
        $this->middleware('can:master-data.master-data.menu-pipe');
    }

    public function create(Kandang $kandang, Flock $flock)
    {
        $kandang->load('peternakan:id,nama');

        return view('kandang::master-data.kandang.flock.pipe.create', compact(['kandang', 'flock']));
    }

    public function store(Kandang $kandang, Flock $flock)
    {
        request()->validate([
            'nama'=> ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'integer', 'min:1'],
        ]);

        request()->merge([
            'flock_id' => $flock->id,
        ]);

        try {
            $this->pipe->create(request()->only(['flock_id', 'nama', 'kapasitas']));

            return to_route('master-data.kandang.flock.show', [$kandang, $flock])->with('success', 'Pipa berhasil dibuat.');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('danger', 'Pipa gagal dibuat.');
        }
    }
    
    public function edit(Kandang $kandang, Flock $flock, Pipe $pipe)
    {
        return view('kandang::master-data.kandang.flock.pipe.edit', compact(['kandang', 'flock', 'pipe']));
    }

    public function update(Kandang $kandang, Flock $flock, Pipe $pipe)
    {
        request()->validate([
            'nama'=> ['required', 'string', 'max:255', Rule::unique('pipe', 'nama')->ignore($pipe)],
            'kapasitas' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $pipe->update(request()->only(['nama', 'kapasitas']));

            return to_route('master-data.kandang.flock.show', [$kandang, $flock])->with('success', 'Pipa berhasil diperbarui.');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('danger', 'Pipa gagal diperbarui.');
        }
    }

    public function destroy(Kandang $kandang, Flock $flock, Pipe $pipe)
    {
        if($pipe->pengadaanAyamDistribusi()->exists()) {
            return back()->with('danger', 'Data Pipe tidak dapat dihapus, karena memiliki Pengadaan Distribusi terkait.');
        }

        try {
            $pipe->delete();
            return to_route('master-data.kandang.flock.show', [$kandang, $flock])->with('success', 'Pipa berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('danger', 'Terjadi kesalahan saat menghapus Pipa.');
        }
    }
}