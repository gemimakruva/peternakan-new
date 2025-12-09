<?php

namespace Modules\Kandang\Http\Controllers\Disinfektan;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Modules\Kandang\Models\JenisDisinfektan;
use Illuminate\Http\Request;

class JenisDisinfektanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
        {
        
            $search = $request->query('search');
            $query = JenisDisinfektan::query();
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
            'nama' => 'required|string|max:255|unique:jenis_disinfektan,nama',
        ]);


    try {
        JenisDisinfektan::create([
            'nama' => $validated['nama'],
        ]);
        return redirect()
            ->route('master-data.jenis-disinfectan.index')
            ->with('success', 'Jenis Disinfektan berhasil ditambahkan!');
            
    } catch (\Throwable $e) {
        return back()
            ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
            ->withInput();
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisDisinfektan $jenisDisinfectan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisDisinfektan $jenisDisinfectan)
    {
        $data = $jenisDisinfectan;
        return view('kandang::master-data.disinfectan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisDisinfektan $jenisDisinfectan)
    {
        // validasi input
        $validated = $request->validate([
        'nama' => [
        'required',
        'string',
        'max:255',
        Rule::unique('jenis_disinfektan', 'nama')->ignore($jenisDisinfectan->id),
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
    public function destroy(JenisDisinfektan $jenisDisinfectan)
        {
            try {
                $jenisDisinfectan->delete();

                return redirect()
                    ->route('master-data.jenis-disinfectan.index')
                    ->with('success', 'Jenis Disinfektan
 berhasil dihapus.');
            } catch (\Throwable $th) {

                return redirect()
                    ->route('master-data.jenis-disinfectan.index')
                    ->with('error', 'Terjadi kesalahan saat menghapus 
                    disinfectan: ' . $th->getMessage());
            }
        }

}
