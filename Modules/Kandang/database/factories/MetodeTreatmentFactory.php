<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\MetodeTreatment;

class MetodeTreatmentFactory extends Factory
{
    protected $model = MetodeTreatment::class;

    public function definition(): array
    {
        // counter untuk menghindari nama duplikat
        static $counter = [];

        $nama = $this->faker->randomElement([
            'Spray Treatment',
            'Fogging Treatment',
            'Soak Treatment',
            'Hand Sanitizing',
            'Surface Wiping',
            'Chemical Dipping',
            'Heat Sterilizing',
            'Automatic Sprayer',
            'Manual Scrubbing',
            'Disinfectant Fogging'
        ]);

        if (!isset($counter[$nama])) {
            $counter[$nama] = 1;
        } else {
            $counter[$nama]++;
        }

        $namaWithIndex = $counter[$nama] > 1 ? "{$nama} {$counter[$nama]}" : $nama;

        return [
            'nama' => $namaWithIndex,
        ];
    }
}
