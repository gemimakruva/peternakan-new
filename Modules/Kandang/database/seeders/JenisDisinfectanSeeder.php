<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\JenisDisinfectan;

class JenisDisinfectanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisDisinfectan::factory()->count(10)->create();
    }
}
