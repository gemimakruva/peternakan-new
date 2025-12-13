<?php

namespace Modules\Kandang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Kandang\Models\Flock;
use Modules\Kandang\Models\JenisTreatment;
use Modules\Kandang\Models\MetodeTreatment;
use Modules\Kandang\Models\PenjadwalanTreatment;
use Modules\Kandang\Models\PenjadwalanTreatmentFlock;

class penjadwalanTreatmentFlockFactory extends Factory
{
    protected $model = PenjadwalanTreatmentFlock::class;

    public function definition(): array
    {
        return [
              'penjadwalan_treatment_id' => PenjadwalanTreatment::inRandomOrder()->first()->id,
            'flock_id'                 => Flock::inRandomOrder()->first()->id,
            'jenis_treatment_id'       => JenisTreatment::inRandomOrder()->first()->id,
            'metode_treatment_id'      => MetodeTreatment::inRandomOrder()->first()->id,
            'dosis_pemberian'          => $this->faker->randomFloat(2, 0.1, 5.0), 
        ];
    }
}
