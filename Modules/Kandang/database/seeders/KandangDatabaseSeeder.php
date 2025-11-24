<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;

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
            PengadaanAyamSedeer::class
        ]);
    }
}
