<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Repositories\EloquentRepository;

class RekapanPerFlockPakanHarianRepository extends EloquentRepository
{
    use KandangTanggalTrait;

    public function __construct(PerhitunganPakan $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $pakanQuery = DB::table('perhitungan_pakan_item as ppi')
            ->join('perhitungan_pakan as pp', 'pp.id', '=', 'ppi.perhitungan_pakan_id')
            ->selectRaw(<<<SQL
                ppi.flock_id
                , ppi.kandang_id
                , ppi.tanggal_pemberian_pakan as tanggal
                , AVG(ppi.pemberian_pakan_per_ekor)*SUM(ppi.jumlah_ayam)/1000 as pemberian_kg
                , SUM(ppi.jumlah_ayam) as jumlah_ayam
                , ppi.perhitungan_pakan_id
                , pp.umur_ayam
            SQL)
            ->groupBy('ppi.perhitungan_pakan_id', 'ppi.flock_id')
            ->where('ppi.kandang_id', '=', $this->kandangId)
            ->when($this->tanggal, function ($query2, $tanggal) {
                $query2->whereDate('ppi.tanggal_pemberian_pakan', '=', $tanggal);
            });

        $sisaPakanQuery = DB::table('pemberian_pakan_sisa_pakan as ppsp')
            ->join('flock','flock.id', '=', 'ppsp.flock_id')
            ->selectRaw(<<<SQL
                SUM(sisa_pakan_per_flock_kg) as sisa_kg
                , ppsp.perhitungan_pakan_id
            SQL)
            ->groupBy('ppsp.perhitungan_pakan_id');

        $query =  $this->model
            ->query()
            ->fromSub($pakanQuery, 'xppi')
            ->leftJoinSub($sisaPakanQuery, 'xppsp', 'xppsp.perhitungan_pakan_id', '=', 'xppi.perhitungan_pakan_id')
            ->join('flock', 'flock.id', '=', 'xppi.flock_id')
            ->join('kandang', 'kandang.id', '=', 'xppi.kandang_id')
            ->leftJoin('strain_standart_metric as ssm', function($join) {
                $join->on('ssm.strain_id', '=', 'kandang.strain_id')
                    ->on('ssm.umur', 'xppi.umur_ayam');
            })
            ->selectRaw(<<<SQL
                flock.id as flock_id
                , flock.nama as nama_flock
                , kandang.id as kandang_id
                , xppi.tanggal
                , xppi.umur_ayam
                , xppi.jumlah_ayam
                , xppi.pemberian_kg
                , xppsp.sisa_kg
                , (xppi.pemberian_kg - xppsp.sisa_kg) AS feed_intake_kg
                , (xppi.pemberian_kg - xppsp.sisa_kg)*1000/xppi.jumlah_ayam AS feed_intake_per_ekor
                , ssm.feed_intake as feed_intake_per_ekor_standar
            SQL)
            ->groupBy('xppi.flock_id', 'xppi.tanggal')
            ->where('xppi.kandang_id', '=', $this->kandangId)
            ->when($this->tanggal, function ($query2, $tanggal) {
                $query2->whereDate('xppi.tanggal', '=', $tanggal);
            });

        return $query;
    }
}