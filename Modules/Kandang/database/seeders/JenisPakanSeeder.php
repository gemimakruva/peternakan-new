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
            ['id' => 1, 'nama' => 'Pakan Layer'],
            ['id' => 2, 'nama' => 'Pakan Pre-Layer'],
            ['id' => 3, 'nama' => 'Pakan Grower'],
        ];

        foreach ($data as $item) {
            JenisPakan::updateOrCreate(
                ['id' => $item['id']],
                ['nama' => $item['nama']]
            );
        }
    }

}
