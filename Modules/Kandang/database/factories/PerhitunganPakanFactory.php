<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\JenisPakan;
use Modules\Kandang\Models\PerhitunganPakan;
use App\Models\User;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\Pipe;

class PerhitunganPakanFactory extends Factory
{
    protected $model = PerhitunganPakan::class;

    public function definition(): array
    {
        return [
            'tanggal_pemberian_pakan' => $this->faker->date(),
            'user_creator_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'user_executor_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'jenis_pakan_id' => JenisPakan::inRandomOrder()->first()->id ?? JenisPakan::factory(),
            'pipe_id' => Pipe::inRandomOrder()->first()->id ?? Pipe::factory(),
            'proporsi_pemberian_pagi' => $this->faker->randomFloat(2, 0, 1),
            'proporsi_pemberian_sore' => $this->faker->randomFloat(2, 0, 1),
            'waktu_pemberian_pagi' => $this->faker->time('H:i:s', '11:00:00'),
            'waktu_pemberian_sore' => $this->faker->time('H:i:s', '20:00:00'),
            'jumlah_ayam_per_pipe' => $this->faker->numberBetween(50, 200),
            'jumlah_pakan_per_ekor_gram' => $this->faker->randomFloat(2, 10, 100),
            'catatan' => $this->faker->sentence(),
        ];
    }
}
