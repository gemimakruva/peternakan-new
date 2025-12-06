<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulasiAyamDistribusi extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            DB::table('pengadaan_ayam_distribusi')->insert([
                'pengadaan_ayam_id' => rand(1, 5),
                'kandang_id'        => rand(1, 3),
                'flock_id'          => rand(1, 5),
                'pipe_id'           => rand(1, 10),
                'jumlah_ayam'       => rand(800, 2000),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
