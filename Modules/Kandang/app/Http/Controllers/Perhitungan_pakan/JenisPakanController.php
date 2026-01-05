<?php

namespace Modules\Kandang\Http\Controllers\Perhitungan_pakan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\JenisPakan;

class JenisPakanController extends Controller
{
    public function __construct(
        private JenisPakan $jenisPakan,
    ) { }

    public function index()
    {
        $jenisPakan = $this->jenisPakan
            ->query()
            ->when(request()->query('search'), function($query, $search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->orderByDesc('created_at')
            ->paginate(request()->query('perPage', 10));

        return view('kandang::master-data.jenis-pakan.index', compact('jenisPakan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandang::master-data.jenis-pakan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_pakan,nama',
        ]);

        $this->jenisPakan->create($validated);
        
        return to_route('master-data.jenis-pakan.index')->with('success', 'Jenis pakan berhasil ditambahkan!');
    }
   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPakan $jenisPakan)
    {
        $data = $jenisPakan;
        return view('kandang::master-data.jenis-pakan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisPakan $jenisPakan)
    {
        $validated = $request->validate([
            'nama' => [
                "required",
                "string",
                "max:100",
                Rule::unique("jenis_pakan","nama")->ignore($jenisPakan->id)
            ]
        ]);

        $jenisPakan->update($validated);

        return to_route('master-data.jenis-pakan.index')->with('success', 'Jenis pakan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPakan $jenisPakan)
    {
        $jenisPakan->delete();
        return back()->with('success', 'Jenis pakan berhasil dihapus!');
    }
}
