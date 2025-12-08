<?php

namespace Modules\Kandang\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Kandang\Database\Seeders\AyamKarantinaSeeder;

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
            AyamKarantinaSeeder::class,
            JenisPakanSeeder::class,

            PerhitunganPakanSeeder::class,

            PemberianPakanSisaPakanSeeder::class,
            JenisDisinfektanSeeder::class,
            JenisTreatmentSeeder::class,
            MetodeTreatmentSeeder::class
        ]);
    }
}
