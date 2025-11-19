<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Kandang\Database\Seeders\AyamAfkirSeeder;
use Modules\Kandang\Database\Seeders\FlockSeeder;
use Modules\Kandang\Database\Seeders\KandangDatabaseSeeder;
use Modules\Kandang\Database\Seeders\KandangSeeder;
use Modules\Kandang\Database\Seeders\PeternakanSeeder;
use Modules\Kandang\Database\Seeders\PipeSeeder;
use Modules\Kandang\Database\Seeders\StrainSeeder;
use Modules\Kandang\Database\Seeders\StrainStandartMetricSeeder;
use Modules\Kandang\Database\Seeders\SupplierLogSeeder;

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
        ]);
    }
}
