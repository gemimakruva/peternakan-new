<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\EloquentRepository;

class RekapanProduksiRepository extends EloquentRepository
{
    public function __construct(Kandang $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        return $this->model
            ->query()
            ->joinSub(function($q) {
                $q 
                    ->from('populasi_ayam AS pa')
                    ->selectRaw(<<<SQL
                        pa.kandang_id
                        , pa.tanggal
                        , pa.umur_ayam_record AS umur
                        , (
                            SELECT SUM(pa2.ayam_mati) AS akumulasi_mati 
                            FROM populasi_ayam AS pa2
                            WHERE pa2.kandang_id = pa.kandang_id AND pa2.tanggal = pa.tanggal
                        ) AS mati
                        , (
                            SELECT SUM(pa2.ayam_mati) AS akumulasi_mati 
                            FROM populasi_ayam AS pa2
                            WHERE pa2.kandang_id = pa.kandang_id AND pa2.tanggal <= pa.tanggal
                        ) AS akumulasi_mati
                        , (
                            SELECT SUM(pa2.ayam_mati) AS akumulasi_mati 
                            FROM populasi_ayam AS pa2
                            WHERE pa2.kandang_id = pa.kandang_id AND pa2.tanggal <= pa.tanggal
                        )/SUM(pa.ayam_sehat) AS persen_mati
                        , (
                            SELECT SUM(pa2.ayam_afkir) AS akumulasi_afkir
                            FROM populasi_ayam AS pa2
                            WHERE pa2.kandang_id = pa.kandang_id AND pa2.tanggal = pa.tanggal
                        ) AS afkir
                        , (
                            SELECT SUM(pa2.ayam_afkir) AS akumulasi_afkir
                            FROM populasi_ayam AS pa2
                            WHERE pa2.kandang_id = pa.kandang_id AND pa2.tanggal <= pa.tanggal
                        ) AS akumulasi_afkir
                        , (
                            SELECT SUM(pa2.ayam_afkir) AS akumulasi_afkir
                            FROM populasi_ayam AS pa2
                            WHERE pa2.kandang_id = pa.kandang_id AND pa2.tanggal <= pa.tanggal
                        )/SUM(pa.ayam_sehat) AS persen_afkir
                        , SUM(pa.ayam_sehat) AS sehat
                    SQL)
                    ->groupBy([
                        'pa.tanggal',
                    ])
                    ->orderBy('pa.tanggal');
                // echo $q->get();die;
            }, 'xpa', 'xpa.kandang_id', '=', 'kandang.id')
            ->selectRaw(<<<SQL
                kandang.id
                , kandang.nama AS nama_kandang
                , xpa.tanggal
                , xpa.umur
                , xpa.mati
                , xpa.akumulasi_mati
                , xpa.persen_mati
                , xpa.afkir
                , xpa.akumulasi_afkir
                , xpa.persen_afkir
                , xpa.sehat
            SQL)
            ->groupBy([
                'kandang.id'
                , 'xpa.tanggal'
            ])
            ->orderBy('xpa.tanggal', 'asc');
    }
}