<?php
namespace Modules\Kandang\Http\Controllers\OvkPakan;

use App\Http\Controllers\Controller;
use App\Models\OvkOrder;
use Illuminate\Http\Request;
use Modules\Kandang\Models\FormRequestOrderOvk;
use Modules\Kandang\Models\Kandang;

class OrderOvkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = FormRequestOrderOvk::with('kandang')->latest();

    // Filter berdasarkan tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('tanggal', [
            $request->start_date,
            $request->end_date
        ]);
    } elseif ($request->filled('start_date')) {
        $query->whereDate('tanggal', '>=', $request->start_date);
    } elseif ($request->filled('end_date')) {
        $query->whereDate('tanggal', '<=', $request->end_date);
    }

    // Filter berdasarkan kandang
    if ($request->filled('kandang_id')) {
        $query->where('kandang_id', $request->kandang_id);
    }

    $data = $query->paginate(10)->withQueryString();
    $kandang = Kandang::all();

    return view('kandang::ovk-orders.index', compact('data', 'kandang'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kandangs = Kandang::latest()->get();
        return view('kandang::ovk-orders.create',compact('kandangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandang,id',
            'tanggal_pengecekan' => 'required|date',
            'jenis_ovk' => 'required|string',
            'merk_ovk' => 'required|string',
            'kemasan_ovk' => 'required|string',
            'total_kebutuhan_yang_diorder' => 'required|integer|min:1',
            'maksimal_kedatangan' => 'required|date|after_or_equal:tanggal',
        ]);

       FormRequestOrderOvk::create([
            'kandang_id' => $validated['kandang_id'],
            'tanggal' => $validated['tanggal_pengecekan'],
            'jenis_ovk' => $validated['jenis_ovk'],
            'merk_ovk' => $validated['merk_ovk'],
            'kemasan_ovk' => $validated['kemasan_ovk'],
            'total_kebutuhan_yang_diorder' => $validated['total_kebutuhan_yang_diorder'],
            'maksimal_kedatangan' => $validated['maksimal_kedatangan'],
]);


        return redirect()
            ->route('order-ovk.index')
            ->with('success', 'Order OVK berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(FormRequestOrderOvk $ovkOrder)
    {
        return view('ovk-orders.show', compact('ovkOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormRequestOrderOvk $orders_ovk)
    {
        $kandangs = Kandang::all();
        $data = $orders_ovk;
        return view('kandang::ovk-orders.edit', compact('data','kandangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormRequestOrderOvk $ovkOrder)
    {

         $validated = $request->validate([
            'kandang_id' => 'required|exists:kandang,id',
            'tanggal_pengecekan' => 'required|date',
            'jenis_ovk' => 'required|string',
            'merk_ovk' => 'required|string',
            'kemasan_ovk' => 'required|string',
            'total_kebutuhan_yang_diorder' => 'required|integer|min:1',
            'maksimal_kedatangan' => 'required|date|after_or_equal:tanggal',
        ]);

        $ovkOrder->update([
            'kandang_id' => $validated['kandang_id'],
            'tanggal_pengecekan' => $validated['tanggal_pengecekan'],
            'jenis_ovk' => $validated['jenis_ovk'],
            'merk_ovk' => $validated['merk_ovk'],
            'kemasan_ovk' => $validated['kemasan_ovk'],
            'total_kebutuhan' => $validated['total_kebutuhan_yang_diorder'],
            'maksimal_kedatangan' => $validated['maksimal_kedatangan'],
        ]);

        return redirect()
            ->route('order-ovk.index')
            ->with('success', 'Order OVK berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormRequestOrderOvk $orders_ovk)
    {

        $orders_ovk->delete();

        return redirect()
            ->route('order-ovk.index')
            ->with('success', 'Order OVK berhasil dihapus');
    }
}
