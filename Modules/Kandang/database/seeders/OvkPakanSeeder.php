<?php

namespace Modules\Kandang\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Kandang\Models\OvkPakan;
class OvkPakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          OvkPakan::factory()->count(10)->create();
    }
}
