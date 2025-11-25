<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\PengadaanAyamDistribusi;
use Modules\Kandang\Models\Pengadaan_ayam;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\Pipe;

class PengadaanAyamDistribusiSeeder extends Seeder
{
    public function run(): void
    {
        // ambil ID dari tabel referensi
        $pengadaanIds = Pengadaan_ayam::pluck('id')->toArray();
        $kandangIds = Kandang::pluck('id')->toArray();
        $flockIds = Flock::pluck('id')->toArray();
        $pipeIds = Pipe::pluck('id')->toArray();

        if (empty($pengadaanIds) || empty($kandangIds) || empty($flockIds) || empty($pipeIds)) {
            dd("Pastikan tabel pengadaan_ayam, kandang, flock, dan pipe sudah ada datanya!");
        }

        $totalSeeder = 3;

        for ($i = 0; $i < $totalSeeder; $i++) {
            PengadaanAyamDistribusi::create([
                'pengadaan_ayam_id' => $pengadaanIds[array_rand($pengadaanIds)],
                'kandang_id' => $kandangIds[array_rand($kandangIds)],
                'flock_id' => $flockIds[array_rand($flockIds)],
                'pipe_id' => $pipeIds[array_rand($pipeIds)],
                'jumlah_ayam' => rand(50, 200),
            ]);
        }

        echo "Seeder pengadaan_ayam_distribusi berhasil dijalankan!";
    }
}
