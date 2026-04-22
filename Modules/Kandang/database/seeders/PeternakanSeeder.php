<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Peternakan;

class PeternakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama'      => 'PT TAMA AGRO FARM',
                'lokasi'    => 'Surodadi RT 004/RW 048, Wukirsari, Cangkringan, Sleman',
            ],
        ];

        foreach ($data as $item) {
            Peternakan::firstOrCreate($item);
        }
    }
}
