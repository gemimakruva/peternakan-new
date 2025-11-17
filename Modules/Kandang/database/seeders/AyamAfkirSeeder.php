<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\AyamAfkir;

class AyamAfkirSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'tanggal_afkir' => '2025-01-10',
                'kandang_id' => 1,
                'flock_id' => 1,
                'pipe_id' => 1,
                'umur_ayam' => 420,
                'jumlah_ayam_afkir' => 50,
                'penyebab_afkir' => 'Produksi menurun',
                'nama_pembeli' => 'Pak Budi',
                'harga_jual_per_kg' => 23000,
            ],
            [
                'tanggal_afkir' => '2025-01-11',
                'kandang_id' => 2,
                'flock_id' => 2,
                'pipe_id' => 2,
                'umur_ayam' => 415,
                'jumlah_ayam_afkir' => 40,
                'penyebab_afkir' => 'Ayam kurus',
                'nama_pembeli' => 'Bu Siti',
                'harga_jual_per_kg' => 22500,
            ],
            [
                'tanggal_afkir' => '2025-01-12',
                'kandang_id' => 3,
                'flock_id' => 3,
                'pipe_id' => 3,
                'umur_ayam' => 430,
                'jumlah_ayam_afkir' => 60,
                'penyebab_afkir' => 'Usia terlalu tua',
                'nama_pembeli' => 'Pak Andi',
                'harga_jual_per_kg' => 24000,
            ],
            [
                'tanggal_afkir' => '2025-01-13',
                'kandang_id' => 4,
                'flock_id' => 4,
                'pipe_id' => 4,
                'umur_ayam' => 410,
                'jumlah_ayam_afkir' => 55,
                'penyebab_afkir' => 'Cedera sayap',
                'nama_pembeli' => 'CV Maju Jaya',
                'harga_jual_per_kg' => 23500,
            ],
            [
                'tanggal_afkir' => '2025-01-14',
                'kandang_id' => 5,
                'flock_id' => 5,
                'pipe_id' => 5,
                'umur_ayam' => 425,
                'jumlah_ayam_afkir' => 52,
                'penyebab_afkir' => 'Tidak layak produksi',
                'nama_pembeli' => 'UD Berkah',
                'harga_jual_per_kg' => 22000,
            ]
        ];

        foreach ($data as $item) {
            AyamAfkir::create($item);
        }
    }
}
