<?php

namespace Modules\Kandang\Http\Controllers\Disinfectan;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Modules\Kandang\Models\JenisDisinfectan;
use Illuminate\Http\Request;

class JenisDisinfectanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
        {
        
            $search = $request->query('search');
            $query = JenisDisinfectan::query();
            if ($search) {
                $query->where('nama', 'LIKE', "%{$search}%");
            }
             $datas = $query->orderBy('nama', 'ASC')->paginate(10)->withQueryString();
            return view('kandang::master-data.disinfectan.index', compact('datas'));
        }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('kandang::master-data.disinfectan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // 🧾 Validasi request
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:jenis_disinfectan,nama',
        ]);


    try {
        JenisDisinfectan::create([
            'nama' => $validated['nama'],
        ]);
        return redirect()
            ->route('master-data.jenis-disinfectan.index')
            ->with('success', 'Jenis Disinfectan berhasil ditambahkan!');
            
    } catch (\Throwable $e) {
        return back()
            ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
            ->withInput();
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisDisinfectan $jenisDisinfectan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisDisinfectan $jenisDisinfectan)
    {
        $data = $jenisDisinfectan;
        return view('kandang::master-data.disinfectan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisDisinfectan $jenisDisinfectan)
    {
        // validasi input
        $validated = $request->validate([
        'nama' => [
        'required',
        'string',
        'max:255',
        Rule::unique('jenis_disinfectan', 'nama')->ignore($jenisDisinfectan->id),
    ],
]);

        try {
            $jenisDisinfectan->update([
                'nama' => $validated['nama'],
            ]);
            return redirect()
                ->route('master-data.jenis-disinfectan.index')
                ->with('success', 'Jenis disenfectan berhasil diperbarui.');

        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data. Error: ' . $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisDisinfectan $jenisDisinfectan)
        {
            try {
                $jenisDisinfectan->delete();

                return redirect()
                    ->route('master-data.jenis-disinfectan.index')
                    ->with('success', 'Jenis disinfectan berhasil dihapus.');
            } catch (\Throwable $th) {

                return redirect()
                    ->route('master-data.jenis-disinfectan.index')
                    ->with('error', 'Terjadi kesalahan saat menghapus 
                    disinfectan: ' . $th->getMessage());
            }
        }

}
