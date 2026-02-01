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
                    ->join('pipe AS p', 'p.id', '=', 'pa.pipe_id')
                    ->join('flock AS f', 'f.id', '=', 'p.flock_id')
                    ->selectRaw(<<<SQL
                        f.kandang_id
                        , pa.tanggal
                        , pa.umur_ayam_record AS umur
                        , SUM(pa.ayam_mati) AS mati
                        , (
                            SELECT SUM(pa2.ayam_mati) AS akumulasi_mati 
                            FROM populasi_ayam AS pa2
                            INNER JOIN pipe AS p2 ON p2.id = pa2.pipe_id
                            INNER JOIN flock AS f2 ON f2.id = p2.flock_id
                            WHERE f2.kandang_id = f.kandang_id AND pa2.tanggal <= pa.tanggal
                        ) AS akumulasi_mati
                        , (
                            SELECT SUM(pa2.ayam_mati) AS akumulasi_mati 
                            FROM populasi_ayam AS pa2
                            INNER JOIN pipe AS p2 ON p2.id = pa2.pipe_id
                            INNER JOIN flock AS f2 ON f2.id = p2.flock_id
                            WHERE f2.kandang_id = f.kandang_id AND pa2.tanggal <= pa.tanggal
                        )/SUM(pa.ayam_sehat) AS persen_mati
                        , SUM(pa.ayam_sehat) AS sehat
                    SQL)
                    ->groupBy([
                        'pa.tanggal',
                    ])
                    ->orderBy('pa.tanggal');
                echo $q->get();die;
            }, 'xpa', 'xpa.kandang_id', '=', 'kandang.id')
            ->selectRaw(<<<SQL
                kandang.id
                , kandang.nama AS nama_kandang
                , xpa.tanggal
                , xpa.umur
                , xpa.mati
                , xpa.sehat
            SQL)
            ->groupBy([
                'kandang.id'
                , 'xpa.tanggal'
            ])
            ->orderBy('xpa.tanggal', 'asc');
    }
}