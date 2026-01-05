<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\JenisTreatment;

class JenisTreatmentController extends Controller
{
    public function __construct(
        private JenisTreatment $jenisTreatment,
    ) { }

    public function index()
    {
        $jenisTreatment = $this->jenisTreatment
            ->query()
            ->when(request()->query('search'), function($query, $search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->orderByDesc('created_at')
            ->paginate(request()->query('perPage', 10));

        return view('kandang::master-data.jenis-treatment.index', compact('jenisTreatment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandang::master-data.jenis-treatment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:jenis_treatment,nama',
        ]);

        $this->jenisTreatment->create($validated);

        return to_route('master-data.jenis-treatment.index')->with('success', 'Jenis treatment berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisTreatment $jenisTreatment)
    {
        $data = $jenisTreatment;
        return view('kandang::master-data.jenis-treatment.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisTreatment $jenisTreatment)
    {
        $validated = $request->validate([
            'nama' => [
                "required",
                "string",
                "max:100",
                Rule::unique("jenis_treatment","nama")->ignore($jenisTreatment->id)
            ]
        ]);

        $jenisTreatment->update($validated);

        return to_route('master-data.jenis-treatment.index')->with('success', 'Jenis treatment berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisTreatment $jenisTreatment)
    {
        $jenisTreatment->delete();
        return back()->with('success', 'Jenis treatment berhasil dihapus!');
    }
}
