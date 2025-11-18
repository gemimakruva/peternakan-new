<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('strain')->insert([
            [
                'id'         => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
