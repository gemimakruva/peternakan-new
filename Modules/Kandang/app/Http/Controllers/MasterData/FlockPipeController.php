<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Pipe;

class FlockPipeController extends Controller
{
    public function edit(Flock $flock, Pipe $pipe)
    {
        return view('kandang::master-data.flock.pipe.edit', compact(['flock', 'pipe']));
    }

    public function update(Flock $flock, Pipe $pipe)
    {
        request()->validate([
            'nama'=> ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $pipe->update(request()->only(['nama', 'kapasitas']));

            return to_route('master-data.flock.show', $flock)->with('success', 'Flock berhasil diperbarui.');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('danger', 'Flock gagal diperbarui. Silahkan coba lagi');
        }
    }

    public function destroy(Flock $flock, Pipe $pipe)
    {
        if($pipe->pengadaanAyamDistribusi()->exists()) {
            return back()->with('danger', 'Data Pipe tidak dapat dihapus, karena memiliki Pengadaan Distribusi terkait.');
        }

        try {
            $pipe->delete();
            return to_route('master-data.flock.show', $flock)->with('success', 'Data Pipe berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('danger', 'Terjadi kesalahan saat menghapus data Pipe.');
        }
    }
}