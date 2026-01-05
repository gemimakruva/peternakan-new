<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\MetodeTreatment;

class MetodeTreatmentController extends Controller
{
    public function __construct(
        private MetodeTreatment $metodeTreatment,
    ) { }

    public function index()
    {
        $metodeTreatment = $this->metodeTreatment
            ->query()
            ->when(request()->query('search'), function($query, $search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->orderByDesc('created_at')
            ->paginate(request()->query('perPage', 10));

        return view('kandang::master-data.metode-treatment.index', compact('metodeTreatment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandang::master-data.metode-treatment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:metode_treatment,nama',
        ]);

        $this->metodeTreatment->create($validated);

        return to_route('master-data.metode-treatment.index')->with('success', 'Metode treatment berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MetodeTreatment $metodeTreatment)
    {
        $data = $metodeTreatment;
        return view('kandang::master-data.metode-treatment.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MetodeTreatment $metodeTreatment)
    {
        $validated = $request->validate([
            'nama' => [
                "required",
                "string",
                "max:100",
                Rule::unique("metode_treatment","nama")->ignore($metodeTreatment->id)
            ]
        ]);

        $metodeTreatment->update($validated);

        return to_route('master-data.metode-treatment.index')->with('success', 'Metode treatment berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MetodeTreatment $metodeTreatment)
    {
        $metodeTreatment->delete();
        return back()->with('success', 'Metode treatment berhasil dihapus!');
    }
}
