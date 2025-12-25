<?php

namespace Modules\Kandang\Http\Controllers\penjadwalanTreatment;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\PenjadwalanTreatment;
use Illuminate\Http\Request;
use Modules\Kandang\Models\JenisTreatment;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\MetodeTreatment;
use Modules\Kandang\Models\PenjadwalanTreatmentFlock;

class PenjadwalanTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
          $query = PenjadwalanTreatment::with(
                    'treatmentFlocks.jenisTreatment',
                    'treatmentFlocks.metodeTreatment',
                    'treatmentFlocks.flock',
                    'picUser',
                    'kandang'
                )->latest('tanggal');


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

        $kandang = Kandang::latest()->get();
        $data = $query->paginate(10)->withQueryString();

        return view('kandang::penjadwalan-treatment.index',
        compact('kandang','data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kandang = Kandang::latest()->get();
        $jenisTreatment = JenisTreatment::latest()->get();
        $metodeTreatment = MetodeTreatment::latest()->get();
         return view('kandang::penjadwalan-treatment.create',
         compact('kandang', 'jenisTreatment', 'metodeTreatment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $validated =  $request->validate([
                'tanggal' => 'required|date',
                'kandang_id' => 'required|integer|exists:kandang,id',
                'waktu_pelaksanaan' => 'required|date_format:H:i',
                'treatment' => 'required|array',
                'treatment.*.flock_id' => 'required|integer|exists:flock,id',
                'treatment.*.jenis_treatment_id' => 'required|integer',
                'treatment.*.metode_pemberian_id' => 'required|integer',
                'treatment.*.dosis' => 'required',
                ]);

        $userId = auth()->id();

        $PenjadwalaanTreatment = PenjadwalanTreatment::create([
            'kandang_id' => $validated['kandang_id'],
            'tanggal' => $validated['tanggal'],
            'pic_user_id' => $userId,
            'detail_waktu' => $validated['waktu_pelaksanaan']
        ]);

        foreach ($validated['treatment'] as $index => $t) {
            PenjadwalanTreatmentFlock::create([
                'penjadwalan_treatment_id' => $PenjadwalaanTreatment->id,
                'flock_id'                 => $t['flock_id'],
                'jenis_treatment_id'       => $t['jenis_treatment_id'],
                'metode_treatment_id'      => $t['metode_pemberian_id'],
                'dosis_pemberian'          => $t['dosis'],
            ]);
        }

        return back()->with('success', 'Data berhasil disimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(PenjadwalanTreatment $penjadwalanTretment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PenjadwalanTreatment $penjadwalan_treatment)
    {
        $kandang = Kandang::latest()->get();
        $jenisTreatment = JenisTreatment::latest()->get();
        $metodeTreatment = MetodeTreatment::latest()->get();
        $penjadwalan_treatment->load(
        'treatmentFlocks.jenisTreatment',
        'treatmentFlocks.metodeTreatment',
        'picUser',
        'kandang'
    );
        $kandang = Kandang::latest()->get();
        return view('kandang::penjadwalan-treatment.edit',
        compact('penjadwalan_treatment', 'kandang','metodeTreatment','jenisTreatment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenjadwalanTreatment $penjadwalan_treatment)
{
    $validated = $request->validate([
        'tanggal' => 'required|date',
        'waktu_pelaksanaan' => 'required|date_format:H:i',
        'treatment' => 'required|array',
        'treatment.*.flock_id' => 'required|integer|exists:flock,id',
        'treatment.*.jenis_treatment_id' => 'required|integer',
        'treatment.*.metode_pemberian_id' => 'required|integer',
        'treatment.*.dosis' => 'required',
    ]);
    // Update data utama
    $penjadwalan_treatment->update([
        'kandang_id' => $penjadwalan_treatment->kandang_id,
        'tanggal' => $validated['tanggal'],
        'detail_waktu' => $validated['waktu_pelaksanaan'],
    ]);

    // Hapus semua detail lama (treatmentFlocks)
    $penjadwalan_treatment->treatmentFlocks()->delete();

    // Simpan detail treatment baru
    foreach ($validated['treatment'] as $t) {
        PenjadwalanTreatmentFlock::create([
            'penjadwalan_treatment_id' => $penjadwalan_treatment->id,
            'flock_id' => $t['flock_id'],
            'jenis_treatment_id' => $t['jenis_treatment_id'],
            'metode_treatment_id' => $t['metode_pemberian_id'],
            'dosis_pemberian' => $t['dosis'],
        ]);
    }

    return redirect()->route('penjadwalan-treatment.index')
                     ->with('success', 'Data berhasil diupdate.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenjadwalanTreatment $penjadwalanTreatment)
    {
        try {
            $penjadwalanTreatment->delete();
            return redirect()->route('penjadwalan-treatment.index')
                            ->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('penjadwalan-treatment.index')
                            ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}
