<?php
namespace Modules\Kandang\Http\Controllers\AyamAfkir;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\AyamAfkir;
use Modules\Kandang\Models\PopulasiAyam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AyamAfkirController extends Controller
{
    public function __construct(
        private AyamAfkir $ayamAfkir,
    ) { }

    public function index()
    {
        $listAyamAfkir = $this->ayamAfkir
            ->with([
                'populasi.pengadaanDistribusi.pipe.flock', 
                'picUser'
            ])
            ->orderBy('created_at', 'desc') 
            ->orderBy('id', 'desc')
            ->paginate(request()->query('perPage', 10))
            ->withQueryString();

        return view("kandang::ayam-afkir.index", compact('listAyamAfkir'));
    }

    public function edit(AyamAfkir $ayamAfkir)
    {
        return view('kandang::ayam-afkir.edit', compact('ayamAfkir'));
    }

    public function update(Request $request, AyamAfkir $ayamAfkir)
    {
        $validated = $request->validate([
            'pembeli_afkir'      => ['nullable', 'string', 'max:255'],      
            'harga_jual'         => ['nullable', 'numeric', 'min:0'],        
            'penyebab_afkir'     => ['required', 'string', 'max:500'],     
        ]);

        $ayamAfkir->fill([
            'pembeli_afkir'      => $validated['pembeli_afkir'],
            'harga_jual'         => $validated['harga_jual'],
            'penyebab_afkir'     => $validated['penyebab_afkir'],
        ]);
        $ayamAfkir->save();

       return to_route('ayam-afkir.index')->with('success', 'Data Ayam Afkir berhasil diupdate.');
    }
}
