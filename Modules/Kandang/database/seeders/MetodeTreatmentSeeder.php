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
            ['id' => 1, 'nama' => 'Semprot'],
            ['id' => 2, 'nama' => 'Pakan'],
            ['id' => 3, 'nama' => 'Minum'],
            ['id' => 4, 'nama' => 'Suntik'],
        ];

        foreach ($data as $item) {
            MetodeTreatment::updateOrCreate(
                ['id' => $item['id']],
                ['nama' => $item['nama']]
            );
        }
    }
}
