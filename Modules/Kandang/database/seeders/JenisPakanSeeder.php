<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\JenisPakan;

class JenisPakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisPakan::insert([
            ['nama' => 'Pakan Starter'],
            ['nama' => 'Pakan Grower'],
            ['nama' => 'Pakan Finisher'],
            ['nama' => 'Pakan Layer'],
            ['nama' => 'Pakan Konsentrat'],
            ['nama' => 'Pakan Protein Tinggi'],
            ['nama' => 'Pakan Jagung Giling'],
            ['nama' => 'Pakan Bekatul'],
            ['nama' => 'Pakan Fermentasi'],
            ['nama' => 'Pakan Organik']
        ]);
    }

}
