<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\SamplingBobotAyam;
use Modules\Kandang\Services\PopulasiAyamService;

class SamplingBobotAyamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // sampling ayam dilakukan h+10 pengadaan
        $listkandang = Kandang::get();
        $tanggal = Carbon::createFromFormat('Y-m-d', '2025-01-10');

        $rangeBobot = [
            1 => [1.169, 1.241],
            2 => [1.151, 1.210],
            3 => [1.206, 1.275],
        ];

        foreach ($listkandang as $kandang) {
            $samplingBobotAyam = SamplingBobotAyam::create([
                'pencatat_user_id'              => 1,
                'tanggal'                       => $tanggal,
                'kandang_id'                    => $kandang->id,
                'umur'                          => app(PopulasiAyamService::class)->getUmurAyamByKandangId($kandang->id, $tanggal)['umur_ayam'],
                'jumlah_ayam_saat_ini'          => app(PopulasiAyamService::class)->getCurrentAyamSehatByKandang($kandang->id, $tanggal),
                'jumlah_ayam_yang_disampling'   => 50,
            ]);
            for ($i=0; $i < 50; $i++) { 
                $samplings[] = [
                    'sampling_bobot_ayam_id'    => $samplingBobotAyam->id,
                    'bobot_per_kg'              => fake()->randomFloat(3, $rangeBobot[$kandang->id][0] - 0.2, $rangeBobot[$kandang->id][1] + 0.2),
                ];
            }
            $samplingBobotAyam->samplingBobotAyamPerEkor()->insert($samplings);
            $samplings = [];
        }
    }
}