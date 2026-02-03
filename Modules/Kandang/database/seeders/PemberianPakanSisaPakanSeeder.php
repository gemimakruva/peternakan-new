<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\PemberianPakanSisaPakan;
use Modules\Kandang\Models\PerhitunganPakan;


class PemberianPakanSisaPakanSeeder extends Seeder
{
    public function run(): void
    {
        PerhitunganPakan::with('kandang.flocks')->get()->each(function(PerhitunganPakan $item) {
            $item->kandang->flocks->each(function(Flock $item2) use($item) {
                PemberianPakanSisaPakan::firstOrCreate([
                    'perhitungan_pakan_id'      => $item->id,
                    'flock_id'                  => $item2->id,
                ], [
                    'sisa_pakan_per_flock_kg'   => 1,
                ]);
            });
        });
    }
}
