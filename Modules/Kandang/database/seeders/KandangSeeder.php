<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Kandang;

class KandangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['peternakan_id' => 1, 'strain_id' => 1, 'nama' => 'Kandang Unit 1'],
            ['peternakan_id' => 1, 'strain_id' => 2, 'nama' => 'Kandang Unit 2'],
            ['peternakan_id' => 1, 'strain_id' => 3, 'nama' => 'Kandang Unit 3'],
        ];
        Kandang::insert($data);
    }
}
