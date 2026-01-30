<?php

namespace Modules\Kandang\Repositories\Afkir;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\AyamAfkir;
use Modules\Kandang\Repositories\EloquentRepository;

class AyamAfkirRepository extends EloquentRepository
{
    public function __construct(AyamAfkir $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        return $this->model
            ->query()
            ->join('kandang', 'kandang.id', '=', 'ayam_afkir.kandang_id')
            ->leftJoin('users', 'users.id', '=', 'ayam_afkir.pic_user_id')
            ->join('ayam_afkir_populasi', 'ayam_afkir_populasi.ayam_afkir_id', '=', 'ayam_afkir.id')
            ->selectRaw(<<<SQL
                ayam_afkir.*
                , kandang.nama as nama_kandang
                , users.name as nama_pic_user
                , SUM(ayam_afkir_populasi.jumlah_ayam_afkir) AS total_jumlah_ayam_afkir
            SQL)
            ->groupBy([
                'ayam_afkir.id',
                'ayam_afkir.kandang_id',
                'ayam_afkir.pic_user_id',
                'ayam_afkir.tanggal',
                'ayam_afkir.umur_ayam',
                'ayam_afkir.penyebab_afkir', 
                'ayam_afkir.pembeli_afkir', 
                'ayam_afkir.harga_jual',
                'nama_kandang',
                'nama_pic_user',
                'ayam_afkir.created_at',
                'ayam_afkir.updated_at'
            ]);
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where(function($q2) use($search) {
            $q2->where('kandang.nama', 'LIKE', "%$search%")
                ->orWhere('users.nama', 'LIKE', "%$search%")
                ->orWhere('ayam_afkir.pembeli_afkir', 'LIKE', "%$search%");
        });
    }
}
