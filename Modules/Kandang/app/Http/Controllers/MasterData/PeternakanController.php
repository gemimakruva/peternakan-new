<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\Peternakan;
use Illuminate\Http\Request;

class PeternakanController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar peternakan dengan fitur pencarian dan paginasi.
     */
    public function index()
    {
        $search = request()->input('search');

        $datas = Peternakan::query()
            ->with('kandang:peternakan_id')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(request()->query('perPage', 10))
            ->withQueryString();

        return view('kandang::master-data.peternakan.index', compact('datas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandang::master-data.peternakan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string',
        ]);

        Peternakan::create([
            'nama'   => $validated['nama'],
            'lokasi' => $validated['lokasi'],
        ]);

        return redirect()
            ->route('master-data.peternakan.index')
            ->with('success', 'Data peternakan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peternakan $peternakan)
    {
        // Bisa digunakan untuk menampilkan detail peternakan jika diperlukan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peternakan $peternakan)
    {
        return view('kandang::master-data.peternakan.edit', compact('peternakan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peternakan $peternakan)
        {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'lokasi' => 'required|string|max:500',
            ]);
            try {
                
                $peternakan->update($validated);
                return redirect()->route('master-data.peternakan.index')
                    ->with('success', 'Data peternakan berhasil diperbarui.');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Terjadi kesalahan saat memperbarui data peternakan.');
            }
        }


    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Peternakan $peternakan)
    {

        if ($peternakan->kandang()->exists()) {
            return redirect()->back()->with('error', 
                'Peternakan ini tidak bisa dihapus karena masih memiliki kandang terkait.');
        }

        try {
            if($peternakan->kandang()->exists()) {
                return redirect()->back()->with('error', 'Data peternakan tidak dapat dihapus karena memiliki kandang terkait.');
            }

            $peternakan->delete();
            return redirect()->back()->with('success', 'Data peternakan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

}
