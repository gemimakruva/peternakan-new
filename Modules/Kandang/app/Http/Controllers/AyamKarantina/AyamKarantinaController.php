<?php

namespace Modules\Kandang\Http\Controllers\AyamKarantina;

use App\Http\Controllers\Controller;
use Modules\Kandang\Models\AyamKarantina;
use Illuminate\Http\Request;

class AyamKarantinaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $listAyamKarantina = AyamKarantina::latest()->paginate(10);
         return view('kandang::ayam-karantina.index', compact('listAyamKarantina'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(AyamKarantina $ayamKarantina)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AyamKarantina $ayamKarantina)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AyamKarantina $ayamKarantina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AyamKarantina $ayamKarantina)
    {
        //
    }
}
