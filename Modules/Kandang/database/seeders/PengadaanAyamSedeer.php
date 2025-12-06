<?php

namespace Modules\Kandang\Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PengadaanAyam;
use Modules\Kandang\Models\PengadaanAyamDistribusi;

class PengadaanAyamSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kandang = Kandang::with('flocks.pipes')->first();
        $tanggal = Carbon::createFromFormat('Y-m-d', '2025-10-01');
        
        $kapasitasKandang = $kandang->flocks->reduce(function($total, $flock) {
            return $total += $flock->pipes->sum('kapasitas');
        }, 0);

        $totalPipa = $kandang->flocks->reduce(function($total, $flock) {
            return $total += $flock->pipes->count();
        }, 0);

        $pengadaanAyam = PengadaanAyam::firstOrCreate([
            'pic_user_id' => 1,
            'tanggal' => $tanggal,
            'umur_ayam' => 13,
            'kondisi_ayam' => 'Sehat',
            'jumlah_ayam_datang' => $kapasitasKandang,
            'jumlah_ayam_mati' => 0,
            'jumlah_ayam_sakit' => 0,
            'jumlah_ayam_masuk_kandang' => $kapasitasKandang,
            'catatan' => 'Pengadaan ayam DOC untuk pengisian kandang unit'
        ]);

        $kandang->flocks->map(function($flock) use($pengadaanAyam, $kapasitasKandang, $totalPipa) {
            $flock->pipes->map(function($pipe) use($pengadaanAyam, $kapasitasKandang, $totalPipa, $flock) {
                PengadaanAyamDistribusi::firstOrCreate([
                    'pengadaan_ayam_id' => $pengadaanAyam->id,
                    'pipe_id' => $pipe->id,
                    'jumlah_ayam' => $kapasitasKandang/$totalPipa,
                ]);
            });
        });
    }
}
