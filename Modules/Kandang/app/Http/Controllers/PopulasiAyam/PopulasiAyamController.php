<?php
namespace Modules\Kandang\Http\Controllers\PopulasiAyam;

use App\Http\Controllers\Controller;
use Modules\Kandang\Enums\JenisPemeriksaan;
use Modules\Kandang\Models\AyamAfkir;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;

class PopulasiAyamController extends Controller
{
    public function __construct(
        private Kandang $kandang,
        private PopulasiAyam $populasiAyam,
        private AyamAfkir $ayamAfkir,
    ) { }
    
    public function index()
    {
       return view("kandang::populasi-ayam.index");
    }

    /**
     * Show the form for creating a new resource.
     */

     /**
     * Show the list of pengadaan
     */
    
    public function create()
    {
        $list_kandang = Kandang::all();
        return view("kandang::populasi-ayam.list-tanggal-pengadaan", compact('list_kandang'));
    }

    public function createByDate($kandangId)
    {
        $kandang = $this->kandang->findOrFail($kandangId);
        return view("kandang::populasi-ayam.create", compact('kandang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_transaksi' => ['required', 'date'],
            'pipe_id' => ['required', 'exists:pipe,id'],
            'umur_ayam_record' => ['required', 'min:1'],
            'ayam_sehat' => ['nullable', 'min:0'],
            'ayam_mati' => ['nullable', 'min:0'],
            'ayam_afkir' => ['nullable', 'min:0'],
            'ayam_masuk_karantina' => ['nullable', 'min:0'],
            'ayam_keluar_karantina' => ['nullable', 'min:0'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $populasiAyam = $this->populasiAyam->create([
            'pic_user_id'           => auth()->id(),
            'pipe_id'               => $validated['pipe_id'],
            'jenis_pemeriksaan'     => JenisPemeriksaan::HARIAN,
            'umur_ayam_record'      => $validated['umur_ayam_record'],
            'tanggal'               => $validated['tanggal_transaksi'],
            'ayam_sehat'            => $validated['ayam_sehat'],
            'ayam_mati'             => $validated['ayam_mati'],
            'ayam_afkir'            => $validated['ayam_afkir'],
            'ayam_masuk_karantina'  => $validated['ayam_masuk_karantina'],
            'ayam_keluar_karantina' => $validated['ayam_keluar_karantina'],
            'catatan'               => $validated['catatan'] ?? null,
        ]);

        if (@$validated['ayam_afkir'] > 0) {
            $this->ayamAfkir->create([
                'populasi_ayam_id' => $populasiAyam->id,
                'pic_user_id' => auth()->id(),
                'tanggal' => $validated['tanggal_transaksi'],
                'umur_ayam' => $validated['umur_ayam'],
                'jumlah_ayam_afkir' => $validated['ayam_afkir'],
            ]);
        }

        return back()->with('success', 'Data populasi berhasil disimpan.');
    }

    public function getRecordedPopulasi($kandangId, $tanggal)
    {
        return $this->populasiAyam
            ->whereRelation('pipe.flock', 'kandang_id', '=', $kandangId)
            ->where('tanggal', '=', $tanggal)
            ->with('pipe:id,nama')
            ->get();
    }

    /**
     * Display the specified resource.
     */
    public function show(PopulasiAyam $populasiAyam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PopulasiAyam $populasiAyam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PopulasiAyam $populasiAyam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PopulasiAyam $populasiAyam)
    {
        //
    }
}
