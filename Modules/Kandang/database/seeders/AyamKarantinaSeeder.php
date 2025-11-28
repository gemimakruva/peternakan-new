<?php
namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\PopulasiAyam;
use App\Models\User;
use Faker\Factory as Faker;
use Modules\Kandang\Models\AyamKarantina as ModelsAyamKarantina;


class AyamKarantinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
{
    $faker = Faker::create('id_ID');
    $populasiList = PopulasiAyam::pluck('id')->toArray();
    $users = User::pluck('id')->toArray();

    for ($i = 0; $i < 5; $i++) {
        ModelsAyamKarantina::create([
            'populasi_ayam_id'        => !empty($populasiList) ? $faker->randomElement($populasiList) : 1,
            'pic_user_id'            => !empty($users) ? $faker->randomElement($users) : 1,
            'keterangan_pengecekan' =>  "Pencatatan Harian",
            'tanggal_karantina'      => $faker->date(),
            'ayam_masuk_karantina'   => $faker->numberBetween(5, 70),
            'ayam_mati'              => $faker->numberBetween(0, 10),
            'ayam_afkir'             => $faker->numberBetween(0, 10),
            'ayam_keluar_karantina'  => $faker->numberBetween(0, 30),
            'pemberian_pakan'        => $faker->randomFloat(2, 0, 20),
            'sisa_pakan'             => $faker->randomFloat(2, 0, 20),
            'jumlah_telur_bagus'     => $faker->numberBetween(0, 80),
            'jumlah_telur_retak'     => $faker->numberBetween(0, 20),
            'jumlah_telur_rusak'     => $faker->numberBetween(0, 10),
            'penyebab_karantina'     => $faker->randomElement([
                'Infeksi bakteri', 'Cidera', 'Stres panas', 'Virus ringan', null
            ]),
            'pengobatan_yang_dilakukan' => $faker->randomElement([
                'Antibiotik', 'Vitamin tambahan', 'Pembersihan kandang', null
            ]),
            'jumlah_ayam_diobati'    => $faker->numberBetween(0, 50),
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
    }
}

}
