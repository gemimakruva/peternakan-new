<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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
        $base = DB::table('populasi_ayam as pa')
            ->selectRaw('
                pa.kandang_id,
                pa.tanggal,
                MAX(pa.umur_ayam_record) as umur,
                SUM(pa.ayam_sehat) as sehat,
                SUM(pa.ayam_mati) as mati,
                SUM(pa.ayam_afkir) as afkir
            ')
            ->groupBy('pa.kandang_id', 'pa.tanggal');

        $akumulasi = DB::table('populasi_ayam as pa2')
            ->selectRaw('
                pa2.kandang_id,
                pa2.tanggal,
                SUM(pa2.ayam_mati) as akumulasi_mati,
                SUM(pa2.ayam_afkir) as akumulasi_afkir
            ')
            ->groupBy('pa2.kandang_id', 'pa2.tanggal');

        return $this->model
            ->query()
            ->fromSub($base, 'xpa')
            ->join('kandang', 'kandang.id', '=', 'xpa.kandang_id')
            ->leftJoinSub($akumulasi, 'xa', function ($join) {
                $join->on('xa.kandang_id', '=', 'xpa.kandang_id')
                    ->whereColumn('xa.tanggal', '<=', 'xpa.tanggal');
            })
            ->selectRaw(<<<SQL
                kandang.id,
                kandang.nama as nama_kandang,
                xpa.tanggal,
                xpa.umur,
                xpa.sehat,
                xpa.mati,
                SUM(xa.akumulasi_mati) as akumulasi_mati,
                SUM(xa.akumulasi_mati) / NULLIF(xpa.sehat, 0) as persen_mati,
                xpa.afkir,
                SUM(xa.akumulasi_afkir) as akumulasi_afkir,
                SUM(xa.akumulasi_afkir) / NULLIF(xpa.sehat, 0) as persen_afkir
            SQL)
            ->groupBy(
                'kandang.id',
                'xpa.tanggal',
                'xpa.umur',
                'xpa.sehat',
                'xpa.mati',
                'xpa.afkir'
            )
            ->orderBy('xpa.tanggal');

    }
}