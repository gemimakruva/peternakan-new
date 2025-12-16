<?php

namespace Modules\Kandang\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Kandang\Models\FormRequestOrderOvk;
 
class FormRequestOvkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormRequestOrderOvk::factory(10)->create();
    }
}
