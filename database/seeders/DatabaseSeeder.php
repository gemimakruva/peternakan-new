<?php

namespace Database\Seeders;
use Modules\Kandang\Database\Seeders\StrainAyamSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Kandang\Database\Seeders\AyamAfkirSeeder;
use Modules\Kandang\Database\Seeders\FlockSeeder;
use Modules\Kandang\Database\Seeders\KandangDatabaseSeeder;
use Modules\Kandang\Database\Seeders\PeternakanSeeder;
use Modules\Kandang\Database\Seeders\PipeSeeder;
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
            StrainAyamSeeder::class,
            KandangDatabaseSeeder::class,
            FlockSeeder::class,
            PipeSeeder::class,
            SupplierLogSeeder::class,
            AyamAfkirSeeder::class,
        ]);
    }
}
