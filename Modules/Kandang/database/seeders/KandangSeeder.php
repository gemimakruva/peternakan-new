<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Kandang;

class KandangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Peternakan 1
            ['peternakan_id' => 1, 'strain_id' => 1, 'nama' => 'Kandang 1-1'],
            ['peternakan_id' => 1, 'strain_id' => 2, 'nama' => 'Kandang 1-2'],
            ['peternakan_id' => 1, 'strain_id' => 3, 'nama' => 'Kandang 1-3'],
            ['peternakan_id' => 1, 'strain_id' => 4, 'nama' => 'Kandang 1-4'],
            ['peternakan_id' => 1, 'strain_id' => 5, 'nama' => 'Kandang 1-5'],

            // Peternakan 2
            ['peternakan_id' => 2, 'strain_id' => 1, 'nama' => 'Kandang 2-1'],
            ['peternakan_id' => 2, 'strain_id' => 2, 'nama' => 'Kandang 2-2'],
            ['peternakan_id' => 2, 'strain_id' => 3, 'nama' => 'Kandang 2-3'],
            ['peternakan_id' => 2, 'strain_id' => 4, 'nama' => 'Kandang 2-4'],
            ['peternakan_id' => 2, 'strain_id' => 5, 'nama' => 'Kandang 2-5']

        ];

        Kandang::insert($data);
    }
}
