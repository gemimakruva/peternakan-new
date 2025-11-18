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
            [
                'nama'      => 'Peternakan Surya Farm',
                'lokasi'    => 'Jl. Raya Imogiri Timur No. 22, Bantul',
            ],
            [
                'nama'      => 'Peternakan Kencana Abadi',
                'lokasi'    => 'Dusun Karangmojo, Gunungkidul',

            ],
            [
                'nama'      => 'Peternakan Maju Makmur',
                'lokasi'    => 'Jl. Palagan Tentara Pelajar No. 55, Sleman',
            ],
            [
                'nama'      => 'Peternakan Barokah Jaya',
                'lokasi'    => 'Jl. Magelang KM 10, Tempel, Sleman',
            ],
        ];

        foreach ($data as $item) {
            Peternakan::create($item);
        }
    }
}
