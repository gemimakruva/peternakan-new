<?php

namespace Modules\Kandang\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\PopulasiAyam;

class PopulasiAyamRepository extends EloquentRepository
{
    public function __construct(PopulasiAyam $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->from('populasi_ayam as pa')
            ->join('kandang as k', 'k.id', '=', 'pa.kandang_id')
            ->selectRaw(<<<SQL
                k.id as id_kandang
                , k.nama as nama_kandang
                , pa.tanggal
                , pa.umur_ayam_record as umur_ayam
                , sum(ayam_sehat) as ayam_sehat
                , sum(ayam_mati) as ayam_mati
                , sum(ayam_afkir) as ayam_afkir
                , sum(ayam_masuk_karantina) as ayam_masuk_karantina
                , sum(ayam_keluar_karantina) as ayam_keluar_karantina
            SQL)
            ->groupBy('k.id', 'pa.tanggal', 'pa.umur_ayam_record')
            ;
        return $query;
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('pa.tanggal')->orderBy('nama_kandang');
    }
}
