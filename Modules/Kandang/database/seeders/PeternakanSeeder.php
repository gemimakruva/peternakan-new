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
                'nama'      => 'Peternakan Ayam Sejahtera',
                'lokasi'    => 'Jl. Wates KM 7, Gamping, Sleman',
            ],
        ];

        foreach ($data as $item) {
            Peternakan::create($item);
        }
    }
}
