<?php

namespace Modules\Kandang\Repositories\SamplingAyam;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\SamplingBobotAyam;
use Modules\Kandang\Repositories\EloquentRepository;

class SamplingAyamRepository extends EloquentRepository
{
    public function __construct(SamplingBobotAyam $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $samplingQuery = DB::table('sampling_bobot_ayam_per_ekor as sbape')
            ->join('sampling_bobot_ayam as sba', 'sba.id', '=', 'sbape.sampling_bobot_ayam_id')
            ->join('kandang as k', 'k.id', '=', 'sba.kandang_id')
            ->join('strain_standart_metric as ssm', function($join) {
                $join
                    ->on('ssm.strain_id', '=', 'k.strain_id')
                    ->on('ssm.umur', '=', 'sba.umur')
                    ->on(DB::raw('ssm.berat_badan_min/1000'), '<=', 'sbape.bobot_per_kg')
                    ->on(DB::raw('ssm.berat_badan_max/1000'), '>=', 'sbape.bobot_per_kg');
            })
            ->selectRaw(<<<SQL
                sbape.sampling_bobot_ayam_id
                , count(sbape.bobot_per_kg) as jumlah_masuk_range
            SQL)
            ->groupBy('sbape.sampling_bobot_ayam_id');
        
        
        $samplingQuery2 = DB::table('sampling_bobot_ayam_per_ekor as sbape')
            ->joinSub($samplingQuery, 'xs', 'xs.sampling_bobot_ayam_id', '=', 'sbape.sampling_bobot_ayam_id')
            ->selectRaw(<<<SQL
                sbape.sampling_bobot_ayam_id
                , count(sbape.bobot_per_kg) as jumlah_sampling
                , max(sbape.bobot_per_kg) as bobot_max
                , min(sbape.bobot_per_kg) as bobot_min
                , sum(sbape.bobot_per_kg)/count(sbape.bobot_per_kg) as bobot_rata2
                , xs.jumlah_masuk_range
                , xs.jumlah_masuk_range/count(sbape.bobot_per_kg) as uniformity
            SQL)
            ->groupBy('sbape.sampling_bobot_ayam_id');

        $populasiQuery = DB::table('populasi_ayam as pa')
            ->selectRaw(<<<SQL
                pa.kandang_id
                , pa.tanggal
                , SUM(pa.ayam_sehat) as sehat
            SQL)
            ->groupBy('pa.kandang_id', 'pa.tanggal');

        $query = $this->model
            ->query()
            ->from('sampling_bobot_ayam as sba')
            ->join('users as pu', 'pu.id', '=', 'sba.pencatat_user_id')
            ->join('kandang as k', 'k.id', '=', 'sba.kandang_id')
            ->joinSub($samplingQuery2, 'xsbape', function ($join) {
                $join->on('xsbape.sampling_bobot_ayam_id', '=', 'sba.id');
            })
            ->joinSub($populasiQuery, 'xp', function ($join) {
                $join->on('xp.kandang_id', '=', 'sba.kandang_id')
                    ->on('xp.tanggal', '=', 'sba.tanggal');
            })
            ->leftJoin('strain_standart_metric as ssm', function($join) {
                $join->on('ssm.strain_id', '=', 'k.strain_id')
                    ->on('ssm.umur', '=', 'sba.umur');
            })
            ->selectRaw(<<<SQL
                sba.id
                , sba.tanggal
                , sba.kandang_id
                , pu.name as nama_pencatat
                , k.nama as nama_kandang
                , xp.sehat as jumlah_ayam
                , xsbape.jumlah_sampling as jumlah_sampling
                , sba.umur as umur_ayam
                , ssm.berat_badan/1000 as standar_bobot
                , ssm.berat_badan_min/1000 as standar_bobot_min
                , ssm.berat_badan_max/1000 as standar_bobot_max
                , xsbape.bobot_rata2 as realisasi_bobot
                , xsbape.bobot_min as realisasi_bobot_min
                , xsbape.bobot_max as realisasi_bobot_max
                , xsbape.jumlah_masuk_range
                , xsbape.uniformity
            SQL)
            ->groupBy('sba.id');

        return $query;
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy('k.nama');
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id'    => function ($q, $kandangId) {
                $q->where('sba.kandang_id', '=', $kandangId);
            },
            'tanggal'       => function ($q, $tanggal) {
                $q->where('sba.tanggal', '=', $tanggal);
            },
        ];
    }
}
