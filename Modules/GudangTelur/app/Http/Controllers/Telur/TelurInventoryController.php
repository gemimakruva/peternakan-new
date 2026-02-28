<?php

namespace Modules\GudangTelur\Http\Controllers\Telur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GudangTelur\Repositories\Telur\TelurInventoryRepository;

class TelurInventoryController extends Controller
{
    public function __construct(
        private TelurInventoryRepository $repository,
    ) { }

    public function index(Request $request)
    {
        $dateStart = $request->query('date_start', now()->startOfYear()->format('Y-m-d'));
        $dateEnd = $request->query('date_end', now()->endOfYear()->format('Y-m-d'));

        $request->merge([
            'date_start'    => $dateStart,
            'date_end'      => $dateEnd,
        ]);

        $datas = $this->repository->paginate(
            $request->query('search'),
            $request->collect(['date_start', 'date_end']),
            $request->collect('orders'),
            $request->query('perPage', 10),
        );

        return view('gudang-telur::telur.inventory.index', compact([
            'datas',
            'dateStart',
            'dateEnd',
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gudangtelur::create');
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
