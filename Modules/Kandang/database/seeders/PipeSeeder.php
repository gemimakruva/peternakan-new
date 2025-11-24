<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Pipe;

class PipeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['flock_id' => 1, 'nama' => 'Pipe A', 'kapasitas' => 500],
        ];
        Pipe::insert($data);
    }
}
