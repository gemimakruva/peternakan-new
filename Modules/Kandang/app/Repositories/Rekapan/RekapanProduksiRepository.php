<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\EloquentRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanPakanHarianRepository;
use Modules\Kandang\Repositories\Rekapan\RekapanProduksiTelurRepository;

class RekapanProduksiRepository extends EloquentRepository
{
    public function __construct(Kandang $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $base = app(RekapanPopulasiAyamRepository::class)->getQuery();
        $produksiPakanQuery = app(RekapanPakanHarianRepository::class)->getQuery();
        $produksiTelurQuery = app(RekapanProduksiTelurRepository::class)->getQuery();

        return $this->model
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
                , xpaq.kandang_id
                , xpaq.nama_kandang
                , xpaq.tanggal
                , xpaq.umur
                , xpaq.sehat
                , xpaq.mati
                , xpaq.akumulasi_mati
                , xpaq.persen_mati
                , xpaq.afkir
                , xpaq.akumulasi_afkir
                , xpaq.persen_afkir
                , xpaq.akumulasi_mati_afkir
                , xpaq.persen_mati_afkir
                , xpaq.standar_mati_afkir
                , xpaq.masuk_karantina
                , xpaq.keluar_karantina

                , xppq.tanggal_pemberian_pakan
                , xppq.umur_ayam
                , xppq.jumlah_ayam
                , xppq.pemberian_kg
                , xppq.sisa_kg
                , xppq.feed_intake_kg
                , xppq.feed_intake_per_ekor
                , xppq.feed_intake_per_ekor_standar

                , xptq.jumlah_ayam_pengadaan
                , xptq.jumlah_telur_bagus
                , xptq.jumlah_telur_putih
                , xptq.jumlah_telur_reject
                , xptq.total_jumlah_telur
                , xptq.berat_telur_bagus
                , xptq.berat_telur_putih
                , xptq.berat_telur_reject
                , xptq.total_berat_telur
                , xptq.hdp
                , xptq.hhp
                , xptq.fcr
                , xptq.egg_weight
                , xptq.egg_mass
            SQL)
            ->groupBy(
                'xpaq.id',
                'xpaq.tanggal',
                'xpaq.umur',
                'xpaq.sehat',
                'xpaq.mati',
                'xpaq.afkir'
            );
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id'    => function ($q, $kandangId) {
                $q->where('xpaq.id', '=', $kandangId);
            },
            'tanggal'       => function ($q, $tanggal) {
                $q->where('xpaq.tanggal', '=', $tanggal);
            }
        ];
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy('xpaq.tanggal');
    }
}