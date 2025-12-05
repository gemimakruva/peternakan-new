<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JenisPakanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'nama' => fake()->randomElement([
                'Virocid',
                'Rodalon',
                'Formades',
                'Biosafe',
                'Neo Antis',
                'Medisept',
                'Germicidal Plus',
            ]),
        ];
    }
}
