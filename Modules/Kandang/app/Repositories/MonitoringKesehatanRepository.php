<?php

namespace Modules\Kandang\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Kandang\Models\MonitoringKesehatan;

class MonitoringKesehatanRepository extends EloquentRepository
{
    public function __construct(MonitoringKesehatan $model)
    {
        parent::__construct($model);
    }

    public function index(array $filter, bool $isBuilder = false): Collection|Builder
    {
        $query = MonitoringKesehatan::with(['nekropsi', 'kandang'])
            ->when(isset($filter['kandang_id']), function ($query) use ($filter) {
                $query->where('kandang_id', $filter['kandang_id']);
            })
            ->when(isset($filter['start_date']), function ($query) use ($filter) {
                $query->whereBetween('tanggal', [$filter['start_date'], $filter['end_date']]);
            })
            ->when(isset($filter['tim_pelaksana']), function ($query) use ($filter) {
                $query->where('tim_pelaksana', 'LIKE', "%{$filter['tim_pelaksana']}%");
            })
            ->orderByDesc('tanggal');

        if ($isBuilder) {
            return $query;
        }

        return $query->get();
    }
}
