<?php

namespace Modules\Kandang\Repositories\Treatment;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\TreatmentJadwal;
use Modules\Kandang\Repositories\EloquentRepository;

class TreatmentPelaksanaanRepository extends EloquentRepository
{
    public function __construct(TreatmentJadwal $model)
    {
        parent::__construct($model);
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('k.nama', 'LIKE', "%$search%");
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('treatment as t', 't.id', '=', 'treatment_jadwal.treatment_id')
            ->join('kandang as k', 'k.id', '=', 't.kandang_id')
            ->join('users as uc', 'uc.id', '=', 't.user_creator_id')
            ->selectRaw(<<<SQL
                k.id as id_kandang
                , k.nama as nama_kandang
                , month(t.tanggal) as bulan
                , count(treatment_jadwal.id) as treatment_terjadwal
            SQL)
            ->groupBy('k.id', 'bulan');
        return $query;
    }
}
