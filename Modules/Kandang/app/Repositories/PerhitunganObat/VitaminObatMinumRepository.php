<?php

namespace Modules\Kandang\Repositories\PerhitunganObat;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Kandang\Models\VitaminObatMinum;
use Modules\Kandang\Repositories\EloquentRepository;

class VitaminObatMinumRepository extends EloquentRepository
{
    public function __construct(VitaminObatMinum $model)
    {
        parent::__construct($model);
    }

    public function index(array $filter, bool $isBuilder = false): Collection|Builder
    {
        $query = VitaminObatMinum::with(['jenisTreatment', 'flock.kandang'])
            ->when(isset($filter['kandang_id']), function ($query) use ($filter) {
                $query->whereHas('flock', function ($query) use ($filter) {
                    $query->where('kandang_id', $filter['kandang_id']);
                });
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
}
