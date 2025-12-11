<?php

namespace Modules\Kandang\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PenjadwalanTreatment;

class PenjadwalanTreatmentFactor extends Factory
{
    // Hubungkan factory dengan model
    protected $model = PenjadwalanTreatment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kandang_id'   => Kandang::inRandomOrder()->first()->id,
            'pic_user_id'  => User::inRandomOrder()->first()->id,
            'tanggal'      => $this->faker->date(),
            'detail_waktu' => $this->faker->time(),
        ];
    }
}
