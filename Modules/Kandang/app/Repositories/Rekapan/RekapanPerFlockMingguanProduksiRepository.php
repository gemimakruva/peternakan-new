<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\EloquentRepository;

class RekapanPerFlockMingguanProduksiRepository extends EloquentRepository
{
    use KandangUmurTrait;

    public function __construct(Kandang $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $base = app(RekapanPerFlockProduksiRepository::class)
            ->setContext($this->kandangId, null)
            ->getQuery();

        $query = $this->model
            ->query()
            ->fromSub($base, 'xpaq')
            ->selectRaw(<<<SQL
                xpaq.flock_id
                , xpaq.nama_flock
                , xpaq.umur

                , xpaq.sehat as sehat
                , sum(xpaq.mati) as mati
                , sum(xpaq.afkir) as afkir

                , xpaq.akumulasi_mati
                , xpaq.akumulasi_afkir
                , xpaq.akumulasi_mati_afkir

                , xpaq.persen_mati
                , xpaq.persen_afkir
                , xpaq.persen_mati_afkir
                , xpaq.standar_mati_afkir
                , sum(xpaq.masuk_karantina) as masuk_karantina
                , sum(xpaq.keluar_karantina) as keluar_karantina

                , avg(xpaq.feed_intake_per_ekor) as feed_intake_per_ekor
                , xpaq.feed_intake_per_ekor_standar

                , sum(xpaq.total_jumlah_telur) as total_jumlah_telur
                , sum(xpaq.total_berat_telur) as total_berat_telur

                , avg(xpaq.hdp) as hdp
                , avg(xpaq.hhp) as hhp
                , avg(xpaq.fcr) as fcr
                , avg(xpaq.egg_weight) as egg_weight
                , avg(xpaq.egg_mass) as egg_mass
            SQL)
            ->groupBy('xpaq.umur', 'xpaq.flock_id')
            ->where('xpaq.umur', '=', $this->umur)
            ->orderBy('xpaq.nama_flock')
            ->orderBy('xpaq.tanggal', 'desc');
        
        return $query;
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id' => function ($q, $kandangId) {
                $q->where('xpaq.id', '=', $kandangId);
            }
        ];
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy('xpaq.nama_flock');
        $q->orderBy('xpaq.tanggal', 'desc');
    }
}