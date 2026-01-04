<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Peternakan;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\Strain;

class KandangController extends Controller
{
    /**
     * Dependency Injection model Kandang
     */
    public function __construct(
        private Strain $strain,
        private Peternakan $peternakan,
        private Kandang $kandang,
        private Flock $flock,
        private Pipe $pipe,
    ) { }

    /**
     * Menampilkan seluruh data kandang dengan fitur search, sort, dan pagination.
     */
    public function index()
    {
        Gate::authorize('Lihat Semua Kandang');

        $strain = $this->strain->get(['id', 'nama']);
        $peternakan = $this->peternakan->get(['id', 'nama']);

        $kandang = $this->kandang
            ->with(['strain','peternakan'])
            ->when(request()->query('search'), function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->when(request()->query('strain_id'), function ($query,  $strainId) {
                $query->where('strain_id', '=', $strainId);
            })
            ->when(request()->query('peternakan_id'), function ($query, $peternakanId) {
                $query->where('peternakan_id', '=', $peternakanId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(request()->get('perPage', 10))
            ->withQueryString(); 

        return view('kandang::master-data.kandang.index', compact([
            'strain',
            'peternakan',
            'kandang',
        ]));
    }

    /**
     * Menampilkan form untuk menambah data kandang.
     */
    public function create()
    {
        Gate::authorize('Tambah Kandang');
        $peternakanList = Peternakan::all();
        $strainList = Strain::all(); 
        return view('kandang::master-data.kandang.create',
        compact('peternakanList','strainList'));
    }

    /**
     * Menyimpan data kandang baru ke database.
     */
    public function store(Request $request)
    {
        Gate::authorize('Tambah Kandang');

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'peternakan_id' => ['required', 'integer'],
            'strain_id' => ['required', 'integer'],
            'nama_baris' => ['nullable', 'string', 'max:255'],
            'banyak_baris' => ['nullable', 'integer', 'min:1'],
            'nama_pipa' => ['nullable', 'string', 'max:255'],
            'banyak_pipa_per_baris' => ['nullable', 'string', 'min:1'],
            'kapasitas_pipa' => ['nullable', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try{
            $kandang = $this->kandang->create($request->only([
                'nama',
                'peternakan_id',
                'strain_id',
            ]));

            $namaBaris = $request->input('nama_baris');
            $banyakBaris = $request->integer('banyak_baris', 0);

            $namaPipa = $request->input('nama_pipa');
            $banyakPipaPerBaris = $request->integer('banyak_pipa_per_baris', 0);
            $kapasitasPipa = $request->integer('kapasitas_pipa', 0);

            if ($namaBaris && $banyakBaris > 0) {
                $noPipa = 1;
                for ($i=1; $i <= $banyakBaris; $i++) { 
                    $padNoBaris = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $flock = $this->flock->create([
                        'nama' => "{$namaBaris} {$padNoBaris}",
                        'kandang_id' => $kandang->id,
                    ]);

                    if ($namaPipa && $banyakPipaPerBaris > 0 && $kapasitasPipa > 0) {
                        for ($j=1; $j <= $banyakPipaPerBaris; $j++) { 
                            $padNoPipa = str_pad($noPipa, 2, '0', STR_PAD_LEFT);
                            $this->pipe->create([
                                'nama' => "{$namaPipa} {$padNoPipa}",
                                'flock_id' => $flock->id,
                                'kapasitas' => $kapasitasPipa,
                            ]);
                            $noPipa++;
                        }
                    }
                }
            }

            DB::commit();
            return to_route('master-data.kandang.index')->with('success', 'Data Berhasil Ditambahkan.');
        }catch(\Exception $e){

            DB::rollBack();
            return back()->withInput()->with('danger', 'Data Gagal Ditambahkan. Error: '.$e->getMessage());
        }
    }

    public function show(Kandang $kandang)
    {
        $kandang->load([
            'peternakan:id,nama',
            'strain:id,nama',
        ]);

        $flocks = $this->flock
            ->query()
            ->where('kandang_id', '=', $kandang->id)
            ->when(request()->query('search'), function ($query, $search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->orderByDesc('nama')
            ->paginate(request()->query('perPage', 10))
            ->withQueryString();

        return view('kandang::master-data.kandang.show', compact(['kandang', 'flocks']));
    }

    /**
     * Menampilkan form edit data kandang.
     */
    public function edit(Kandang $kandang)
    {
        Gate::authorize('Edit Kandang');

        $peternakanList = Peternakan::all();
        $data = $kandang;
        $strainList = Strain::all();

        return view('kandang::master-data.kandang.edit', compact('data','peternakanList','strainList'));
    }

    /**
     * Mengupdate data kandang di database.
     */
    public function update(Request $request, Kandang $kandang)
    {
        Gate::authorize('Edit Kandang');

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255', 
                Rule::unique('kandang', 'nama')->ignore($kandang)
            ],
            'peternakan_id' => ['required', 'integer'],
            'strain_id' => ['required', 'integer'],
        ]);

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
        if ($kandang->flocks()->exists()) {
            return redirect()->back()->with('error', 
                'Kandang ini tidak bisa dihapus karena memiliki Baris terkait.');
        }
        try {
            $kandang->delete();
            return redirect()->route('master-data.kandang.index')
                ->with('success', 'Data Kandang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 
                'Terjadi kesalahan saat menghapus data kandang.');
        }
    }

}
