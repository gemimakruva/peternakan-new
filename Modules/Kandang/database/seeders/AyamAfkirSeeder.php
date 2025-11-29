<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\AyamAfkir;
use Illuminate\Support\Carbon;

class AyamAfkirSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            AyamAfkir::create([
                'populasi_ayam_id'  => 1,
                'pic_user_id'       => 1,
                'tanggal'           => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
                'umur_ayam'         => rand(10, 20),
                'jumlah_ayam_afkir' => rand(20, 80),
                'penyebab_afkir'    => 'Produksi telur / bobot menurun',
                'pembeli_afkir'     => fake()->name(), // Random nama pembeli
                'harga_jual'        => rand(20000, 26000),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
