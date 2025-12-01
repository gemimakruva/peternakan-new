<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenisPakan>
 */
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
            'nama' => $this->faker->randomElement([
                'Pakan Starter',
                'Pakan Grower',
                'Pakan Finisher',
                'Pakan Layer',
                'Pakan Herbal',
                'Pakan Fermentasi'
            ]),
        ];
    }
}
