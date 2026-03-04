<?php

namespace Modules\GudangPakan\Repositories\MasterData;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Models\BahanPakan;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanRepository extends EloquentRepository
{
    public function __construct(BahanPakan $model)
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

    public function save(array $data)
    {
        $bahanPakan = $this->model->updateOrCreate([
            'id'    => @$data['id'],
        ], [
            'tipe'  => @$data['tipe'],
            'nama'  => @$data['nama'],
        ]);

        return $bahanPakan;
    }
}