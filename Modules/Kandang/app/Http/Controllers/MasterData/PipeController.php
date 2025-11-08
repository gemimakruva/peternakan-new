<?php

namespace Modules\Kandang\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Kandang\Models\Pipe;

class PipeController extends Controller
{
    public function __construct(
        private Pipe $pipe,
    ) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = $this->pipe
            ->query()
            ->paginate(request()->query('perPage', 10));
        return view('kandang::master-data.pipe.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kandang::master-data.pipe.create');
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
        return view('kandang::master-data.pipe.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('kandang::master-data.pipe.edit');
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
