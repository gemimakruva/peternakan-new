<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\JenisDisinfectan;

class JenisDisinfectanFactory extends Factory
{
    protected $model = JenisDisinfectan::class;

    public function definition(): array
    {
        // Counter static untuk mendeteksi duplikasi
        static $counter = [];

        $nama = $this->faker->randomElement([
            'Dettol',
            'Virkon S',
            'Formalin',
            'Lysol',
            'Biosafe',
            'Anolyte',
            'SeptiClean',
            'Microgen',
            'Chloroxy',
            'Neo Antisept',
        ]);

        // Jika nama sudah pernah muncul → tambahkan angka index
        if (!isset($counter[$nama])) {
            $counter[$nama] = 1;
        } else {
            $counter[$nama]++;
        }

        $namaWithIndex = $counter[$nama] > 1 
            ? "{$nama} {$counter[$nama]}"
            : $nama;

        return [
            'nama' => $namaWithIndex,
        ];
    }
}
