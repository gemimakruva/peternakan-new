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
            ['flock_name' => 'Flock 1', 'date_in' => '2025-01-10', 'capacity' => 1000],
            ['flock_name' => 'Flock 2', 'date_in' => '2025-01-25', 'capacity' => 950],
            ['flock_name' => 'Flock 3', 'date_in' => '2025-02-10', 'capacity' => 1200],
            ['flock_name' => 'Flock 4', 'date_in' => '2025-02-20', 'capacity' => 800],
            ['flock_name' => 'Flock 5', 'date_in' => '2025-03-05', 'capacity' => 1100],
            ['flock_name' => 'Flock 6', 'date_in' => '2025-03-25', 'capacity' => 1300],
            ['flock_name' => 'Flock 7', 'date_in' => '2025-04-10', 'capacity' => 900],
            ['flock_name' => 'Flock 8', 'date_in' => '2025-04-30', 'capacity' => 1250],
        ];

        foreach ($flocks as $flock) {
            ModelsFlock::create([
                'kandang_id' => rand(1, 10), // acak antara kandang id 1 sampai 10
                'flock_name' => $flock['flock_name'],
                'date_in' => Carbon::parse($flock['date_in']),
                'capacity' => $flock['capacity'],
            ]);
        }
    }
}
