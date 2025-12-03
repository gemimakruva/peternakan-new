<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Peternakan;
use Modules\Kandang\Models\Strain;

class KandangController extends Controller
{
    /**
     * Dependency Injection model Kandang
     */
    public function __construct(
        private Kandang $kandang,
    ) { }

    /**
     * Menampilkan seluruh data kandang dengan fitur search, sort, dan pagination.
     */
    public function index()
    {
        Gate::authorize('Lihat Semua Kandang');
        $search = request()->input('search');
        $kandang = $this->kandang
                ->with(['strain','peternakan'])
                ->when($search, function ($query, $search) {
                    $query->where('nama', 'like', "%{$search}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(request()->get('perPage', 10))
                ->withQueryString(); 
        return view('kandang::master-data.kandang.index', compact('kandang'));
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

        $validated = $request->validate([
            'nama'   => ['required', 'string', 'max:255'],
            'peternakan_id' => ['required', 'integer'],
            'strain_id' => ['required', 'integer'],
        ]);

        try{
            $this->kandang->create($validated);
            return to_route('master-data.kandang.index')
                ->with('success', 'Data Berhasil Ditambahkan.');   
                
        }catch(\Exception $e){
            return to_route('master-data.kandang.index')
            ->with('danger', 'Data Gagal Ditambahkan. Error: '.$e->getMessage());
        }
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
        return view('kandang::master-data.kandang.edit',
         compact('data','peternakanList','strainList'));
    }

    /**
     * Mengupdate data kandang di database.
     */
    public function update(Request $request, Kandang $kandang)
    {
        Gate::authorize('Edit Kandang');

        $validated = $request->validate([
            'nama'   => ['required', 'string', 'max:255', 
            Rule::unique('kandang', 'nama')->ignore($kandang)],
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
                'Kandang ini tidak bisa dihapus karena masih memiliki Baris terkait.');
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
