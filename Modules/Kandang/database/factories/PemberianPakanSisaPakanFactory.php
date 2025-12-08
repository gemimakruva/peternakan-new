<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\JenisPakan;
use Modules\Kandang\Models\PemberianPakanSisaPakan;
use Modules\Kandang\Models\PerhitunganPakan;

class PemberianPakanSisaPakanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        protected $model = PemberianPakanSisaPakan::class;
        
     public function definition()
    {
        return [
             // flock id
             'flock_id' => Flock::inRandomOrder()->first()->id ?? Flock::factory(), 
            // jenis_pakan id
               'jenis_pakan_id' => JenisPakan::inRandomOrder()->first()->id ?? JenisPakan::factory(), 
            // tanggal
            'tanggal' => $this->faker->date(),
            'pemberian_pakan_flock_kg' => $this->faker->randomFloat(2, 5, 20),
            'sisa_pakan_per_flock_kg' => $this->faker->randomFloat(2, 0, 5),
        ];
    }
}
