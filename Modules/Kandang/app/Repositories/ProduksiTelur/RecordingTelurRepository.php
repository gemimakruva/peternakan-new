<?php

namespace Modules\Kandang\Repositories\ProduksiTelur;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\ProduksiTelur;
use Modules\Kandang\Repositories\EloquentRepository;

class RecordingTelurRepository extends EloquentRepository
{
    public function __construct(ProduksiTelur $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $itemQuery = DB::table('produksi_telur_item as pti')
            ->selectRaw(<<<SQL
                pti.produksi_telur_id
                , sum(pti.jumlah_telur_bagus) as jumlah_telur_bagus
                , sum(pti.jumlah_telur_putih) as jumlah_telur_putih
                , sum(pti.jumlah_telur_reject) as jumlah_telur_reject
                , (
                    sum(pti.jumlah_telur_bagus)
                    + sum(pti.jumlah_telur_putih)
                    + sum(pti.jumlah_telur_reject)
                ) as total_jumlah_telur
                , sum(pti.berat_telur_bagus) as berat_telur_bagus
                , sum(pti.berat_telur_putih) as berat_telur_putih
                , sum(pti.berat_telur_reject) as berat_telur_reject
                , (
                    sum(pti.berat_telur_bagus)
                    + sum(pti.berat_telur_putih)
                    + sum(pti.berat_telur_reject)
                ) as total_berat_telur
            SQL)
            ->groupBy('pti.produksi_telur_id');

        $query = $this->model
            ->query()
            ->join('kandang', 'kandang.id', '=', 'produksi_telur.kandang_id')
            ->join('users as pic_user', 'pic_user.id', '=', 'produksi_telur.pic_user_id')
            ->joinSub($itemQuery, 'xpti', 'xpti.produksi_telur_id', '=', 'produksi_telur.id')
            ->selectRaw(<<<SQL
                produksi_telur.id
                , produksi_telur.kandang_id
                , produksi_telur.tanggal
                , pic_user.name as nama_pic_user
                , kandang.nama as nama_kandang
                , produksi_telur.umur_ayam
                , xpti.jumlah_telur_bagus as jumlah_telur_bagus
                , xpti.jumlah_telur_putih as jumlah_telur_putih
                , xpti.jumlah_telur_reject as jumlah_telur_reject
                , xpti.total_jumlah_telur as total_jumlah_telur
                , xpti.berat_telur_bagus as berat_telur_bagus
                , xpti.berat_telur_putih as berat_telur_putih
                , xpti.berat_telur_reject as berat_telur_reject
                , xpti.total_berat_telur as total_berat_telur
                
            SQL)
            ->groupBy(
                'produksi_telur.kandang_id',
                'produksi_telur.tanggal'
            );

        return $query;
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id' => function ($q, $kandangId) {
                $q->where('produksi_telur.kandang_id', '=', $kandangId);
            },
            'tanggal' => function ($q, $tanggal) {
                $q->where('produksi_telur.tanggal', '=', $tanggal);
            }
        ];
    }
}