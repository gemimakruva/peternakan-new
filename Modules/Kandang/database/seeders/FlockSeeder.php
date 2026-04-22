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
            1 => 3, 
        ];

        $totalFlocks = 4;

        foreach ($pipesPerKandang as $kandangId => $jumlahPipe) {

            $flockNum = 1;
            for ($i = 0; $i < $totalFlocks; $i++) {

                // Buat flock
                $flockNum = str_pad($flockNum, 2, '0', STR_PAD_LEFT);
                $flock = Flock::firstOrCreate([
                    'kandang_id' => $kandangId,
                    'nama'       => "Flock {$flockNum}",
                ]);

                $abc = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                // Buat pipe per flock sesuai aturan kandang
                for ($p = 1; $p <= $jumlahPipe; $p++) {
                    $pipeName = $abc[$i].$p;
                    Pipe::firstOrCreate([
                        'flock_id'  => $flock->id,
                        'nama'      => "Pipa {$pipeName}",
                        'kapasitas' => 252,
                    ]);
                }
                $flockNum++;
            }
        }
    }
}
