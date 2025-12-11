<?php

namespace Modules\Kandang\Database\Seeders;


use Illuminate\Database\Seeder;
use Modules\Kandang\Models\PenjadwalanTreatmentFlock;

class penjadwalanTreatmentFlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PenjadwalanTreatmentFlock::factory()->count(10)->create();
    }
}
