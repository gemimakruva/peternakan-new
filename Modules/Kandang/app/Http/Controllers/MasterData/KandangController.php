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
use Modules\Kandang\Repositories\Kandang\KandangRepository;

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
        private KandangRepository $repository,
    ) { }

    /**
     * Menampilkan seluruh data kandang dengan fitur search, sort, dan pagination.
     */
    public function index()
    {
        $strain = $this->strain->get(['id', 'nama']);
        $peternakan = $this->peternakan->get(['id', 'nama']);

        $kandang = $this->repository->paginate(
            request()->get('search'),
            request()->collect()->only(['strain_id', 'peternakan_id']),
            request()->collect('orders'),
            request()->get('perPage', 10)
        );

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
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'peternakan_id' => ['required', 'integer'],
            'strain_id' => ['required', 'integer'],
            'nama_flock' => ['nullable', 'string', 'max:255'],
            'banyak_flock' => ['nullable', 'integer', 'min:1'],
            'nama_pipa' => ['nullable', 'string', 'max:255'],
            'banyak_pipa_per_flock' => ['nullable', 'string', 'min:1'],
            'kapasitas_pipa' => ['nullable', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try{
            $kandang = $this->kandang->create($request->only([
                'nama',
                'peternakan_id',
                'strain_id',
            ]));

            $namaFlock = $request->input('nama_flock');
            $banyakFlock = $request->integer('banyak_flock', 0);

            $namaPipa = $request->input('nama_pipa');
            $banyakPipaPerFlock = $request->integer('banyak_pipa_per_flock', 0);
            $kapasitasPipa = $request->integer('kapasitas_pipa', 0);

            if ($namaFlock && $banyakFlock > 0) {
                $noPipa = 1;
                for ($i=1; $i <= $banyakFlock; $i++) { 
                    $padNoFlock = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $flock = $this->flock->create([
                        'nama' => "{$namaFlock} {$padNoFlock}",
                        'kandang_id' => $kandang->id,
                    ]);

                    if ($namaPipa && $banyakPipaPerFlock > 0 && $kapasitasPipa > 0) {
                        for ($j=1; $j <= $banyakPipaPerFlock; $j++) { 
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
        $kandang = $this->kandang->findOrFail($id);
        if ($kandang->flocks()->exists()) {
            return redirect()->back()->with('error', 
                'Kandang ini tidak bisa dihapus karena memiliki Flock terkait.');
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
