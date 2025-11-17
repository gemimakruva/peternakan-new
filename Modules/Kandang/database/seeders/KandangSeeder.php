<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\Kandang;

class KandangSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk data kandang 1–10.
     */
    public function run(): void
    {
        $kandangs = [
            ['nama' => 'KDG-A1 Produksi Utama', 'alamat' => 'Dusun Ngemplak, Sleman, Yogyakarta'],
            ['nama' => 'KDG-A2 Produksi Utama', 'alamat' => 'Dusun Ngemplak, Sleman, Yogyakarta'],
            ['nama' => 'KDG-B1 Layer Selatan', 'alamat' => 'Jl. Imogiri Timur No. 25, Bantul'],
            ['nama' => 'KDG-B2 Layer Selatan', 'alamat' => 'Jl. Imogiri Timur No. 27, Bantul'],
            ['nama' => 'KDG-C1 Breeding Barat', 'alamat' => 'Jl. Godean KM 5, Sleman'],
            ['nama' => 'KDG-C2 Breeding Barat', 'alamat' => 'Jl. Godean KM 6, Sleman'],
            ['nama' => 'KDG-D1 Grower Timur', 'alamat' => 'Jl. Solo KM 9, Kalasan'],
            ['nama' => 'KDG-D2 Grower Timur', 'alamat' => 'Jl. Solo KM 10, Kalasan'],
            ['nama' => 'KDG-E1 Broiler Utara', 'alamat' => 'Jl. Kaliurang KM 8, Sleman'],
            ['nama' => 'KDG-E2 Broiler Utara', 'alamat' => 'Jl. Kaliurang KM 9, Sleman'],
        ];

        foreach ($kandangs as $kandang) {
            Kandang::create($kandang);
        }
    }
}
