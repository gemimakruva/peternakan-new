<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\OvkPakan;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Flock;

class OvkPakanFactory extends Factory
{
    protected $model = OvkPakan::class;

    public function definition(): array
    {
        $totalPakan = $this->faker->randomFloat(2, 100, 500);

        return [
             'tanggal' => $this->faker->date(),
            'kandang_id' => Kandang::inRandomOrder()->first()->id ?? 1,
            'flock_id' => Flock::inRandomOrder()->first()->id ?? 1,    
            'merk_ovk' => $this->faker->word(),
            'Dosis_OVK' => $this->faker->randomFloat(2, 1, 50),
            'total_kebutuhan_pakan' => $this->faker->randomFloat(2, 10, 100),
            'waktu_pemberian_pakan' => $this->faker->randomElement(['pagi', 'sore']), // string
            'proposi_pemberian_pagi' => $this->faker->randomFloat(2, 0, 100),
            'proposi_pemberian_sore' => $this->faker->randomFloat(2, 0, 100),
            'perhitungan_kebutuhan_pakan_pagi' => $this->faker->randomFloat(2, 0, 50),
            'perhitungan_kebutuhan_pakan_sore' => $this->faker->randomFloat(2, 0, 50),
            'perhitungan_kebutuhan_ovk' => $this->faker->randomFloat(2, 0, 50),
        ];
    }
}
