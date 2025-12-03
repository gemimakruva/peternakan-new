<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\PemberianPakanSisaPakan;


class PemberianPakanSisaPakanSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 30 data dummy menggunakan Factory
        PemberianPakanSisaPakan::factory()->count(30)->create();
    }
}
