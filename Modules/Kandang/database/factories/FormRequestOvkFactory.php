<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\FormRequestOrderOvk;
use Modules\Kandang\Models\Kandang;

class FormRequestOvkFactory extends Factory
{
    protected $model = FormRequestOrderOvk::class;

    public function definition(): array
    {
        return [
            'kandang_id' => Kandang::inRandomOrder()->value('id'),
            'tanggal' => $this->faker->date(),
            'jenis_ovk' => $this->faker->randomElement(['Vitamin', 'Antibiotik', 'Vaksin']),
            'merk_ovk' => $this->faker->company(),
            'kemasan_ovk' => $this->faker->randomElement(['Botol', 'Sachet', 'Box']),
            'total_kebutuhan_yang_diorder' => $this->faker->numberBetween(1, 100),
            'maksimal_kedatangan' => $this->faker->dateTimeBetween('now', '+2 weeks')->format('Y-m-d'),
        ];
    }
}
