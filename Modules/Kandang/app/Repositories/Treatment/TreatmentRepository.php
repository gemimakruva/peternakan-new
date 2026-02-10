<?php

namespace Modules\Kandang\Repositories\Treatment;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\Treatment;
use Modules\Kandang\Repositories\EloquentRepository;

class TreatmentRepository extends EloquentRepository
{
    public function __construct(Treatment $model)
    {
        parent::__construct($model);
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('uc.name', 'LIKE', "%$search%");
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('kandang as k', 'k.id', '=', 'treatment.kandang_id')
            ->join('users as uc', 'uc.id', '=', 'treatment.user_creator_id')
            ->selectRaw(<<<SQL
                treatment.id
                , k.nama as nama_kandang
                , uc.name as nama_creator
                , treatment.tanggal
            SQL)
            ->groupBy('treatment.id');
        return $query;
    }
}
