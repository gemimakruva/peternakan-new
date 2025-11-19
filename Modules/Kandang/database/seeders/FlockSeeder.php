<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flock;
use Carbon\Carbon;
use Modules\Kandang\Models\Flock as ModelsFlock;
class FlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flocks = [
            ['nama' => 'Flock 1', 'kapasitas' => 1000],
            ['nama' => 'Flock 2', 'kapasitas' => 950],
            ['nama' => 'Flock 3', 'kapasitas' => 1200],
            ['nama' => 'Flock 4', 'kapasitas' => 800],
            ['nama' => 'Flock 5', 'kapasitas' => 1100],
            ['nama' => 'Flock 6', 'kapasitas' => 1300],
            ['nama' => 'Flock 7', 'kapasitas' => 900],
            ['nama' => 'Flock 8', 'kapasitas' => 1250],
        ];

        foreach ($flocks as $flock) {
            ModelsFlock::create([
                'kandang_id' => rand(1, 10), 
                'nama' => $flock['nama'],
                'kapasitas' => $flock['kapasitas'],
            ]);
        }
    }
}
