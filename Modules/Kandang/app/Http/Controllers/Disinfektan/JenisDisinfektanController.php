<?php

namespace Modules\Kandang\Http\Controllers\Disinfektan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\JenisDisinfektan;

class JenisDisinfektanController extends Controller
{
    public function __construct(
        private JenisDisinfektan $jenisDisinfektan,
    ) { }

    public function index()
    {
        $jenisDisinfektan = $this->jenisDisinfektan
            ->query()
            ->when(request()->query('search'), function($query, $search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->orderByDesc('created_at')
            ->paginate(request()->query('perPage', 10));

        return view('kandang::master-data.disinfektan.index', compact('jenisDisinfektan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandang::master-data.disinfektan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_disinfektan,nama',
        ]);

        $this->jenisDisinfektan->create($validated);

        return to_route('master-data.jenis-disinfektan.index')->with('success', 'Jenis disinfektan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisDisinfektan $jenisDisinfektan)
    {
        $data = $jenisDisinfektan;

        return view('kandang::master-data.disinfektan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisDisinfektan $jenisDisinfektan)
    {
        $validated = $request->validate([
            'nama' => [
                "required",
                "string",
                "max:100",
                Rule::unique("jenis_disinfektan","nama")->ignore($jenisDisinfektan->id)
            ]
        ]);

        $jenisDisinfektan->update($validated);

        return to_route('master-data.jenis-disinfektan.index')->with('success', 'Jenis disinfektan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisDisinfektan $jenisDisinfektan)
    {
        $jenisDisinfektan->delete();
        return back()->with('success', 'Jenis disinfektan berhasil dihapus!');
    }
}
