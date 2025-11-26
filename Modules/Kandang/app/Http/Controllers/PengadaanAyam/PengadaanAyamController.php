<?php

namespace Modules\Kandang\Http\Controllers\PengadaanAyam;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Kandang\Models\BerkasPengadaanAyam;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Pengadaan_ayam;
use Modules\Kandang\Models\PengadaanAyamDistribusi;
use Modules\Kandang\Models\PengadaanAyamDokumentasi;
use Modules\Kandang\Models\PopulasiAyam;

class PengadaanAyamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ListPengadaanAyam = Pengadaan_ayam::with('pic_user')
                            ->orderBy('tanggal', 'desc')
                            ->orderBy('id', 'desc')
                            ->paginate(10)
                            ->withQueryString();

        return view('kandang::pengadaan-ayam.index', 
        compact('ListPengadaanAyam'));
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
            'jumlah_ayam_sakit' => ['required', 'integer', 'min:0'],
            'jumlah_ayam_mati' => ['required', 'integer', 'min:0'],
            'kondisi_ayam' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
            'nama_berkas' => ['required', 'string', 'max:255'],
            'distribusi_json' => ['required', 'string'],
            'file_path_berkas' => ['required', 'array', 'min:1'],
            'file_path_berkas.*' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048'
            ],
            'image_files_doc' => ['required', 'array', 'min:1'],
            'image_files_doc.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
        ]);

        $distribusi = json_decode($validated['distribusi_json'], true);;

        if (!is_array($distribusi)) {
            return back()->withErrors(['distribusi_json' => 
            'Format distribusi tidak valid']);
        }

       $picUserId = Auth::id();
       $totalAyamMasuk = 0;

        // PENYIMPANAN DATA PENGADAAN
        $pengadaanAyam = Pengadaan_ayam::create([
        'pic_user_id' => $picUserId,
        'tanggal' => $validated['tanggal'],
        'jumlah_ayam_datang' => $validated['jumlah_ayam_datang'],
        'umur_ayam' => $validated['umur_ayam'],
        'jumlah_ayam_masuk_kandang' => $totalAyamMasuk,
        'jumlah_ayam_sakit' => $validated['jumlah_ayam_sakit'],
        'jumlah_ayam_mati' => $validated['jumlah_ayam_mati'],
        'kondisi_ayam' => $validated['kondisi_ayam'],
        'catatan' => $validated['catatan'] ?? null,
        ]);

        // PENYIMPANAN DATA DISTRIBUSI
        foreach ($distribusi as $item) 
        {
               $jumlah = (int) $item['jumlah'];
               $totalAyamMasuk += $jumlah;
               $distribusiRecord = PengadaanAyamDistribusi::create([
                                'pengadaan_ayam_id' => $pengadaanAyam->id,
                                'kandang_id' => $item['kandang_id'],
                                'flock_id' => $item['flock_id'],
                                 'pipe_id' => $item['pipe_id'],
                                'jumlah_ayam' => $jumlah,
                ]);

                // ALOKASI DATA KE POPULASI JIKA BERHASIL
               PopulasiAyam::create([
                    'pengadaan_ayam_distribusi_id' => $distribusiRecord->id, 
                    'pic_user_id' => $picUserId,
                    'jenis_pemeriksaan' => 'pengadaan ayam',
                    'tanggal' => $validated['tanggal'],
                    'kandang_id' => $item['kandang_id'],
                    'flock_id' => $item['flock_id'],
                    'pipe_id' => $item['pipe_id'],
                    'ayam_sehat' => $jumlah,
                ]);
        }

        $pengadaanAyam->update([
            'jumlah_ayam_masuk_kandang' => $totalAyamMasuk
        ]);

       


        // PENYIMPANAN DATA FILE SUPPLIER DOKUMEN
            if ($request->hasFile('file_path_berkas')) {
                foreach ($request->file('file_path_berkas') as $file) {
                $path = $file->store('pengadaan/files_supplier', 'public');
                    BerkasPengadaanAyam::create([
                        'pengadaan_ayam_id' => $pengadaanAyam->id,
                        'nama_berkas'       => $validated['nama_berkas'], 
                        'file_path'         => $path,
                    ]);
                }
            }
                    
         // PENYIMPANAN DOKUMENTASI FOTO PENGADAAN 
            $imagePaths = [];
            foreach ($validated['image_files_doc'] as $image) {
                $storedPath = $image->store('pengadaan/dokumentasi', 'public');

                PengadaanAyamDokumentasi::create([
                    'pengadaan_ayam_id' => $pengadaanAyam->id,
                    'file_path' => $storedPath, // BUKAN JSON!!
                ]);
            }


            return redirect()->route('pengadaan-ayam.index')->with('success', 
                'Data distribusi ayam berhasil disimpan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Pengadaan_ayam $pengadaan_ayam)
    {
            $pengadaanAyam = $pengadaan_ayam->load([
                'pic_user',
                'berkasSupplier',
                'distribusi.kandang',
                'distribusi.flock',
                'distribusi.pipe',
                'dokumentasi'
            ]);
         return view("kandang::pengadaan-ayam.show", compact('pengadaanAyam'));
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

        try {
            if ($pengadaan_ayam->distribusi()->exists()) {
                $pengadaan_ayam->distribusi()->delete();
            }

            // Hapus dokumentasi jika ada (opsional)
            if ($pengadaan_ayam->dokumentasi()->exists()) {
                foreach ($pengadaan_ayam->dokumentasi as $doc) {
                    if ($doc->file_path && Storage::disk('public')->exists($doc->file_path)) {
                        Storage::disk('public')->delete($doc->file_path);
                    }
                }
                $pengadaan_ayam->dokumentasi()->delete();
            }
            // Hapus file supplier jika ada (opsional)
            if ($pengadaan_ayam->berkasSupplier()->exists()) {
                foreach ($pengadaan_ayam->berkasSupplier as $file) {
                    if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
                        Storage::disk('public')->delete($file->file_path);
                    }
                }
                $pengadaan_ayam->berkasSupplier()->delete();
            }
            // Terakhir: hapus data utama
            $pengadaan_ayam->delete();

            return redirect()->back()->with('success', 'Data pengadaan ayam berhasil dihapus!');
        
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

}
