<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Modules\Kandang\Models\Peternakan;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Repositories\Kandang\PipeRepository;

class PipeController extends Controller
{
    /**
     * Inisialisasi model Pipe melalui Dependency Injection.
     * Memudahkan pemanggilan model di seluruh method.
     */
    public function __construct(
        private Peternakan $peternakan,
        private Pipe $pipe,
        private PipeRepository $repository,
    ) { 
        $this->middleware('can:master-data.master-data.menu-pipe');
    }

    /**
     * Menampilkan daftar seluruh Pipe dengan fitur pagination.
     * Biasanya digunakan untuk melihat semua Pipe dari seluruh Flock.
     */
    public function index()
    {
        $flockId = request()->input('flock_id');
        $kandangId = request()->input('kandang_id');
        $peternakanId = request()->input('peternakan_id');
        $perPage = request()->query('perPage', 10);
        
        $datas = $this->repository->paginate(
            request()->query('search'),
            request()->collect()->only(['peternakan_id', 'kandang_id', 'flock_id']),
            request()->collect('orders'),
        );

        $peternakan = $this->peternakan
            ->with([
                'kandang:id,peternakan_id,nama',
                'kandang.flocks:id,kandang_id,nama'
            ])->get();

        return view('kandang::master-data.pipe.index', compact(['datas', 'peternakan', 'flockId', 'kandangId', 'peternakanId']));
    }

    /**
     * Menampilkan form edit Pipe berdasarkan ID.
     */
    public function edit(Pipe $pipe)
    {
        $pipe->load([
            'flock.kandang.peternakan:id,nama',
            'flock.kandang:id,peternakan_id,nama',
            'flock:id,kandang_id,nama',
        ]);

        return view('kandang::master-data.pipe.edit', compact('pipe'));
    }

    /**
     * Mengupdate data Pipe.
     * Method ini digunakan ketika admin ingin mengubah nama pipe atau kapasitas maksimal.
     */
    public function update(Request $request, Pipe $pipe)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'numeric', 'min:1'],
        ]);

        try {
            $pipe->update($validated);
            return to_route('master-data.pipe.index')->with('success', 'Data Pipe berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan saat memperbarui data Pipe.');
        }
    }


    /**
     * Menghapus Pipe berdasarkan ID.
     * Biasanya digunakan jika admin ingin merapikan data atau ada Pipe yang tidak digunakan.
     */
    public function destroy(Pipe $pipe)
    {
        if($this->pipe->pengadaanAyamDistribusi()->exists()) {
            return to_route('master-data.pipe.index')
                ->with('error', 'Tidak dapat menghapus Pipa yang memiliki Pengadaan Ayam Distribusi.');
        }

        $pipe->delete();

        return to_route('master-data.pipe.index')->with('success', 'Data Pipe berhasil dihapus.');
    }
}
