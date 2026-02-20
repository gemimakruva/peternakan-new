<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\EloquentRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanPakanHarianRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanProduksiTelurRepository;

class RekapanMingguanProduksiRepository extends EloquentRepository
{
    use KandangUmurTrait;

    public function __construct(Kandang $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $base = app(RekapanPopulasiAyamRepository::class)->getQuery();
        $produksiPakanQuery = app(RekapanPakanHarianRepository::class)->getQuery();
        $produksiTelurQuery = app(RekapanProduksiTelurRepository::class)->getQuery();

        $base->orderBy('nama_kandang', 'asc');
        $base->orderBy('tanggal', 'desc'); // when groupBy minggu get latest tanggal

        $query = $this->model
            ->query()
            ->fromSub($base, 'xpaq')
            ->leftJoinSub($produksiPakanQuery, 'xppq', function ($join) {
                $join
                    ->on('xppq.id_kandang', '=', 'xpaq.kandang_id')
                    ->on('xppq.tanggal_pemberian_pakan', '=', 'xpaq.tanggal');
            })
            ->leftJoinSub($produksiTelurQuery, 'xptq', function ($join) {
                $join
                    ->on('xptq.kandang_id', '=', 'xpaq.kandang_id')
                    ->on('xptq.tanggal', '=', 'xpaq.tanggal');
            })
            ->selectRaw(<<<SQL
                xpaq.id

                , xpaq.nama_kandang
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

                , avg(xppq.feed_intake_per_ekor) as feed_intake_per_ekor
                , xppq.feed_intake_per_ekor_standar

                , sum(xptq.total_jumlah_telur) as total_jumlah_telur
                , sum(xptq.total_berat_telur) as total_berat_telur

                , avg(xptq.hdp) as hdp
                , avg(xptq.hhp) as hhp
                , avg(xptq.fcr) as fcr
                , avg(xptq.egg_weight) as egg_weight
                , avg(xptq.egg_mass) as egg_mass
            SQL)
            ->groupBy(
                'xpaq.kandang_id',
                'xpaq.umur',
            )
            ->where('umur', '=', $this->umur);

        return $query;
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id'    => function ($q, $kandangId) {
                $q->where('xpaq.kandang_id', '=', $kandangId);
            },
            'umur'       => function ($q, $umur) {
                $q->where('xpaq.umur', '=', $umur);
            }
        ];
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy('xpaq.umur');
    }
}