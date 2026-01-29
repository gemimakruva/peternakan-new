<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Peternakan;

class FlockController extends Controller
{
    public function __construct(
        private Peternakan $peternakan,
        private Flock $flock,
    ) { }

    public function index()
    {
        $search = request()->input('search');
        $kandangId = request()->input('kandang_id');
        $peternakanId = request()->input('peternakan_id');
        $perPage = request()->query('perPage', 10);
        
        $datas = $this->flock
            ->with(['pipes', 'kandang.peternakan'])
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('kandang', function ($sub) use ($search) {
                        $sub->where('nama', 'like', "%{$search}%");
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
            ->orderBy('nama', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        
        $peternakan = $this->peternakan->with('kandang')->get();
        
        return view('kandang::master-data.flock.index', compact('datas', 'peternakan', 'kandangId', 'peternakanId', 'search'));
    }

    public function show(Flock $flock)
    {
        return to_route('master-data.kandang.flock.show', [
            'kandang' => $flock->kandang,
            'flock' => $flock,
            'back_uri' => route('master-data.flock.index')
        ]);
    }

    public function edit(Flock $flock)
    {
        Gate::authorize('Edit Flock');

        $flock->load([
            'kandang:id,peternakan_id,nama',
            'kandang.peternakan:id,nama',
        ]);

        return view('kandang::master-data.flock.edit', compact('flock'));
    }

    /**
     * Update data dasar Flock (nama dan date_in).
     */
    public function update(Request $request, Flock $flock)
    {
        Gate::authorize('Edit Flock');
        
        $validated = $request->validate([
            'nama'=> ['required', 'string', 'max:255']
        ]);

        try {
            $flock->update([
                'nama' => $validated['nama'],
            ]);
            
            return to_route('master-data.flock.index')->with('success', 'Flock berhasil diperbarui.');
        } catch (\Throwable $th) {
            return back()
                ->withInput()
                ->with('danger', 'Flock gagal diperbarui.');
        }
    }

    public function destroy(Flock $flock)
    {
        Gate::authorize('Hapus Flock');

        if($flock->pipes()->exists()) {
            return to_route('master-data.flock.index')
                ->with('danger', 'Data Flock tidak dapat dihapus karena memiliki pipa terkait.');
        }

        try {
            $flock->delete();
            return to_route('master-data.flock.index')->with('success', 'Data Flock berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan saat menghapus data Flock.');
        }
    }
}
