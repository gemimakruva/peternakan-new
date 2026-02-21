<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Repositories\EloquentRepository;

class RekapanPakanHarianRepository extends EloquentRepository
{
    public function __construct(PerhitunganPakan $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $pakanQuery = DB::table('perhitungan_pakan_item as ppi')
            ->selectRaw(<<<SQL
                AVG(ppi.pemberian_pakan_per_ekor)*SUM(ppi.jumlah_ayam)/1000 as pemberian_kg
                , SUM(ppi.jumlah_ayam) as jumlah_ayam
                , ppi.perhitungan_pakan_id
            SQL)
            ->groupBy('ppi.perhitungan_pakan_id');

        $sisaPakanQuery = DB::table('pemberian_pakan_sisa_pakan as ppsp')
            ->selectRaw(<<<SQL
                SUM(sisa_pakan_per_flock_kg) as sisa_kg
                , ppsp.perhitungan_pakan_id
            SQL)
            ->groupBy('ppsp.perhitungan_pakan_id');

        $query =  $this->model
            ->query()
            ->leftJoinSub($pakanQuery, 'xppi', 'xppi.perhitungan_pakan_id', '=', 'perhitungan_pakan.id')
            ->leftJoinSub($sisaPakanQuery, 'xppsp', 'xppsp.perhitungan_pakan_id', '=', 'perhitungan_pakan.id')
            ->join('kandang', 'kandang.id', '=', 'perhitungan_pakan.kandang_id')
            ->leftJoin('strain_standart_metric as ssm', function($join) {
                $join->on('ssm.strain_id', '=', 'kandang.strain_id')
                    ->on('ssm.umur', 'perhitungan_pakan.umur_ayam');
            })
            ->selectRaw(<<<SQL
                perhitungan_pakan.id
                , kandang.id as id_kandang
                , kandang.nama as nama_kandang
                , perhitungan_pakan.tanggal_pemberian_pakan
                , perhitungan_pakan.umur_ayam
                , xppi.jumlah_ayam
                , xppi.pemberian_kg
                , xppsp.sisa_kg
                , (xppi.pemberian_kg - xppsp.sisa_kg) AS feed_intake_kg
                , (xppi.pemberian_kg - xppsp.sisa_kg)*1000/xppi.jumlah_ayam AS feed_intake_per_ekor
                , (
                    SELECT feed_intake
                    FROM strain_standart_metric AS ssm 
                    WHERE ssm.strain_id = kandang.strain_id AND ssm.umur = perhitungan_pakan.umur_ayam
                    LIMIT 1
                ) as feed_intake_per_ekor_standar
            SQL);

        return $query;
    }
}