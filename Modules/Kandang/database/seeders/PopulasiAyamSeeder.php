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
        $listPengadaanAyam = PengadaanAyam::get();
        foreach ($listPengadaanAyam as $pengadaanAyam) {
            $this->createPopulasiAyam($pengadaanAyam);
        }
    }

    private function createPopulasiAyam(PengadaanAyam $pengadaanAyam)
    {
        $tanggal = Carbon::createFromFormat('Y-m-d', '2025-01-01'); // tanggal awal pengadaan ayam.
        $tanggalTambahHari = 0;
        for ($i=0; $i < 30; $i++) { 
            $pengadaanAyam->distribusi->map(function($distribusi) use($tanggal, $tanggalTambahHari, $pengadaanAyam) {
                $ayamSehat = PopulasiAyam::getAyamSehatTerakhir($distribusi->pipe_id) ?? $distribusi->jumlah_ayam;
                $tanggalPencatatan = $tanggal->clone()->addDays($tanggalTambahHari);
                $tanggalDMY = $tanggalPencatatan->format('d-m-Y');

                $populasi = [
                    'ayam_sehat' => $ayamSehat,
                    'ayam_mati' => 0,
                    'ayam_afkir' => 0,
                    'ayam_masuk_karantina' => 0,
                    'ayam_keluar_karantina' => 0,
                ];

                if ($tanggalDMY === '03-01-2025') {  // pada tanggal 3, 1 ayam mati di semua pipe
                    $populasi['ayam_sehat'] = $ayamSehat - 1;
                    $populasi['ayam_mati'] = 1;
                } else if ($tanggalDMY === '05-01-2025') { // pada tanggal 5, 2 ayam afkir di semua pipe
                    $populasi['ayam_sehat'] = $ayamSehat - 2;
                    $populasi['ayam_afkir'] = 2;
                } else if ($tanggalDMY === '07-01-2025') { // pada tanggal 7, 5 ayam masuk karantina di semua pipe
                    $populasi['ayam_sehat'] = $ayamSehat - 5;
                    $populasi['ayam_masuk_karantina'] = 5;
                } else if ($tanggalDMY === '15-01-2025') { // pada tanggal 15, 5 ayam keluar karantina di semua pipe
                    $populasi['ayam_sehat'] = $ayamSehat + 5;
                    $populasi['ayam_keluar_karantina'] = 5;
                }

                $namaKandang = $distribusi->pengadaanAyam->kandang->nama;
                echo "pencatatan kandang $namaKandang tanggal $tanggalDMY pipe id - $distribusi->pipe_id" . PHP_EOL;

                $umurAyamRecord = $pengadaanAyam->getUmurAyam($tanggalPencatatan);

                PopulasiAyam::create([
                    'pengadaan_ayam_distribusi_id' => $distribusi->id,
                    'pic_user_id' => 1,
                    'pipe_id' => $distribusi->pipe_id,
                    'umur_ayam_record' => $umurAyamRecord,
                    'jenis_pemeriksaan' => 'harian',
                    'tanggal' => $tanggalPencatatan,
                    'catatan' => 'Pemeriksaan rutin harian berjalan baik.',
                    ...$populasi,
                ]);

                // karantina belum ditambahkan


            });
            $tanggalTambahHari++;
        }
    }    
}
