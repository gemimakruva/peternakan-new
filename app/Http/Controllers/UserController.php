<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('Lihat Semua User');

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('Tambah User');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('Tambah User');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('Edit User');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('Edit User');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('Hapus User');
    }
}
