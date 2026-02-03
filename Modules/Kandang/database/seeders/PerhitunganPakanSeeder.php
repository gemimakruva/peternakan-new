<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Models\PerhitunganPakanItem;
use Modules\Kandang\Models\PopulasiAyam;

class PerhitunganPakanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PopulasiAyam::orderBy('tanggal', 'asc')->get()->each(function(PopulasiAyam $item) {
            $perhitunganPakan = PerhitunganPakan::firstOrCreate([
                'tanggal_pemberian_pakan'   => $item->tanggal,
                'umur_ayam'                 => $item->umur_ayam_record,
                'kandang_id'                => $item->kandang_id,
            ], [
                'user_creator_id'           => 1,
                'user_executor_id'          => 3,
                'jenis_pakan_id'            => 2,
                'proporsi_pemberian_pagi'   => 40,
                'proporsi_pemberian_sore'   => 60,
                'waktu_pemberian_pagi'      => '09:00',
                'waktu_pemberian_sore'      => '15:00',
                'catatan'                   => 'dummy data',
            ]);

            PerhitunganPakanItem::firstOrCreate([
                'perhitungan_pakan_id'      => $perhitunganPakan->id,
                'kandang_id'                => $item->kandang_id,
                'flock_id'                  => $item->flock_id,
                'pipe_id'                   => $item->pipe_id,
                'tanggal_pemberian_pakan'   => $item->tanggal,
            ], [
                'jumlah_ayam'               => $item->ayam_sehat,
                'pemberian_pakan_per_ekor'  => 80// gram
            ]);
        });
    }
}
