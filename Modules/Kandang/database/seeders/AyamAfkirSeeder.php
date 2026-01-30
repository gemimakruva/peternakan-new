<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\AyamAfkir;
use Illuminate\Support\Carbon;
use Modules\Kandang\Models\AyamAfkirPopulasi;
use Modules\Kandang\Models\PopulasiAyam;

class AyamAfkirSeeder extends Seeder
{
    public function run(): void
    {
        $populasiDenganAyamAfkir = PopulasiAyam::query()
            ->with('pipe.flock')
            ->where('ayam_afkir', '>', 0)->get();

        $populasiDenganAyamAfkir->map(function($pdaa) {
            $ayamAfkir = AyamAfkir::firstOrCreate([
                'kandang_id'        => $pdaa->pipe->flock->kandang_id,
                'tanggal'           => $pdaa->tanggal,
                'umur_ayam'         => $pdaa->umur_ayam_record,
            ]);

            AyamAfkirPopulasi::create([
                'ayam_afkir_id'     => $ayamAfkir->id,
                'populasi_ayam_id'  => $pdaa->id,
                'pipe_id'           => $pdaa->pipe->id,
                'flock_id'          => $pdaa->pipe->flock->id,
                'kandang_id'        => $pdaa->pipe->flock->kandang_id,
                'pic_user_id'       => $pdaa->pic_user_id,
                'tanggal'           => $pdaa->tanggal,
                'jumlah_ayam_afkir' => $pdaa->ayam_afkir
            ]);
        });
    }
}
