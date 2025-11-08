<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kandang\Models\Kandang;

class KandangController extends Controller
{
    public function __construct(
        private Kandang $kandang,
    ) { }

    public function index()
    {
        $datas = $this->kandang
            ->query()
            ->when(request()->query('search'), function($query, $search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(request()->get('perPage', 10));
        return view('kandang::master-data.kandang.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandang::master-data.kandang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:1000'],
        ]);

        $this->kandang->create($request->all());

        return to_route('master-data.kandang.index')->with('success', 'Data Berhasil Ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = $this->kandang->findOrFail($id);
        return view('kandang::master-data.kandang.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:1000'],
        ]);

        $kandang = $this->kandang->findOrFail($id);
        $kandang->nama = $request->input('nama');
        $kandang->alamat = $request->input('alamat');
        $kandang->save();

        return to_route('master-data.kandang.index')->with('success', 'Data Berhasil Diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $kandang = $this->kandang->findOrFail($id);
        $kandang->delete();

        return to_route('master-data.kandang.index')->with('danger', 'Data Berhasil Dihapus.');
    }
}
