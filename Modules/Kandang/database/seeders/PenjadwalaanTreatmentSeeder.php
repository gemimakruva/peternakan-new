<?php

namespace Modules\Kandang\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Kandang\Models\PenjadwalanTreatment;

class PenjadwalaanTreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PenjadwalanTreatment::factory()->count(10)->create();
    }
}
