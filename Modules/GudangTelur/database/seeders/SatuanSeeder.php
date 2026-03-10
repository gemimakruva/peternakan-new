<?php

namespace Modules\GudangTelur\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GudangTelur\Models\Satuan;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ['id' => 1, 'nama' => 'Ikat'],
            ['id' => 2, 'nama' => 'Pack'],
            ['id' => 3, 'nama' => 'Dus'],
            ['id' => 4, 'nama' => 'Piece'],
            ['id' => 5, 'nama' => 'Kg', 'konversi_satuan' => 1000], // jadikan gram
            ['id' => 6, 'nama' => 'Gram', 'konversi_satuan' => 1],
        ];
        foreach ($datas as $data) {
            Satuan::firstOrCreate($data);
        }
    }
}
