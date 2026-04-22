<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Strain;

class KandangSeeder extends Seeder
{
    public function run(): void
    {
        $isaStrainId = Strain::where('nama', 'Isa')->value('id');
        $datas = [
            ['peternakan_id' => 1, 'strain_id' => $isaStrainId, 'nama' => 'Tamago Batch 1'],
        ];
        foreach ($datas as $data) {
            Kandang::firstOrCreate($data);
        }
    }
}
