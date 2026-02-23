<?php

namespace Modules\Kandang\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\PopulasiAyam;

class PopulasiAyamRepository extends EloquentRepository
{
    public function __construct(PopulasiAyam $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $isEditableQuery = DB::table('populasi_ayam')
            ->groupBy('kandang_id')
            ->selectRaw('kandang_id, max(tanggal) as tanggal, 1 as editable');

        $query = $this->model
            ->query()
            ->from('populasi_ayam as pa')
            ->join('kandang as k', 'k.id', '=', 'pa.kandang_id')
            ->leftJoinSub($isEditableQuery, 'xieq', function ($join) {
                $join
                    ->on('xieq.kandang_id', '=', 'pa.kandang_id')
                    ->on('xieq.tanggal', '<=', 'pa.tanggal');
            })
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
                , coalesce(xieq.editable, 0) as is_editable
            SQL)
            ->groupBy('k.id', 'pa.tanggal', 'pa.umur_ayam_record')
            ;
        return $query;
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('pa.tanggal')->orderBy('nama_kandang');
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id' => function ($q, $kandangId) {
                $q->where('k.id', '=', $kandangId);
            }
        ];
    }
}
