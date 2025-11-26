<?php

namespace Modules\Kandang\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Pengadaan_ayam;

class PengadaanAyamSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'pic_user_id' => 1,
                'tanggal' => '2024-01-15',
                'umur_ayam' => 20,
                'kondisi_ayam' => 'Sehat',
                'jumlah_ayam_datang' => 1,
                'jumlah_ayam_mati' => 0,
                'jumlah_ayam_sakit' => 0,
                'jumlah_ayam_masuk_kandang' => 1000,
                'catatan' => 'Pengadaan ayam DOC untuk pengisian kandang unit'
            ]
        ];  
        foreach ($data as $item) {
            Pengadaan_ayam::create($item);
        }
    }
}
