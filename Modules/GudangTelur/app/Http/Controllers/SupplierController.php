<?php

namespace Modules\GudangTelur\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = collect(range(1, 35))->map(function ($item) {
            return (object) [
                'id'    => $item,
                'nama'  => fake()->name(),
            ];
        });
        $datas = (new LengthAwarePaginator(
            $datas->forPage(
                request()->query('page', LengthAwarePaginator::resolveCurrentPage()),
                10,
            ),
            $datas->count(),
            10,
            request()->query('page'),
        ));
        return view('gudangtelur::supplier.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gudangtelur::supplier.create');
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
        return view('gudangtelur::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('gudangtelur::edit');
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
