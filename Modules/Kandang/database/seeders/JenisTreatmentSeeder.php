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
        $data = [
            ['id' => 1, 'nama' => 'Disinfektan'],
            ['id' => 2, 'nama' => 'Vaksin'],
            ['id' => 3, 'nama' => 'Vitamin dan/atau Mineral'],
            ['id' => 4, 'nama' => 'Antibiotik dan Obat']
        ];

        foreach ($data as $item) {
            JenisTreatment::updateOrCreate(
                ['id' => $item['id']],
                ['nama' => $item['nama']]
            );
        }
    }
}
