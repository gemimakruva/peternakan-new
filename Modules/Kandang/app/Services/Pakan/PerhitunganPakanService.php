<?php

namespace Modules\Kandang\Services\Pakan;

use Modules\Kandang\Models\PerhitunganPakan;

class PerhitunganPakanService
{
    public function getTableInitialState(PerhitunganPakan $perhitunganPakan)
    {
        $data = $perhitunganPakan;
        $data->load([
            'kandang',
            'kandang.flocks.pipes',
            'kandang.flocks.pipes.populasiAyam' => function($query) {
                $query->latest()->select(['pipe_id', 'ayam_sehat'])->limit(1);
            },
            'perhitunganPakanItems',
        ]);

        $initialState = [
            'flocks'    => [],
            'pipes'     => []
        ];
        if ($data->perhitunganPakanItems->count() === 0) {
            foreach ($data->kandang->flocks as $flock) {
                $initialState['flocks'][$flock->id] = [
                    'jumlah_ayam'                   => $flock->pipes->sum(function($item) {
                        return $item->populasiAyam->sum('ayam_sehat');
                    }),
                    'pemberian_pakan_per_flock_kg'  => 0,
                    'pemberian_pakan_pagi_kg'       => 0,
                    'pemberian_pakan_sore_kg'       => 0,
                ];
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
                $initialState['pipes'][$item->id] = $item;
            });
            $data->kandang->flocks->each(function($item) use(&$initialState, $data) {
                $flock = $data->perhitunganPakanItems->filter(fn($item2) => $item2->flock_id == $item->id);
                $jumlahAyamPerFlock = $flock->sum('jumlah_ayam');
                // dd($jumlahAyamPerFlock);
                // dd($flock->sum('pemberian_pakan_per_ekor'), $jumlahAyamPerFlock);
                $pemberianPakanPerFlockKg = $flock->sum(fn($item3) => $item3->jumlah_ayam*$item3->pemberian_pakan_per_ekor)/1000;
                $initialState['flocks'][$item->id] = [
                    'jumlah_ayam'                   => $jumlahAyamPerFlock,
                    'pemberian_pakan_per_flock_kg'  => $pemberianPakanPerFlockKg,
                    'pemberian_pakan_pagi_kg'       => $pemberianPakanPerFlockKg * ($data->proporsi_pemberian_pagi/100),
                    'pemberian_pakan_sore_kg'       => $pemberianPakanPerFlockKg * ($data->proporsi_pemberian_sore/100),
                ];
            });
        }

        return [$data, $initialState];
    }
}
