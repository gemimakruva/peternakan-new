<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Modules\Kandang\Models\PengadaanAyam;
use Modules\Kandang\Models\PopulasiAyam;

class PopulasiAyamSeeder extends Seeder
{
    public function run(): void
    {
        $tanggal = Carbon::createFromFormat('Y-m-d', '2025-10-01'); // tanggal pengadaan ayam
        $tanggalTambahHari = 1;
        $pengadaanAyam = PengadaanAyam::first();

        for ($i=0; $i < 30; $i++) { 
            $pengadaanAyam->distribusi->map(function($distribusi) use($tanggal, $tanggalTambahHari, $pengadaanAyam) {
                $ayamSehat = PopulasiAyam::getAyamSehatTerakhir($distribusi->pipe_id) ?? $distribusi->jumlah_ayam;
                $tanggalPencatatan = $tanggal->clone()->addDays($tanggalTambahHari);
                $hari = $tanggalPencatatan->format('l');
                $tanggalDMY = $tanggalPencatatan->format('d-m-Y');

                $populasi = [
                    'ayam_sehat' => $ayamSehat,
                    'ayam_mati' => 0,
                    'ayam_afkir' => 0,
                    'ayam_masuk_karantina' => 0,
                    'ayam_keluar_karantina' => 0,
                ];

                if ($hari === 'Friday') { // tiap hari jumat ayam mati 1
                    $populasi['ayam_sehat'] = $ayamSehat - 1;
                    $populasi['ayam_mati'] = 1;
                } else if ($hari === 'Saturday') { // tiap hari sabtu ayam afkir 2
                    $populasi['ayam_sehat'] = $ayamSehat - 2;
                    $populasi['ayam_afkir'] = 2;
                } else if ($hari === 'Sunday') { // tiap hari minggu ayam masuk karantina 3
                    $populasi['ayam_sehat'] = $ayamSehat - 3;
                    $populasi['ayam_masuk_karantina'] = 3;
                } else if ($hari === 'Tuesday') { // tiap hari senin ayam masuk karantina 3
                    $populasi['ayam_sehat'] = $ayamSehat + 3;
                    $populasi['ayam_keluar_karantina'] = 3;
                }

                echo "pencatatan hari $hari tanggal $tanggalDMY pipe id - $distribusi->pipe_id" . PHP_EOL;

                PopulasiAyam::create([
                    'pengadaan_ayam_distribusi_id' => $distribusi->id,
                    'pic_user_id' => 1,
                    'pipe_id' => $distribusi->pipe_id,
                    'umur_ayam_record' => $pengadaanAyam->getUmurAyam($tanggalPencatatan),
                    'jenis_pemeriksaan' => 'harian',
                    'tanggal' => $tanggalPencatatan,
                    'catatan' => 'Pemeriksaan rutin harian berjalan baik.',
                    ...$populasi,
                ]);

            });
            $tanggalTambahHari++;
        }
    }
}
