<?php

namespace Modules\Kandang\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Models\PopulasiAyam;

class PerhitunganPakanService
{
    public function getTableInitialState(PerhitunganPakan $perhitunganPakan)
    {
        $data = $perhitunganPakan;
        $data->load([
            'kandang',
            'kandang.flocks.pipes',
            'kandang.flocks.pipes.populasiAyam' => function($query) {
                $query
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('id', 'desc')
                    ->select(['id', 'pipe_id', 'ayam_sehat'])
                    ->limit(1);
            },
            'perhitunganPakanItems',
        ]);

        $initialState = [
            'pipes'     => []
        ];
        if ($data->perhitunganPakanItems->count() === 0) {
            foreach ($data->kandang->flocks as $flock) {
                foreach ($flock->pipes as $pipe) {
                    $initialState['pipes'][$pipe->id] = [
                        'id'                        => null,
                        'perhitungan_pakan_id'      => $data->id,
                        'kandang_id'                => $flock->kandang_id,
                        'flock_id'                  => $flock->id,
                        'pipe_id'                   => $pipe->id,
                        'jumlah_ayam'               => $pipe->populasiAyam[0]?->ayam_sehat ?? 0,
                        'pemberian_pakan_per_ekor'  => 0,
                    ];
                }
            }
        } else {
            $data->perhitunganPakanItems->each(function($item) use(&$initialState) {
                // jumlah ayam belum update dari populasi
                $initialState['pipes'][$item->pipe_id] = $item;
            });
        }

        return [$data, $initialState];
    }

    private function getFeedInTake($flockId, $tanggalPerbandingan) {
        $query = DB::table('perhitungan_pakan_item as ppi')
            ->selectRaw(<<<SQL
                flock_id
                , tanggal_pemberian_pakan
                , sum(jumlah_ayam) * avg(pemberian_pakan_per_ekor) as feed_intake
            SQL)
            ->where('flock_id', '=', $flockId)
            ->where('tanggal_pemberian_pakan', '=', $tanggalPerbandingan)
            ->groupBy(['flock_id', 'tanggal_pemberian_pakan']);

        $feedIntake = DB::table('pemberian_pakan_sisa_pakan as ppsp')
            ->join('perhitungan_pakan as pp', 'pp.id', '=', 'ppsp.perhitungan_pakan_id')
            ->joinSub($query, 'xppi', function ($join) {
                $join
                    ->on('xppi.flock_id', '=', 'ppsp.flock_id')
                    ->on('xppi.tanggal_pemberian_pakan', '=', 'pp.tanggal_pemberian_pakan');
            })
            ->selectRaw(<<<SQL
                xppi.feed_intake-ppsp.sisa_pakan_per_flock_kg as feed_intake
            SQL)
            ->where('pp.tanggal_pemberian_pakan', '=', $tanggalPerbandingan)
            ->where('ppsp.flock_id', '=', $flockId)
            ->value('feed_intake') ?? 0;

        return round($feedIntake/1000);
    }

    public function getFeedIntakeByFlock(int $flockId, ?Carbon $tanggalPerbandingan = null)
    {
        $tanggalPerbandingan ??= now();

        $hMin1TanggalPerbandingan = $tanggalPerbandingan->clone()->subDay();
        
        $feedIntakeHariIni = $this->getFeedInTake($flockId, $tanggalPerbandingan);
        if ($feedIntakeHariIni > 0) return (int) $feedIntakeHariIni;

        $feedIntake1HariSebelumnya = $this->getFeedInTake($flockId, $hMin1TanggalPerbandingan);
        if ($feedIntake1HariSebelumnya > 0) return (int) $feedIntake1HariSebelumnya;

        $tanggalTerakhir = app(PopulasiAyam::class)
            ->clone()
            ->where('flock_id', $flockId)
            ->max('tanggal');

        $feedIntakeTerakhir = $this->getFeedInTake($flockId, $tanggalTerakhir);

        if ($feedIntakeTerakhir > 0) return (int) $feedIntakeTerakhir;

        return 0;
    }
}
