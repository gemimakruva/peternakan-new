<?php

namespace Modules\GudangTelur\Repositories\MasterData;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Models\Satuan;
use Modules\Kandang\Repositories\EloquentRepository;

class SatuanRepository extends EloquentRepository
{
    public function __construct(Satuan $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query();

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('nama', 'LIKE', "%$search%");
    }
}