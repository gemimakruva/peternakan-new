<?php

namespace Modules\Kandang\Http\Controllers\AyamKarantina;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\AyamKarantina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Kandang\Models\PopulasiAyam;

class AyamKarantinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $listAyamKarantina = AyamKarantina::latest()->paginate(10);
         return view('kandang::ayam-karantina.index',
          compact('listAyamKarantina'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listPopulasiAyam = PopulasiAyam::with(['kandang', 'flock', 'pipe'])->get();
        return view("kandang::ayam-karantina.create",
        compact('listPopulasiAyam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'populasi_ayam_id' => ['required', 'exists:populasi_ayam,id'],
            'tanggal_karantina' => ['required', 'date'],
            'ayam_masuk_karantina' => ['required', 'integer', 'min:0'],
            'ayam_mati' => ['required', 'integer', 'min:0'],
            'ayam_afkir' => ['required', 'integer', 'min:0'],
            'ayam_keluar_karantina' => ['required', 'integer', 'min:0'],
            'pemberian_pakan' => ['required', 'numeric', 'min:0'],
            'sisa_pakan' => ['required', 'numeric', 'min:0'],
            'jumlah_telur_bagus' => ['required', 'integer', 'min:0'],
            'jumlah_telur_retak' => ['required', 'integer', 'min:0'],
            'jumlah_telur_rusak' => ['required', 'integer', 'min:0'],
            'penyebab_karantina' => ['nullable', 'string', 'max:255'],
            'pengobatan_yang_dilakukan' => ['nullable', 'string', 'max:255'],
            'jumlah_ayam_diobati' => ['required', 'integer', 'min:0'],
            'penyemprotan' => ['nullable', 'string', 'max:255'],
            'vaksin' => ['nullable', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
         ]);
           $karantina = AyamKarantina::create($validated);
           $populasi = PopulasiAyam::find($validated['populasi_ayam_id']);
           $populasi->ayam_masuk_karantina += $validated['ayam_masuk_karantina'];
           $populasi->ayam_sehat -= $validated['ayam_masuk_karantina'];
           $populasi->ayam_keluar_karantina += $validated['ayam_keluar_karantina'];
           $populasi->ayam_sehat += $validated['ayam_keluar_karantina'];
           $populasi->save();
             return redirect()
             ->route('ayam-karantina.index')
            ->with('success', 'Data ayam karantina berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AyamKarantina $ayamKarantina)
    {
         $listAyamKarantina = AyamKarantina::latest()->paginate(10);
         return view('kandang::ayam-karantina.index',
          compact('listAyamKarantina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AyamKarantina $ayamKarantina)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AyamKarantina $ayamKarantina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AyamKarantina $ayamKarantina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function overview()
    {
        $listAyamKarantina = AyamKarantina::orderBy('created_at', 'desc')->limit(5)->get();
        return view('kandang::ayam-karantina.overview', compact('listAyamKarantina'));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function masukKarantina()
    {
        return view('kandang::ayam-karantina.ayam-masuk.create');
    }

    public function storeAyamMasukKarantina(Request $request)
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'kandang_id'  => 'required|exists:kandang,id',
            'flock_id'    => 'required|exists:flock,id',
            'pipe_id'     => 'required|exists:pipe,id',
            'jumlah'      => 'required|integer|min:0',
            'keterangan'  => 'nullable|string|max:500',
        ]);
        dd($validated);
    }

    public function keluarKarantina(Request $request)
    {
        dd("on progress");
         return view('kandang::ayam-karantina.ayam-keluar.create');
    }

}
