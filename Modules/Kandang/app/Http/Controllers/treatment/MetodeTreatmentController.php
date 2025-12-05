<?php

namespace Modules\Kandang\Http\Controllers\treatment;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\MetodeTreatment;
use App\Http\Requests\StoreMetodeTreatmentRequest;
use App\Http\Requests\UpdateMetodeTreatmentRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class MetodeTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $search = $request->query('search');
        $query = MetodeTreatment::query();
        if ($search) {
            $query->where('nama', 'LIKE', "%{$search}%");
        }
        $datas = $query->latest()->paginate(10)->withQueryString();
        return view('kandang::master-data.metode-treatment.index', compact('datas'));
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
        // Validasi input agar nama tidak boleh sama
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('metode_treatment', 'nama'),
            ],
        ]);

        try {
            // Simpan ke database
            MetodeTreatment::create([
                'nama' => $validated['nama'],
            ]);

            return redirect()
                ->route('master-data.metode-treatment.index')
                ->with('success', 'Metode Treatment berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Error: ' . $th->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $metodeTreatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MetodeTreatment $metodeTreatment)
    {
        $data = $metodeTreatment;
        return view("kandang::master-data.metode-treatment.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MetodeTreatment $metodeTreatment)
    {
        // validasi input
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('metode_treatment', 'nama')->ignore($metodeTreatment->id),
            ],
        ]);

        try {

            // Jika nama masih sama, tidak perlu update tetap success
            if ($request->nama === $metodeTreatment->nama) {
                return redirect()
                    ->route('master-data.metode-treatment.index')
                    ->with('success', 'Metode treatment tidak ada perubahan namun data tetap tersimpan.');
            }

            // update data
            $metodeTreatment->update([
                'nama' => $validated['nama'],
            ]);

            return redirect()
                ->route('master-data.metode-treatment.index')
                ->with('success', 'Metode treatment berhasil diperbarui.');

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
    public function destroy(MetodeTreatment $metodeTreatment)
    {
        try {
            $metodeTreatment->delete();
            return redirect()
                ->route('master-data.metode-treatment.index')
                ->with('success', "Metode treatment  berhasil dihapus.");
        } catch (\Throwable $th) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data. Error: '
                 . $th->getMessage());
        }
    }

}
