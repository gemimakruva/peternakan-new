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
                $initialState['pipes'][$item->id] = $item;
            });
        }

        return [$data, $initialState];
    }
}
