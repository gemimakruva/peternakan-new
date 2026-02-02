<?php

namespace Modules\Kandang\Repositories\Pakan;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Repositories\EloquentRepository;

class OverviewPakanHarianRepository extends EloquentRepository
{
    public function __construct(PerhitunganPakan $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        return $this->model
            ->query()
            ->joinSub(function($q) {
                $q->selectRaw(<<<SQL
                    ppi.perhitungan_pakan_id
                    , SUM(ppi.pemberian_pakan_per_ekor * ppi.jumlah_ayam)/1000 AS pemberian_kg
                    , SUM(ppi.jumlah_ayam) as jumlah_ayam
                SQL)
                ->from('perhitungan_pakan_item AS ppi')
                ->groupBy('ppi.perhitungan_pakan_id');
            }, 'xppi', 'xppi.perhitungan_pakan_id', '=', 'perhitungan_pakan.id')
            ->joinSub(function($q) {
                $q->selectRaw(<<<SQL
                    ppsp.perhitungan_pakan_id
                    , SUM(ppsp.sisa_pakan_per_flock_kg) AS sisa_kg
                SQL)
                    ->from('pemberian_pakan_sisa_pakan AS ppsp')
                    ->groupBy('ppsp.perhitungan_pakan_id');
            }, 'xppsp', 'xppsp.perhitungan_pakan_id', '=', 'perhitungan_pakan.id')
            ->join('kandang', 'kandang.id', '=', 'perhitungan_pakan.kandang_id')
            ->selectRaw(<<<SQL
                perhitungan_pakan.id
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
    }
}