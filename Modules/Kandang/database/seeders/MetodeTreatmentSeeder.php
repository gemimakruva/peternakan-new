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
            ['id' => 3, 'nama' => 'Suntik'],
            ['id' => 4, 'nama' => 'Semprot'],
        ];

        foreach ($data as $item) {
            MetodeTreatment::updateOrCreate(
                ['id' => $item['id']],
                ['nama' => $item['nama']]
            );
        }
    }
}
