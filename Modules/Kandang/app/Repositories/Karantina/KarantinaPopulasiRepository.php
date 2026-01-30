<?php

namespace Modules\Kandang\Repositories\Karantina;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\KarantinaPopulasi;
use Modules\Kandang\Repositories\EloquentRepository;

class KarantinaPopulasiRepository extends EloquentRepository
{
    public function __construct(KarantinaPopulasi $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        return $this->model
            ->query()
            ->join('kandang', 'kandang.id', '=', 'karantina_populasi.kandang_id')
            ->join('users', 'users.id', '=', 'karantina_populasi.pic_user_id')
            ->selectRaw(<<<SQL
                karantina_populasi.*
                , kandang.nama as nama_kandang
                , users.name as nama_pic_user
            SQL);
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where(function($q2) use($search) {
            $q2->where('users.nama', 'LIKE', "%$search%");
        });
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy('karantina_populasi.tanggal', 'desc');
        $q->orderBy('kandang.nama', 'desc');
    }
}
