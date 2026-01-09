<?php
namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Enums\JenisPemeriksaan;
use Modules\Kandang\Models\KarantinaPopulasiPipe;
use Modules\Kandang\Models\PopulasiAyam;
use App\Models\User;
use Faker\Factory as Faker;
use Modules\Kandang\Models\KarantinaPopulasi;


class AyamKarantinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
{
    $faker = Faker::create('id_ID');

    $populasiDenganAyamKarantina = PopulasiAyam::getQuery()
        ->where('ayam_masuk_karantina', '>', 0)
        ->orWhere('ayam_keluar_karantina', '>', 0)
        ->groupBy('pic_user_id')
        ->groupBy('tanggal')
        ->selectRaw(<<<SQL
            pic_user_id
            , tanggal
            , SUM(ayam_masuk_karantina) AS total_masuk
            , SUM(ayam_keluar_karantina) AS total_keluar
        SQL)
        ->get();

    $semuaPopulasiAyam = PopulasiAyam::get();

    $semuaPopulasiAyam->map(function($pdak){
        if (!$pdak->ayam_masuk_karantina && !$pdak->ayam_keluar_karantina) return;
        KarantinaPopulasiPipe::updateOrCreate([
            'populasi_ayam_asal_id' => $pdak->pipe->flock->kandang_id,
            'tanggal' => $pdak->tanggal,
            'pipe_asal_id' => $pdak->pipe_id,
            'ayam_masuk_karantina' => $pdak->ayam_masuk_karantina,
        ], [
            'pipe_tujuan_id' => $pdak->ayam_keluar_karantina ? $pdak->pipe_id : null,
            'ayam_keluar_karantina' => $pdak->ayam_keluar_karantina,
        ]);
    });

    $latestKarantinaKandang = null;
    $semuaPopulasiAyam->map(function($pdak) use($faker, &$latestKarantinaKandang, $populasiDenganAyamKarantina) {
        if (@$latestKarantinaKandang->tanggal == @$pdak->tanggal) return;

        $totalAyamKarantina = (int) @$latestKarantinaKandang->total_ayam_karantina ?? 0;

        $perubahanPopulasiMasuk = $populasiDenganAyamKarantina->where('tanggal', '=', $pdak->tanggal)->value('total_masuk');
        if ($perubahanPopulasiMasuk) {
            $totalAyamKarantina = $totalAyamKarantina + $perubahanPopulasiMasuk;
            echo "masuk karantina tanggal $pdak->tanggal sebanyak: $totalAyamKarantina" . PHP_EOL;
        }

        $perubahanPopulasiKeluar = $populasiDenganAyamKarantina->where('tanggal', '=', $pdak->tanggal)->value('total_keluar');
        if ($perubahanPopulasiKeluar) {
            $totalAyamKarantina = $totalAyamKarantina - $perubahanPopulasiKeluar;
            echo "keluar karantina tanggal $pdak->tanggal sebanyak: $totalAyamKarantina" . PHP_EOL;
        }

        $pemberianPakanPerEkor = 100;
        $sisaPakanPerEkor = 10;

        $karantinaKandang = KarantinaPopulasi::updateOrCreate([
            'kandang_id'             => $pdak->pipe->flock->kandang_id,
            'pic_user_id'            => $pdak->pic_user_id,
            'tanggal'                => $pdak->tanggal,
            'ayam_mati'              => 0,
            'ayam_afkir'             => 0,
            'total_ayam_karantina'   => $totalAyamKarantina,
        ], [
            'pemberian_pakan'        => $totalAyamKarantina * $pemberianPakanPerEkor,
            'sisa_pakan'             => $totalAyamKarantina * $sisaPakanPerEkor,
            'jumlah_telur_bagus'     => $totalAyamKarantina - 3,
            'jumlah_telur_retak'     => 2,
            'jumlah_telur_rusak'     => 1,
            'berat_telur_bagus'      => ($totalAyamKarantina - 3)/16,
            'berat_telur_retak'      => 2/16,
            'berat_telur_rusak'      => 1/16,
            'pengobatan_yang_dilakukan' => $faker->randomElement([
                'Antibiotik', 'Vitamin tambahan', 'Pembersihan kandang', null
            ]),
            'jumlah_ayam_diobati'    => $faker->numberBetween(0, $totalAyamKarantina),
            'penyemprotan' => $faker->randomElement([
                'Desinfektan Virkon',
                'Desinfektan Benzalkonium',
                'Povidone Iodine',
                'Natural Probiotik Spray',
                'Cairan antiseptik',
                null
            ]),
            'vaksin'   => $faker->randomElement(['ND', 'AI', 'IB', null]),
            'catatan'  => $faker->sentence(),
        ]);
        $latestKarantinaKandang = $karantinaKandang;
    });
}

}
