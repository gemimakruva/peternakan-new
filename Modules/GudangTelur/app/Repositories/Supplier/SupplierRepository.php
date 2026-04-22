<?php

namespace Modules\GudangTelur\Repositories\Supplier;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Enums\SupplierTipe;
use Modules\GudangTelur\Models\Supplier;
use Modules\Kandang\Repositories\EloquentRepository;

class SupplierRepository extends EloquentRepository
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query()->where('tipe', '=', SupplierTipe::KEMASAN->value);

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('nama', 'LIKE', "%$search%");
    }

    public function getSelectItems(string $column = 'nama')
    {
        return $this->getModel()->where('tipe', '=', SupplierTipe::KEMASAN->value)->orderBy($column)->pluck($column, 'id')->toArray();
    }
}