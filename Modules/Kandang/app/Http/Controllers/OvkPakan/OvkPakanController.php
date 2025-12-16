<?php

namespace Modules\Kandang\Http\Controllers\OvkPakan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\OvkPakan;

class OvkPakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = OvkPakan::with('flock.kandang')->latest();

    // Filter berdasarkan tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
    } elseif ($request->filled('start_date')) {
        $query->whereDate('tanggal', '>=', $request->start_date);
    } elseif ($request->filled('end_date')) {
        $query->whereDate('tanggal', '<=', $request->end_date);
    }
    if ($request->filled('kandang_id')) {
        $query->where('kandang_id', $request->kandang_id);
    }

    $data = $query->paginate(10);
    $kandang = Kandang::all();

    return view('kandang::ovk-pakan.index', compact('data', 'kandang'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kandang =Kandang::latest()->get();
        $flock = Flock::latest()->get();
        return view('kandang::ovk-pakan.create', compact('kandang','flock'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
    {
        // ================= VALIDASI =================
        $validated = $request->validate([
            'tanggal'                  => 'required|date',
            'kandang_id'               => 'required|exists:kandang,id',
            'flock_id'                 => 'required|exists:flock,id',
            'merk_ovk'                 => 'nullable|string|max:255',
            'dosis_ovk'                => 'required|numeric|min:0',
            'total_kebutuhan_pakan'    => 'required|numeric|min:0',
            'waktu_pemberian_pakan'    => 'required|in:pagi,sore,pagi_sore',
            'proporsi_pemberian_pagi'  => 'nullable|numeric|min:0|max:100',
            'proporsi_pemberian_sore'  => 'nullable|numeric|min:0|max:100',

            'perhitungan_kebutuhan_pakan_pagi' => 'nullable|numeric|min:0',
            'perhitungan_kebutuhan_pakan_sore' => 'nullable|numeric|min:0',
            'perhitungan_kebutuhan_ovk'        => 'nullable|numeric|min:0',
        ]);

        $totalPakan = $validated['total_kebutuhan_pakan'];
        $dosisOVK  = $validated['dosis_ovk'];

        $pagi = $sore = 0;

        if ($validated['waktu_pemberian_pakan'] === 'pagi') {
            $pagi = $totalPakan * ($validated['proporsi_pemberian_pagi'] / 100);
        } elseif ($validated['waktu_pemberian_pakan'] === 'sore') {
            $sore = $totalPakan * ($validated['proporsi_pemberian_sore'] / 100);
        } elseif ($validated['waktu_pemberian_pakan'] === 'pagi_sore') {
            $pagi = $totalPakan * ($validated['proporsi_pemberian_pagi'] / 100);
            $sore = $totalPakan * ($validated['proporsi_pemberian_sore'] / 100);
        }

        $totalOVK = ($totalPakan * $dosisOVK) / 1000;
        $ovk = OvkPakan::create([
            'tanggal'                           => $validated['tanggal'],
            'kandang_id'                        => $validated['kandang_id'],
            'flock_id'                          => $validated['flock_id'],
            'merk_ovk'                          => $validated['merk_ovk'] ?? null,
            'Dosis_OVK'                         => $dosisOVK,
            'total_kebutuhan_pakan'             => $totalPakan,
            'waktu_pemberian_pakan'             => $validated['waktu_pemberian_pakan'],
            'proposi_pemberian_pagi'            => $validated['proporsi_pemberian_pagi'] ?? null,
            'proposi_pemberian_sore'            => $validated['proporsi_pemberian_sore'] ?? null,
            'perhitungan_kebutuhan_pakan_pagi' => $pagi,
            'perhitungan_kebutuhan_pakan_sore' => $sore,
            'perhitungan_kebutuhan_ovk'        => $totalOVK,
        ]);
        return redirect()
            ->route('ovk-pakan.index')
            ->with('success', 'Data OVK & Pakan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(OvkPakan $ovkPakan)
    {
        return view('kandang::ovk-pakan.show', compact('ovkPakan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OvkPakan $ovkPakan)
    {
        $kandang = Kandang::latest()->get();
        return view('kandang::ovk-pakan.edit', compact('ovkPakan','kandang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OvkPakan $ovkPakan)
{
    // ================= VALIDASI =================
    $validated = $request->validate([
        // Informasi Umum
        'tanggal'                  => 'required|date',
        'kandang_id'               => 'required|exists:kandang,id',
        'flock_id'                 => 'required|exists:flock,id',

        // OVK & Pakan
        'merk_ovk'                 => 'nullable|string|max:255',
        'dosis_ovk'                => 'required|numeric|min:0',
        'total_kebutuhan_pakan'    => 'required|numeric|min:0',

        // Waktu Pemberian
        'waktu_pemberian_pakan'    => 'required|in:pagi,sore,pagi_sore',

        // Proporsi
        'proporsi_pemberian_pagi'  => 'nullable|numeric|min:0|max:100',
        'proporsi_pemberian_sore'  => 'nullable|numeric|min:0|max:100',
    ]);

    // ================= HITUNG OTOMATIS =================
    $totalPakan = $validated['total_kebutuhan_pakan'];
    $dosisOVK  = $validated['dosis_ovk'];

    $pagi = $sore = 0;

    if ($validated['waktu_pemberian_pakan'] === 'pagi') {
        $pagi = $totalPakan * ($validated['proporsi_pemberian_pagi'] / 100);
    } elseif ($validated['waktu_pemberian_pakan'] === 'sore') {
        $sore = $totalPakan * ($validated['proporsi_pemberian_sore'] / 100);
    } elseif ($validated['waktu_pemberian_pakan'] === 'pagi_sore') {
        $pagi = $totalPakan * ($validated['proporsi_pemberian_pagi'] / 100);
        $sore = $totalPakan * ($validated['proporsi_pemberian_sore'] / 100);
    }

    $totalOVK = ($totalPakan * $dosisOVK) / 1000;

    // ================= UPDATE DATA =================
    $ovkPakan->update([
        'tanggal'                           => $validated['tanggal'],
        'kandang_id'                        => $validated['kandang_id'],
        'flock_id'                          => $validated['flock_id'],
        'merk_ovk'                          => $validated['merk_ovk'] ?? null,
        'Dosis_OVK'                         => $dosisOVK,
        'total_kebutuhan_pakan'             => $totalPakan,
        'waktu_pemberian_pakan'             => $validated['waktu_pemberian_pakan'],
        'proposi_pemberian_pagi'            => $validated['proporsi_pemberian_pagi'] ?? null,
        'proposi_pemberian_sore'            => $validated['proporsi_pemberian_sore'] ?? null,
        'perhitungan_kebutuhan_pakan_pagi' => $pagi,
        'perhitungan_kebutuhan_pakan_sore' => $sore,
        'perhitungan_kebutuhan_ovk'        => $totalOVK,
    ]);

    return redirect()
        ->route('ovk-pakan.index')
        ->with('success', 'Data OVK & Pakan berhasil diperbarui');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OvkPakan $ovkPakan)
    {
        $ovkPakan->delete();

        return redirect()
            ->route('ovk-pakan.index')
            ->with('success', 'Data OVK & Pakan berhasil dihapus');
    }
}
