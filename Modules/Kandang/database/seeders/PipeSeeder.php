<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Pipe;

class PipeSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil flock 1-5
        $flocks = Flock::whereIn('id', [1,2,3,4,5])->get();

        foreach ($flocks as $flock) {
            $pipeCount = $flock->pipe_count ?? 1; // default 1 jika null
            $totalCapacity = $flock->total_capacity ?? 1000; // default 1000 jika null
            $remaining = $totalCapacity;

            for ($i = 1; $i <= $pipeCount; $i++) {
                // Jika ini pipe terakhir, masukkan sisa total kapasitas
                if ($i == $pipeCount) {
                    $initialPopulation = $remaining;
                } else {
                    // Bagi populasi awal secara acak tapi jangan melebihi sisa
                    $initialPopulation = rand( floor($totalCapacity / ($pipeCount*2)), floor($remaining / ($pipeCount - $i + 1)) );
                    $remaining -= $initialPopulation;
                }

                Pipe::create([
                    'flock_id' => $flock->id,
                    'pipe_name' => "Pipe $i {$flock->flock_name}",
                    'capacity' => intval($totalCapacity / $pipeCount),
                    'initial_population' => $initialPopulation,
                ]);
            }
        }
    }
}
