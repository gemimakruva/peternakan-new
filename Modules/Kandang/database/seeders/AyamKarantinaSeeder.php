<?php
namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Services\PopulasiAyamService;

class AyamKarantinaSeeder extends Seeder
{
    public function run(): void
    {
        PopulasiAyam::query()
            ->get()
            ->each(function($item) {
                app(PopulasiAyamService::class)->saveAyamKarantina($item);
            });
    }
}
