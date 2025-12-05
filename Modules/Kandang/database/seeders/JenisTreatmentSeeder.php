<?php

namespace Modules\Kandang\Database\Seeders;

use Modules\Kandang\Models\JenisTreatment;
use Illuminate\Database\Seeder;

class JenisTreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisTreatment::factory()->count(10)->create();
    }
}
