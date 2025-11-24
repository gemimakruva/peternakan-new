<?php

namespace Modules\Kandang\Helper;
use Modules\Kandang\Models\Flock;


class FlockHelper
{
    public static function updateFlockCapacity($flockId)
    {
        $flock = Flock::with('pipes')->find($flockId);

        if (!$flock) return;

        $totalCapacity = $flock->pipes->sum('kapasitas');

        // update kapasitas flock
        $flock->update([
            'kapasitas' => $totalCapacity
        ]);
    }
}
