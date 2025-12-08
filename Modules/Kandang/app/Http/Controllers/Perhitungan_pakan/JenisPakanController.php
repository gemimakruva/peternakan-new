<?php

namespace Modules\Kandang\Http\Controllers\Perhitungan_pakan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\JenisPakan;

class JenisPakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $jenisPakan = JenisPakan::orderBy('created_at', 'DESC')->paginate(10); 
          return view('kandang::master-data.jenis-pakan.index', 
          compact('jenisPakan'));
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
        JenisPakan::create($validated);
         return redirect()
        ->route('master-data.jenis-pakan.index')
        ->with('success', 'Jenis pakan berhasil ditambahkan!');
    }
   

    /**
     * Display the specified resource.
     */
    public function show(JenisPakan $jenisPakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPakan $Jenis_pakan)
    {
        $data = $Jenis_pakan;
         return view('kandang::master-data.jenis-pakan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisPakan $Jenis_pakan)
    {
         $validated = $request->validate([
            'nama' => [
                "required",
                "string",
                "max:100",
                Rule::unique("jenis_pakan","nama")->ignore($Jenis_pakan->id)
            ]
        ]);


         $Jenis_pakan->update([
        'nama' => $validated['nama'],
         ]);
        return redirect()
        ->route('master-data.jenis-pakan.index')
        ->with('success', 'Jenis pakan berhasil diperbarui!');
         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPakan $Jenis_pakan)
    {
        $Jenis_pakan->delete();
        return back()->with('success', 'Jenis pakan berhasil dihapus!');
    }
}
