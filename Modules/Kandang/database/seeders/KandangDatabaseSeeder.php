<?php

namespace Modules\Kandang\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Kandang\Database\Seeders\AyamKarantinaSeeder as SeedersAyamKarantinaSeeder;

class KandangDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            PeternakanSeeder::class,
            StrainSeeder::class,
            KandangSeeder::class,
            FlockSeeder::class,
            PengadaanAyamSedeer::class,
            PopulasiAyamSeeder::class,
            AyamAfkirSeeder::class,
            SeedersAyamKarantinaSeeder::class
        ]);
    }
}
