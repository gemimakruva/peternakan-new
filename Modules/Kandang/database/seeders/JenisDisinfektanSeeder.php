<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\JenisDisinfektan;

class JenisDisinfektanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // JenisDisinfektan::factory()->count(10)->create();

        $data = [
            ['id' => 1, 'nama' => 'Disinfektan'],
            ['id' => 2, 'nama' => 'Vaksin'],
            ['id' => 3, 'nama' => 'Vitamin dan/atau Mineral'],
            ['id' => 4, 'nama' => 'Antibiotik dan Obat']
        ];

        foreach ($data as $item) {
            JenisDisinfektan::updateOrCreate(
                ['id' => $item['id']],
                ['nama' => $item['nama']]
            );
        }
    }
}
