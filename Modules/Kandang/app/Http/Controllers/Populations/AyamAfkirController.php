<?php

namespace Modules\Kandang\Http\Controllers\Populations;
use Modules\Kandang\Models\AyamAfkir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Pipe;

class AyamAfkirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = AyamAfkir::orderBy('created_at', 'desc')->paginate(10);
         return view('kandang::ayam-afkir.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kandangs = Kandang::all();
        $flocks   = Flock::all();
        $pipes    = Pipe::all();

        return view('kandang::ayam-afkir.create', compact('kandangs', 'flocks', 'pipes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AyamAfkir $ayam_afkir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AyamAfkir $ayam_afkir)
    {
        $kandangs = Kandang::all();
        $flocks   = Flock::all();
        $pipes    = Pipe::all();

        return view('kandang::ayam-afkir.edit', compact(
            'ayam_afkir',
            'kandangs',
            'flocks',
            'pipes'
        ))->with(['data' => $ayam_afkir]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AyamAfkir $ayam_afkir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AyamAfkir $ayam_afkir)
    {
        //
    }
}
