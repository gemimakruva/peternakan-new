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
            ['id' => 1, 'nama' => 'Lalat'],
            ['id' => 2, 'nama' => 'Gurem'],
            ['id' => 3, 'nama' => 'Umum'],
        ];

        foreach ($data as $item) {
            JenisDisinfektan::updateOrCreate(
                ['id' => $item['id']],
                ['nama' => $item['nama']]
            );
        }
    }
}
