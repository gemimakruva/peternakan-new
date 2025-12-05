<?php
namespace Modules\Kandang\Http\Controllers\treatment;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\JenisTreatment;
use App\Http\Requests\StoreJenisTreatmentRequest;
use App\Http\Requests\UpdateJenisTreatmentRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class JenisTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = JenisTreatment::query();
        if ($search) {
            $query->where('nama', 'LIKE', "%{$search}%");
        }
        $datas = $query->latest()->paginate(10)->withQueryString();
        return view('kandang::master-data.treatment.index', compact('datas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandang::master-data.treatment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255|unique:jenis_treatment,nama',
    ]);

    try {
        $treatment = JenisTreatment::create([
            'nama' => $validated['nama'],
        ]);
        return redirect()->route('master-data.jenis-treatment.index')
                         ->with('success', "Jenis Treatment '{$treatment->nama}'
                          berhasil ditambahkan.");
    } catch (\Exception $e) {
        return redirect()->back()
                         ->withInput()
                         ->with('error', "Gagal menambahkan Jenis Treatment. 
                         Error: " . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(JenisTreatment $jenisTreatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisTreatment $jenisTreatment)
    {
        $datas = $jenisTreatment;
        return view("kandang::master-data.treatment.edit",compact('datas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisTreatment $jenisTreatment)
    {
         $validated = $request->validate([
        'nama' => [
            'required',
            'string',
            'max:255',
            Rule::unique('jenis_treatment', 'nama')->ignore($jenisTreatment->id),
        ],
        ]);
          try {
        $jenisTreatment->update($validated);
        return redirect()
            ->route('master-data.jenis-treatment.index')
            ->with('success', 'Jenis Treatment berhasil diperbarui!');
    } catch (\Exception $e) {
        return back()
            ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisTreatment $jenisTreatment)
{
    try {
        $jenisTreatment->delete();
        return redirect()->route('master-data.jenis-treatment.index')
                         ->with('success', "Jenis Treatment  berhasil dihapus.");
    } catch (\Exception $e) {
        return redirect()->route('master-data.jenis-treatment.index')
                         ->with('error', "Gagal menghapus Jenis Treatment.
                          Error: " . $e->getMessage());
    }
}

}
