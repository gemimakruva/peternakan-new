<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Peternakan;
use Modules\Kandang\Models\Strain;

class KandangFlockController extends Controller
{
    public function __construct(
        private Strain $strain,
        private Peternakan $peternakan,
        private Kandang $kandang,
        private Flock $flock,
    ) { }

    public function create(Kandang $kandang)
    {
        $kandang->load('peternakan:id,nama');

        return view('kandang::master-data.kandang.flock.create', compact('kandang'));
    }

    public function store(Kandang $kandang)
    {
        request()->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('flock', 'nama')],
        ]);

        $this->flock->create([
            'kandang_id' => $kandang->id,
            'nama' => request()->input('nama'),
        ]);

        return to_route('master-data.kandang.show', $kandang)->with('success', 'Flock baru berhasil ditambahkan.');
    }

    public function show(Kandang $kandang, Flock $flock)
    {
        return view('kandang::master-data.kandang.flock.show', compact('kandang', 'flock'));
    }

    public function edit(Kandang $kandang, Flock $flock)
    {
        return view('kandang::master-data.kandang.flock.edit', compact('kandang', 'flock'));
    }

    public function update(Kandang $kandang, Flock $flock)
    {
        request()->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('flock', 'nama')->ignore($flock)],
        ]);

        $flock->update(request()->only('nama'));

        return to_route('master-data.kandang.show', $kandang)->with('success', 'Flock berhasil diubah.');
    }

    public function destroy(Kandang $kandang, Flock $flock)
    {
        if ($flock->pipes()->exists()) {
            return back()->with('danger', 'Flock ini tidak bisa dihapus karena memiliki Pipa terkait.');
        }

        $flock->delete();

        return to_route('master-data.kandang.show', $kandang)->with('success', 'Flock berhasil dihapus.');
    }
}
