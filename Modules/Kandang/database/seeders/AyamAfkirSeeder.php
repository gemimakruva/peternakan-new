<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\AyamAfkir;
use Illuminate\Support\Carbon;
use Modules\Kandang\Models\PopulasiAyam;

class AyamAfkirSeeder extends Seeder
{
    public function run(): void
    {
        $populasiDenganAyamAfkir = PopulasiAyam::where('ayam_afkir', '>', 0)->get();
        $populasiDenganAyamAfkir->map(function($pdaa) {
            AyamAfkir::firstOrCreate([
                'populasi_ayam_id'  => $pdaa->id,
                'pic_user_id'       => $pdaa->pic_user_id,
                'tanggal'           => $pdaa->tanggal,
                'umur_ayam'         => $pdaa->umur_ayam_record,
                'jumlah_ayam_afkir' => $pdaa->ayam_afkir,
                'penyebab_afkir'    => 'Produksi telur / bobot menurun',
            ], [
                'pembeli_afkir'     => fake()->name(), // Random nama pembeli
                'harga_jual'        => rand(40, 52) * 500,
            ]);
        });
    }
}
