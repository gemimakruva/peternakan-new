<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\MetodeTreatment;

class MetodeTreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            ['id' => 1, 'nama' => 'Pakan'],
            ['id' => 2, 'nama' => 'Minum'],
            ['id' => 3, 'nama' => 'Semprot'],
            ['id' => 4, 'nama' => 'Cekok'],
            ['id' => 5, 'nama' => 'Suntik (Intramuskular)'],
            ['id' => 6, 'nama' => 'Suntik (Subkutan)'],
        ];

        foreach ($data as $item) {
            MetodeTreatment::updateOrCreate(
                ['id' => $item['id']],
                ['nama' => $item['nama']]
            );
        }
    }
}
