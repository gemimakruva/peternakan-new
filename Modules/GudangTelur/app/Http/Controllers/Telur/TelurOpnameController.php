<?php

namespace Modules\GudangTelur\Http\Controllers\Telur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Repositories\Telur\TelurOpnameRepository;

class TelurOpnameController extends Controller
{
    public function __construct(
        private TelurOpnameRepository $repository,
    ) { }

    public function index(Request $request)
    {
        $datas = $this->repository->paginate(
            $request->query('search'),
            null,
            $request->collect(['orders']),
            $request->query('perPage', 10)
        );
        return view('gudang-telur::telur.opname.index', compact(['datas']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gudang-telur::telur.opname.create');
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
