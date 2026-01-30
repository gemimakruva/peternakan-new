<?php
namespace Modules\Kandang\Http\Controllers\AyamAfkir;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\AyamAfkir;
use Illuminate\Http\Request;
use Modules\Kandang\Repositories\Afkir\AyamAfkirRepository;

class AyamAfkirController extends Controller
{
    public function __construct(
        private AyamAfkir $ayamAfkir,
        private AyamAfkirRepository $repository,
    ) { }

    public function index(Request $request)
    {
        $listAyamAfkir = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect('orders'),
            $request->query('perPage', 10)
        );

        return view("kandang::ayam-afkir.index", compact('listAyamAfkir'));
    }

    public function edit(AyamAfkir $ayamAfkir)
    {
        $ayamAfkir->load([
            'kandang',
            'picUser',
            'ayamAfkirPopulasi.pipe.flock',
        ]);

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
            'pic_user_id'        => auth()->id(),
            'pembeli_afkir'      => $validated['pembeli_afkir'],
            'harga_jual'         => $validated['harga_jual'],
            'penyebab_afkir'     => $validated['penyebab_afkir'],
        ]);
        $ayamAfkir->save();

       return to_route('ayam-afkir.index')->with('success', 'Data Ayam Afkir berhasil diupdate.');
    }
}
