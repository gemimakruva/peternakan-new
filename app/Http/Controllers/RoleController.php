<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('Lihat Semua Role');

        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('Tambah Role');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('Tambah Role');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('Edit Role');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('Edit Role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('Hapus Role');
    }
}
