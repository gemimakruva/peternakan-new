<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Kandang\Database\Seeders\FlockSeeder;
use Modules\Kandang\Database\Seeders\KandangSeeder;
use Modules\Kandang\Database\Seeders\PengadaanAyamSedeer;
use Modules\Kandang\Database\Seeders\PeternakanSeeder;
use Modules\Kandang\Database\Seeders\StrainSeeder;
use Modules\Kandang\Database\Seeders\StrainStandartMetricSeeder;
use Modules\Kandang\Models\Pengadaan_ayam;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PeternakanSeeder::class,
            StrainSeeder::class,
            KandangSeeder::class,
            StrainStandartMetricSeeder::class,
            FlockSeeder::class,
            PengadaanAyamSedeer::class
        ]);
    }
}
