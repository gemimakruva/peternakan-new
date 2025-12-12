<?php

namespace Modules\Kandang\Repositories\Disinfektan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Kandang\Models\PenjadwalanDisinfektan;
use Modules\Kandang\Repositories\EloquentRepository;

class PenjadwalanDisinfektanRepository extends EloquentRepository
{
    public function __construct(PenjadwalanDisinfektan $model)
    {
        parent::__construct($model);
    }

    public function index(array $filter, bool $isBuilder = false): Collection|Builder
    {
        $query = PenjadwalanDisinfektan::with(['kandang'])
            ->when(isset($filter['kandang_id']), function ($query) use ($filter) {
                $query->where('kandang_id', $filter['kandang_id']);
            })
            ->when(isset($filter['start_date']), function ($query) use ($filter) {
                $query->whereBetween('tanggal', [$filter['start_date'], $filter['end_date']]);
            })
            ->orderByDesc('tanggal');

        if ($isBuilder) {
            return $query;
        }

        return $query->get();
    }

    public function store(array $data): PenjadwalanDisinfektan
    {
        return PenjadwalanDisinfektan::create($data);
    }
}
