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
         $data = [
            ['id' => 1, 'nama' => 'Pakan Starter'],
            ['id' => 2, 'nama' => 'Pakan Grower'],
            ['id' => 3, 'nama' => 'Pakan Finisher'],
            ['id' => 4, 'nama' => 'Pakan Pre-Layer'],
            ['id' => 5, 'nama' => 'Pakan Layer'],
            ['id' => 6, 'nama' => 'Pakan Breeder'],
            ['id' => 7, 'nama' => 'Pakan Konsentrat'],
            ['id' => 8, 'nama' => 'Pakan Crumble'],
            ['id' => 9, 'nama' => 'Pakan Mash'],
            ['id' => 10, 'nama' => 'Pakan Pellet'],
            ['id' => 11, 'nama' => 'Pakan Organik / Herbal'],
            ['id' => 12, 'nama' => 'Pakan Medicated (mengandung obat)'],
            ['id' => 13, 'nama' => 'Pakan Alternatif (jagung giling, dedak, bekatul, dll)']
        ];

        foreach ($data as $item) {
            JenisPakan::updateOrCreate(
                ['id' => $item['id']],
                ['nama' => $item['nama']]
            );
        }
    }

}
