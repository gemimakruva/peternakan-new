<?php

namespace Modules\Kandang\Http\Controllers\JenisPakan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kandang\Models\JenisPakan;

class JenisPakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $jenisPakan = JenisPakan::orderBy('created_at', 'DESC')->paginate(10); 
          return view('kandang::master-data.jenis-pakan.index', compact('jenisPakan'));
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
    public function show(JenisPakan $jenisPakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPakan $jenisPakan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisPakan $jenisPakan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPakan $jenisPakan)
    {
        //
    }
}
