<?php
namespace Modules\Kandang\Http\Controllers\AyamAfkir;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\AyamAfkir;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AyamAfkirController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $listAyamAfkir = AyamAfkir::with(['populasi.kandang', 'populasi.flock',
         'populasi.pipe', 'pic_user'])
        ->orderBy('updated_at', 'desc') 
        ->paginate(10);
        return view("kandang::ayam-afkir.index", 
        compact('listAyamAfkir'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $listPopulasiAyam = PopulasiAyam::with(['kandang', 'flock', 'pipe'])->get();
         return view('kandang::ayam-afkir.create', compact('listPopulasiAyam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
                    'populasi_ayam_id'   => ['required', 'exists:populasi_ayam,id'],
                    'tanggal'            => ['required', 'date'],                   
                    'umur_ayam'          => ['required', 'integer', 'min:1'],       
                    'jumlah_ayam_afkir'  => ['required', 'integer', 'min:1'],     
                    'pembeli_afkir'      => ['nullable', 'string', 'max:255'],      
                    'harga_jual'         => ['nullable', 'numeric', 'min:0'],        
                    'penyebab_afkir'     => ['required', 'string', 'max:500'],     
                ]);
        $populasi = PopulasiAyam::findOrFail($validated['populasi_ayam_id']);
        $populasi->ayam_afkir += $validated['jumlah_ayam_afkir'];
        $populasi->save();

         $userid = Auth::id();

        AyamAfkir::create([
        'populasi_ayam_id'   => $validated['populasi_ayam_id'],
        'pic_user_id'        => $userid,
        'tanggal'            => $validated['tanggal'],
        'umur_ayam'          => $validated['umur_ayam'],
        'jumlah_ayam_afkir'  => $validated['jumlah_ayam_afkir'],
        'pembeli_afkir'      => $validated['pembeli_afkir'],
        'harga_jual'         => $validated['harga_jual'],
        'penyebab_afkir'     => $validated['penyebab_afkir'],
    ]);

       return redirect()->route('ayam-afkir.index')
        ->with('success', 'Data Ayam Afkir berhasil disimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(AyamAfkir $ayamAfkir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AyamAfkir $ayamAfkir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AyamAfkir $ayamAfkir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AyamAfkir $ayamAfkir)
{
    try {
        $ayamAfkir->delete();
        return redirect()->back()->with('success', 'Data ayam afkir berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus data ayam afkir: ' .
         $e->getMessage());
    }
}
}
