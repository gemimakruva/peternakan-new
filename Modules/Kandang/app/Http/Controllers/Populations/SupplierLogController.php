<?php

namespace Modules\Kandang\Http\Controllers\Populations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\SupplierLog;

class SupplierLogController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date');

        $query = SupplierLog::with([
            'pipe.flock.kandang',
            'recordedBy'
        ])->orderBy('log_date', 'desc');

        if ($date) {
            $query->whereDate('log_date', $date);
        }

        $logs = $query->paginate(10)->appends($request->query());
        return view('kandang::new-population.index', compact('logs', 'date'));
    }

    public function create()
    {
        $pipes = Pipe::with('flock')->get();
        return view('kandang::master-data.population.create', compact('pipes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pipe_id' => 'required|exists:pipe,id',
            'log_date' => 'required|date',
            'died_daily' => 'nullable|integer',
            'culled_daily' => 'nullable|integer',
            'died_total' => 'nullable|integer',
            'culled_total' => 'nullable|integer',
            'mortality_rate' => 'nullable|numeric',
            'cull_rate' => 'nullable|numeric',
            'healthy_daily' => 'nullable|integer',
            'chicken_in' => 'nullable|integer',
            'chicken_added' => 'nullable|integer',
        ]);

        $validated['recorded_by'] = Auth::id();

        SupplierLog::create($validated);

        return redirect()->route('supplier-log.index')->with('success', 'Log supplier berhasil ditambahkan.');
    }

    public function edit(SupplierLog $supplierLog)
    {
        $pipes = Pipe::with('flock')->get();
        return view('kandang::master-data.population.edit', compact('supplierLog', 'pipes'));
    }

    public function update(Request $request, SupplierLog $supplierLog)
    {
        $validated = $request->validate([
            'pipe_id' => 'required|exists:pipe,id',
            'log_date' => 'required|date',
            'died_daily' => 'nullable|integer',
            'culled_daily' => 'nullable|integer',
            'died_total' => 'nullable|integer',
            'culled_total' => 'nullable|integer',
            'mortality_rate' => 'nullable|numeric',
            'cull_rate' => 'nullable|numeric',
            'healthy_daily' => 'nullable|integer',
            'chicken_in' => 'nullable|integer',
            'chicken_added' => 'nullable|integer',
        ]);

        $supplierLog->update($validated);

        return redirect()->route('supplier-log.index')->with('success', 'Log supplier berhasil diperbarui.');
    }

    public function destroy(SupplierLog $supplierLog)
    {
        $supplierLog->delete();
        return back()->with('success', 'Log supplier berhasil dihapus.');
    }
}
