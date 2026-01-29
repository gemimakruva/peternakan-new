<?php

namespace Modules\Kandang\Http\Controllers\PengadaanAyam;

use App\Models\User;
use Modules\Kandang\Enums\BerkasName;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Modules\Kandang\Enums\JenisPemeriksaan;
use Modules\Kandang\Models\BerkasPengadaanAyam;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PengadaanAyam;
use Modules\Kandang\Models\PengadaanAyamDistribusi;
use Modules\Kandang\Models\PengadaanAyamDokumentasi;
use Modules\Kandang\Models\PopulasiAyam;

class PengadaanAyamController extends Controller
{
    public function __construct(
        private User $user,
        private Kandang $kandang,
        private PopulasiAyam $populasiAyam,
        private PengadaanAyam $pengadaanAyam,
        private PengadaanAyamDistribusi $pengadaanAyamDistribusi,
        private BerkasPengadaanAyam $berkasPengadaanAyam,
        private PengadaanAyamDokumentasi $pengadaanAyamDokumentasi,
    ) { }

    public function index()
    {
        $listPengadaanAyam = $this->pengadaanAyam->query()
            ->with(['picUser', 'kandang'])
            ->when(request()->query('search'), function ($query, $search) {
                $query->whereRelation('picUser', 'name', 'like', "%$search%");
            })
            ->when(request()->query('tanggal'), function ($query, $tanggal) {
                $query->whereDate('tanggal', '=', $tanggal);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(request()->query('perPage'))
            ->onEachSide(3)
            ->withQueryString();

        return view('kandang::pengadaan-ayam.index', compact('listPengadaanAyam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listKandang = $this->kandang->with('flocks.pipes')->get(); 
        $listNamaBerkas = BerkasName::cases();
        return view("kandang::pengadaan-ayam.create", compact("listKandang", "listNamaBerkas"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => ['required', 'date'],
            'kandang_id' => ['required', 'exists:kandang,id'],
            'jumlah_ayam_datang' => ['required', 'integer', 'min:1'],
            'umur_ayam' => ['required', 'integer', 'min:0'],
            'jumlah_ayam_sakit' => ['required', 'integer', 'min:0'],
            'jumlah_ayam_mati' => ['required', 'integer', 'min:0'],
            'kondisi_ayam' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ]);

        $request->merge([
            'pic_user_id' => auth()->id(),
            'jumlah_ayam_masuk_kandang' => 0,
        ]);

        $pengadaanAyam = $this->pengadaanAyam->create($request->only([
            'kandang_id',
            'tanggal',
            'jumlah_ayam_datang',
            'umur_ayam',
            'jumlah_ayam_sakit',
            'jumlah_ayam_mati',
            'kondisi_ayam',
            'catatan',

            'pic_user_id',
            'jumlah_ayam_masuk_kandang',
        ]));

        return to_route('pengadaan-ayam.edit', $pengadaanAyam)
            ->with('success', 'Pengadaan Ayam berhasil disimpan, input data Distribusi, Berkas dan Dokumentasi.');
    }


    /**
     * Display the specified resource.
     */
    public function show(PengadaanAyam $pengadaanAyam)
    {
        $pengadaanAyam = $pengadaanAyam->load([
            'picUser',
            'berkasSupplier',
            'distribusi.pipe.flock.kandang',
            'dokumentasi'
        ]);

        return view("kandang::pengadaan-ayam.show", compact('pengadaanAyam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengadaanAyam $pengadaanAyam)
    {
        $pengadaanAyam->load([
            'kandang:id,nama',
            'kandang.flocks:kandang_id,id,nama',
            'kandang.flocks.pipes' => function ($q) {
                $q->selectRaw(<<<SQL
                    id, flock_id, nama, kapasitas,
                    NOT EXISTS (
                        -- apakah terdapat populasi_ayam selain pada saat pengadaan, 
                        -- apakah pipa siap digunakan untuk pengadaan
                        -- atau paling aman pipe ditambah flagging is_used, yang jadi true saat pipe ada ayamnya
                        SELECT pipe.id 
                        FROM pipe AS p
                        INNER JOIN pengadaan_ayam_distribusi AS pad ON p.id = pad.pipe_id
                        INNER JOIN pengadaan_ayam AS pa ON pa.id = pad.pengadaan_ayam_id
                        INNER JOIN populasi_ayam AS pa2 ON pa2.pipe_id = p.id
                        WHERE pa2.tanggal != pa.tanggal AND p.id = pipe.id
                        LIMIT 1
                    ) AS is_editable
                SQL);
            },
            'berkasSupplier',
            'dokumentasi',
            'distribusi.pipe' => function ($q) {
                $q->selectRaw(<<<SQL
                    id, flock_id, nama,
                    NOT EXISTS (
                        SELECT pipe.id 
                        FROM pipe AS p
                        INNER JOIN pengadaan_ayam_distribusi AS pad ON p.id = pad.pipe_id
                        INNER JOIN pengadaan_ayam AS pa ON pa.id = pad.pengadaan_ayam_id
                        INNER JOIN populasi_ayam AS pa2 ON pa2.pipe_id = p.id
                        WHERE pa2.tanggal != pa.tanggal AND p.id = pipe.id
                        LIMIT 1
                    ) AS is_editable
                SQL);
            },
            'distribusi.pipe.flock',
        ]);

        $listNamaBerkas = BerkasName::cases();

        return view("kandang::pengadaan-ayam.edit", compact("pengadaanAyam", "listNamaBerkas"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengadaanAyam $pengadaanAyam)
    {
        $validated = $request->validate([
            'kondisi_ayam' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],

            'distribusi_json' => ['required', 'string'],

            'berkas_supplier' => ['nullable', 'array'],
            'berkas_supplier.*.id' => ['nullable', 'exists:pengadaan_ayam_berkas_supplier,id'],
            'berkas_supplier.*.nama_berkas' => ['required', 'string', 'max:255'],
            'berkas_supplier.*.nama_berkas_lainnya' => ['nullable', 'string', 'max:255'],
            'berkas_supplier.*.file' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048'
            ],

            'dokumentasi_persisted' => ['nullable', 'array'],
            'dokumentasi_persisted.*.id' => ['required', 'exists:pengadaan_ayam_dokumentasi'],
            'dokumentasi_new' => ['nullable', 'array'],
            'dokumentasi_new.*.file' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048'
            ],
        ]);

        $distribusi = json_decode($validated['distribusi_json'], true);

        if (!is_array($distribusi)) {
            return back()->withErrors(['distribusi_json' => 'Format distribusi tidak valid']);
        }

        $picUserId = auth()->id();
        $totalAyamMasuk = 0;

        // update data pengadaan
        $pengadaanAyam->update([
            'kondisi_ayam' => $validated['kondisi_ayam'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        // update distribusi ayam
        $savedPengadaanAyamDistribusiIds = [];
        foreach ($distribusi as $item) {
            if (!@$item['is_editable']) continue;

            $jumlah = (int) $item['jumlah_ayam'];
            $totalAyamMasuk += $jumlah;
            $pengadaanAyamDistribusi = $this->pengadaanAyamDistribusi->updateOrCreate([
                'id' => $item['id'],
                'pengadaan_ayam_id' => $pengadaanAyam->id,
            ], [
                'pipe_id' => $item['pipe_id'],
                'jumlah_ayam' => $jumlah,
            ]);

            $savedPengadaanAyamDistribusiIds[] = $pengadaanAyamDistribusi->id;

            // update data populasi
            $this->populasiAyam->updateOrCreate([
                'pengadaan_ayam_distribusi_id' => $pengadaanAyamDistribusi->id,
            ], [
                'pic_user_id' => $picUserId,
                'jenis_pemeriksaan' => JenisPemeriksaan::PENGADAAN->value,
                'tanggal' => $pengadaanAyam['tanggal'],
                'kandang_id' => $pengadaanAyam['kandang_id'],
                'umur_ayam_record' => $pengadaanAyam['umur_ayam'],
                'flock_id' => $item['flock_id'],
                'pipe_id' => $item['pipe_id'],
                'ayam_sehat' => $jumlah,
            ]);
        }
        $pengadaanAyam
            ->distribusi()
            ->whereNotIn('id', $savedPengadaanAyamDistribusiIds)
            ->get()
            ->map(function($item) {
                // delete populasi yang tidak valid
                $item->populasiAyam()->delete();
                // delete distribusi yang tidak valid
                $item->delete();
            });

        $pengadaanAyam->update([
            'jumlah_ayam_masuk_kandang' => $totalAyamMasuk
        ]);

        // simpan berkas supplier
        $savedBerkasPengadaanAyamIds = [];
        foreach ($validated['berkas_supplier'] ?? [] as $index => $berkasSupplier) {

            $file = $request->file("berkas_supplier.$index.file");

            if ($file !== null) {
                $row['file_path'] = $file->store('pengadaan/berkas-supplier', 'public');
            }

            if ($berkasSupplier['nama_berkas'] === 'lainnya') {
                $row['nama_berkas'] = $berkasSupplier['nama_berkas_lainnya'];
            } else {
                $row['nama_berkas'] = $berkasSupplier['nama_berkas'];
            }

            $row['pengadaan_ayam_id'] = $pengadaanAyam->id;

            $berkasPengadaanAyam = $this->berkasPengadaanAyam->firstOrNew(['id' => $berkasSupplier['id']]);
            $berkasPengadaanAyam->fill($row);
            $berkasPengadaanAyam->save();
            $savedBerkasPengadaanAyamIds[] = $berkasPengadaanAyam->id;
        }
        // hapus berkas yang tidak terpakai
        $pengadaanAyam->berkasSupplier()->whereNotIn('id', $savedBerkasPengadaanAyamIds)->get()->each->delete();

        // simpan dokumentasi
        $savedPengadaanAyamDokumentasiIds = [];
        foreach ($validated['dokumentasi_new'] ?? [] as $index => $dokumentasi) {
            $file = $request->file("dokumentasi_new.$index.file");

            if ($file !== null) {
                $row['file_path'] = $file->store('pengadaan/dokumentasi', 'public');
            }

            $row['pengadaan_ayam_id'] = $pengadaanAyam->id;

            $pengadaanAyamDokumentasi = $this->pengadaanAyamDokumentasi->newInstance();
            $pengadaanAyamDokumentasi->fill($row);
            $pengadaanAyamDokumentasi->save();

            $savedPengadaanAyamDokumentasiIds[] = $pengadaanAyamDokumentasi->id;
        }
        foreach ($validated['dokumentasi_persisted'] ?? [] as $index => $dokumentasi) {
            $savedPengadaanAyamDokumentasiIds[] = @$dokumentasi['id'];
        }
        // hapus dokumentasi yang tidak terpakai
        $pengadaanAyam->dokumentasi()->whereNotIn('id', $savedPengadaanAyamDokumentasiIds)->get()->each->delete();

        return back()->with('success', 'Data pengadaan ayam berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengadaanAyam $pengadaan_ayam)
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
