<?php
namespace Modules\Kandang\Http\Controllers\PopulasiAyam;

use App\Enums\PopulasiAyamJenisPemeriksaanEnum;
use App\Http\Controllers\Controller;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PopulasiAyamController extends Controller
{
    public function __construct(
        private Kandang $kandang,
        private PopulasiAyam $populasiAyam,
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
            'kandang_id' => ['required', 'exists:kandang,id'],
            'flock_id' => ['required', 'exists:flock,id'],
            'pipe_id' => ['required', 'exists:pipe,id'],
            'umur_ayam' => ['required', 'min:1'],
            'ayam_sehat' => ['required', 'min:0'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $this->populasiAyam->create([
            'pic_user_id'            => Auth::id(),
            'kandang_id'            => $validated['kandang_id'],
            'flock_id'              => $validated['flock_id'],
            'pipe_id'               => $validated['pipe_id'],
            'jenis_pemeriksaan'     => PopulasiAyamJenisPemeriksaanEnum::HARIAN,
            'tanggal'               => $validated['tanggal_transaksi'],
            'ayam_sehat'            => $validated['ayam_sehat'],
            'ayam_mati'             => 0,         
            'ayam_afkir'            => 0,
            'ayam_masuk_karantina'  => 0,
            'ayam_keluar_karantina' => 0,
            'catatan'               => $validated['catatan'] ?? null,
        ]);

        return back()->with('success', 'Data populasi berhasil disimpan.');
    }

    public function getRecordedPopulasi($kandangId, $tanggal)
    {
        return $this->populasiAyam
            ->where([
                'kandang_id' => $kandangId,
                'tanggal' => $tanggal
            ])
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
