<?php

namespace Modules\Kandang\Http\Controllers\PengadaanAyam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Pengadaan_ayam;
use Modules\Kandang\Models\Pipe;

class PengadaanAyamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ListPengadaanAyam = Pengadaan_ayam::with('pic_user')
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString();
        return view('kandang::pengadaan-ayam.index', compact('ListPengadaanAyam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listKandang = Kandang::with('flocks.pipes')->get(); 
        return view("kandang::pengadaan-ayam.create",
        compact("listKandang"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
                'tanggal' => ['required', 'date'],
                'jumlah_ayam_datang' => ['required', 'integer', 'min:1'],
                'umur_ayam' => ['required', 'integer', 'min:0'],
                'jumlah_ayam_mati' => ['required', 'integer', 'min:0'],
                'jumlah_ayam_sakit' => ['required', 'integer', 'min:0'],
                'kondisi_ayam' => ['required', 'string', 'max:255'],
                'catatan' => ['required', 'string', 'max:500'],
                'nama_berkas' => ['required', 'string', 'max:255'],
                'file_path_berkas' => ['required', 'array', 'min:1'],
                'file_path_berkas.*' => [
                    'required',
                    'file',
                    'mimes:pdf,jpg,jpeg,png',
                    'max:2048'
                ],

                //  'image_files_doc' => ['required', 'array', 'min:1'],
                // 'image_files_doc.*' => [
                //     'required',
                //     'image',
                //     'mimes:jpg,jpeg,png,webp',
                //     'max:5120'
                //  ],
        ]);
        dd($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengadaan_ayam $pengadaan_ayam)
    {
         $pengadaanAyam = $pengadaan_ayam
                         ->load(['berkasSupplier', 'pic_user']);
         return view("kandang::pengadaan-ayam.show", data: 
         compact('pengadaanAyam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengadaan_ayam $pengadaan_ayam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengadaan_ayam $pengadaan_ayam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengadaan_ayam $pengadaan_ayam)
    {
        //
    }
}
