<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\PopulasiAyam;

class PopulasiAyamSeeder extends Seeder
{
    public function run(): void
    {
        PopulasiAyam::create([
            'pengadaan_ayam_distribusi_id' => 1,
            'pic_user_id' => 1,
            'kandang_id' => 1,
            'flock_id' => 1,
            'pipe_id' => 1,
            'jenis_pemeriksaan' => 'harian',
            'tanggal' => now()->format('Y-m-d'),
            'ayam_sehat' => 480,
            'ayam_mati' => 2,
            'ayam_afkir' => 0,
            'ayam_masuk_karantina' => 0,
            'ayam_keluar_karantina' => 0,
            'catatan' => 'Pemeriksaan rutin harian berjalan baik.'
        ]);

        PopulasiAyam::create([
            'pengadaan_ayam_distribusi_id' => 1,
            'pic_user_id' => 2,
            'kandang_id' => 2,
            'flock_id' => 2,
            'pipe_id' => 2,
            'jenis_pemeriksaan' => 'kesehatan',
            'tanggal' => now()->subDay()->format('Y-m-d'),
            'ayam_sehat' => 450,
            'ayam_mati' => 5,
            'ayam_afkir' => 1,
            'ayam_masuk_karantina' => 3,
            'ayam_keluar_karantina' => 1,
            'catatan' => 'Ada beberapa ayam batuk ringan.'
        ]);

        PopulasiAyam::create([
            'pengadaan_ayam_distribusi_id' => 2,
            'pic_user_id' => 1,
            'kandang_id' => 3,
            'flock_id' => 3,
            'pipe_id' => 1,
            'jenis_pemeriksaan' => 'karantina',
            'tanggal' => now()->subDays(2)->format('Y-m-d'),
            'ayam_sehat' => 300,
            'ayam_mati' => 1,
            'ayam_afkir' => 2,
            'ayam_masuk_karantina' => 10,
            'ayam_keluar_karantina' => 5,
            'catatan' => 'Pemantauan ayam yang baru masuk kandang.'
        ]);
    }
}
