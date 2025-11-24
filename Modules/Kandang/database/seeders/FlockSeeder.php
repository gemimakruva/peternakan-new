<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Pipe;

class FlockSeeder extends Seeder
{
    public function run(): void
    {
        $pipesPerKandang = [
            1 => 2, 
            2 => 3, 
            3 => 4, 
        ];

        $totalFlocks = 15;

        foreach ($pipesPerKandang as $kandangId => $jumlahPipe) {

            for ($i = 1; $i <= $totalFlocks; $i++) {

                // Buat flock
                $flock = Flock::create([
                    'kandang_id' => $kandangId,
                    'nama'       => "Kandang {$kandangId} Flock {$i}",
                    'kapasitas'  => 0,
                ]);

                // Buat pipe per flock sesuai aturan kandang
                for ($p = 1; $p <= $jumlahPipe; $p++) {
                    Pipe::create([
                        'flock_id'  => $flock->id,
                        'nama'      => "Flock {$i} Pipe {$p}",
                        'kapasitas' => 20,
                    ]);
                }
            }
        }
    }
}
