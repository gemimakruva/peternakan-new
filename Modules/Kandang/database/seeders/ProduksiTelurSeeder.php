<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Models\ProduksiTelur;
use Modules\Kandang\Models\ProduksiTelurItem;

class ProduksiTelurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PopulasiAyam::from('populasi_ayam as pa')
            ->selectRaw('
                pa.kandang_id,
                pa.flock_id,
                pa.tanggal,
                pa.umur_ayam_record,
                SUM(pa.ayam_sehat) AS populasi
            ')
            ->groupBy(
                'pa.kandang_id',
                'pa.flock_id',
                'pa.tanggal',
                'pa.umur_ayam_record'
            )
            ->get()->each(function(PopulasiAyam $pa) {
                $produksiTelur = ProduksiTelur::firstOrCreate([
                    'kandang_id'    => $pa->kandang_id,
                    'pic_user_id'   => 1,
                    'tanggal'       => $pa->tanggal,
                    'umur_ayam'     => $pa->umur_ayam_record,
                ]);

                ProduksiTelurItem::firstOrCreate([
                    'produksi_telur_id'     => $produksiTelur->id,
                    'kandang_id'            => $pa->kandang_id,
                    'flock_id'              => $pa->flock_id,
                    'tanggal'               => $pa->tanggal,
                ], [
                    // asumsi 10% ayam akan bertelur, 5% telur bagus, 3% telur putih, 2% telur reject
                    'jumlah_telur_bagus'    => floor($pa->populasi/10*.5),
                    'jumlah_telur_putih'    => floor($pa->populasi/10*.3),
                    'jumlah_telur_reject'   => floor($pa->populasi/10*.2),
                    'berat_telur_bagus'     => floor($pa->populasi/10*.5)/16,
                    'berat_telur_putih'     => floor($pa->populasi/10*.3)/16,
                    'berat_telur_reject'    => floor($pa->populasi/10*.2)/16,
                ]);
            });
    }
}
