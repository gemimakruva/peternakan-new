<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\JenisTreatment;

class JenisTreatmentFactory extends Factory
{
    protected $model = JenisTreatment::class;

    public function definition(): array
    {
        // simpan counter nama untuk menghindari duplikat
        static $counter = [];

        $nama = $this->faker->randomElement([
            'Pembersihan Kandang',
            'Penyemprotan Disinfectan',
            'Perawatan Lantai Kandang',
            'Pemberian Vitamin',
            'Pengecekan Kesehatan',
            'Perbaikan Ventilasi',
            'Sterilisasi Kandang',
            'Kontrol Hama',
            'Penggantian Sekam',
            'Cuci Minum Otomatis'
        ]);

        // cek apakah nama sudah pernah keluar
        if (!isset($counter[$nama])) {
            $counter[$nama] = 1;
        } else {
            $counter[$nama]++;
        }

        // jika index lebih dari 1, tambahkan angka di belakangnya
        $namaWithIndex = $counter[$nama] > 1 ? "{$nama} {$counter[$nama]}" : $nama;

        return [
            'nama' => $namaWithIndex,
        ];
    }
}
