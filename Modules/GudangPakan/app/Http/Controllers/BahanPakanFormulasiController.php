<?php

namespace Modules\GudangPakan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BahanPakanFormulasiController extends Controller
{    
    public function __construct(
        
    ) {
        $this->middleware('can:gudang-pakan.bahan-pakan-formulasi.menu-bahan-pakan-formulasi');
    }

    public function index()
    {
        return view('gudang-pakan::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gudang-pakan::index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('gudangpakan::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('gudangpakan::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
