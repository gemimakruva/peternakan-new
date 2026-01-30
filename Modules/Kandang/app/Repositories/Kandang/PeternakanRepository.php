<?php

namespace Modules\Kandang\Repositories\Kandang;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\Peternakan;
use Modules\Kandang\Repositories\EloquentRepository;

class PeternakanRepository extends EloquentRepository
{
    public function __construct(Peternakan $model)
    {
        parent::__construct($model);
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('nama', 'like', "%{$search}%")
            ->orWhere('lokasi', 'like', "%{$search}%");
    }
}