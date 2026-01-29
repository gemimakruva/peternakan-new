<?php

namespace Modules\Kandang\Repositories\Kandang;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Enums\JenisPemeriksaan;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Repositories\EloquentRepository;

class FlockRepository extends EloquentRepository
{
    public function __construct(Flock $model)
    {
        parent::__construct($model);
    }

    public function populasiAyam(Collection $filter)
    {
        return $this->model
            ->leftJoin('kandang as k', 'k.id', '=', 'flock.kandang_id')
            // pengadaan ayam terbaru per kandang
            ->leftJoinSub(
                DB::table('pengadaan_ayam as pa1')
                    ->select(
                        'pa1.kandang_id',
                        'pa1.tanggal',
                        'pa1.umur_ayam',
                    )
                    ->whereRaw('pa1.tanggal = (
                        SELECT MAX(pa2.tanggal)
                        FROM pengadaan_ayam pa2
                        WHERE pa2.kandang_id = pa1.kandang_id
                    )'),
                'pa',
                'pa.kandang_id',
                '=',
                'k.id'
            )
            // akumulasi populasi ayam per flock
            ->leftJoinSub(
                DB::table('populasi_ayam as pa')
                    ->join('pipe as p', 'p.id', '=', 'pa.pipe_id')
                    ->join('flock as f2', 'f2.id', '=', 'p.flock_id')
                    ->when($filter->get('date_range'), function($query, $dateRange) {
                        $query->whereBetween('pa.tanggal', $dateRange);
                    })
                    ->when($filter->get('kandang_id'), function($query, $kandangId) {
                        $query->where('f2.kandang_id', $kandangId);
                    })
                    ->groupBy('p.flock_id')
                    ->select(
                        'p.flock_id',
                        DB::raw('SUM(pa.ayam_mati) as ayam_mati'),
                        DB::raw('SUM(pa.ayam_afkir) as ayam_afkir'),
                        DB::raw('SUM(pa.ayam_masuk_karantina) as ayam_masuk_karantina'),
                        DB::raw('SUM(pa.ayam_keluar_karantina) as ayam_keluar_karantina'),
                        DB::raw('MAX(pa.tanggal) as terakhir_diperharui')
                    ),
                'x_total',
                'x_total.flock_id',
                '=',
                'flock.id'
            )
            ->leftJoinSub(
                DB::table('populasi_ayam as pa2')
                ->join('pipe as p2', 'p2.id', '=', 'pa2.pipe_id')
                ->join('flock as f3', 'f3.id', '=', 'p2.flock_id')
                ->when($filter->get('date_range'), function($query, $dateRange) {
                    $query->whereBetween('pa2.tanggal', $dateRange);
                })
                ->when($filter->get('kandang_id'), function($query, $kandangId) {
                    $query->where('f3.kandang_id', $kandangId);
                })
                ->groupBy('p2.flock_id')
                ->where('jenis_pemeriksaan', '=', JenisPemeriksaan::PENGADAAN->value)
                ->select([
                    'p2.flock_id',
                    DB::raw('SUM(pa2.ayam_sehat) as ayam_sehat'),
                ]),
                'x_total_ayam_sehat',
                'x_total_ayam_sehat.flock_id',
                '=',
                'flock.id'
            )
            ->when($filter->get('kandang_id'), function($query, $kandangId) {
                $query->where('flock.kandang_id', $kandangId);
            })
            ->select([
                'flock.id',
                'flock.nama',
                'pa.tanggal',
                'pa.umur_ayam',
            ])
            ->selectRaw('
                (
                    x_total_ayam_sehat.ayam_sehat
                    - COALESCE(x_total.ayam_mati, 0)
                    - COALESCE(x_total.ayam_afkir, 0)
                    - COALESCE(x_total.ayam_masuk_karantina, 0)
                    + COALESCE(x_total.ayam_keluar_karantina, 0)
                ) AS ayam_sehat
                , x_total_ayam_sehat.ayam_sehat as jumlah_ayam_masuk_kandang
            ')
            ->addSelect([
                'x_total.ayam_mati',
                'x_total.ayam_afkir',
                'x_total.ayam_masuk_karantina',
                'x_total.ayam_keluar_karantina',
                'x_total.terakhir_diperharui',
            ]);
    }
}
