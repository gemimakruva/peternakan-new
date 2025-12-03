<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\PerhitunganPakan;

class PemberianPakanSisaPakanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'perhitungan_pakan_id' => PerhitunganPakan::inRandomOrder()->value('id') ?? PerhitunganPakan::factory(),
            'pemberian_pakan_flock_kg' => $this->faker->randomFloat(2, 5, 50), 
            'sisa_pakan_per_flock'     => $this->faker->randomFloat(2, 0, 10), 
        ];
    }
}
