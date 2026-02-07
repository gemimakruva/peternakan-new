<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\JenisOvk;
use Modules\Kandang\Models\Ovk;
use Modules\Kandang\Models\Satuan;

class TreatmentSeeder extends Seeder
{
    public function run(): void
    {
        $jenisOvk = [
            [
                'id'    => 1,
                'nama'  => 'Disinfektan',
            ],
            [
                'id'    => 2,
                'nama'  => 'Vaksin',
            ],
            [
                'id'    => 3,
                'nama'  => 'Vitamin/Mineral',
            ],
            [
                'id'    => 4,
                'nama'  => 'Antibiotik/Obat',
            ],
        ];

        JenisOvk::insert($jenisOvk);

        $satuan = [
            [
                'id'    => 1,
                'nama'  => 'ml',
                'standar_terkecil_satuan' => 1,
            ],
            [
                'id'    => 2,
                'nama'  => 'l',
                'standar_terkecil_satuan' => 1_000,
            ],
            [
                'id'    => 3,
                'nama'  => 'tangki',
                'standar_terkecil_satuan' => 1_000 * 500,
            ],
            [
                'id'    => 4,
                'nama'  => 'dosis',
                'standar_terkecil_satuan' => 1,
            ],
            [
                'id'    => 5,
                'nama'  => 'ayam',
                'standar_terkecil_satuan' => 1,
            ],
            [
                'id'    => 6,
                'nama'  => 'gram',
                'standar_terkecil_satuan' => 1,
            ],
            [
                'id'    => 7,
                'nama'  => 'kg',
                'standar_terkecil_satuan' => 1_000,
            ],
            [
                'id'    => 8,
                'nama'  => 'ton',
                'standar_terkecil_satuan' => 1_000_000,
            ],
        ];

        Satuan::insert($satuan);

        $ovk = [
            [
                'jenis_ovk_id'                  => 1,
                'nama'                          => 'Spectaral',
                'dosis_pembilang'               => 20,
                'dosis_pembilang_satuan_id'     => 1,
                'dosis_penyebut'                => 1,
                'dosis_penyebut_satuan_id'      => 3,
                'penggunaan_per_hari'           => 20,
                'penggunaan_per_hari_satuan_id' => 1,
                'harga'                         => 159_840,
                'harga_per_satuan'              => 1000,
                'harga_per_satuan_id'           => 1,
            ],
            [
                'jenis_ovk_id'                  => 1,
                'nama'                          => 'Asam Sitrat',
                'dosis_pembilang'               => 30,
                'dosis_pembilang_satuan_id'     => 6,
                'dosis_penyebut'                => 1,
                'dosis_penyebut_satuan_id'      => 2,
                'penggunaan_per_hari'           => 450,
                'penggunaan_per_hari_satuan_id' => 6,
                'harga'                         => 18_000,
                'harga_per_satuan'              => 1000,
                'harga_per_satuan_id'           => 6,
            ],
            [
                'jenis_ovk_id'                  => 2,
                'nama'                          => 'ND La Sota Live',
                'dosis_pembilang'               => 2,
                'dosis_pembilang_satuan_id'     => 4,
                'dosis_penyebut'                => 1,
                'dosis_penyebut_satuan_id'      => 5,
                'penggunaan_per_hari'           => 6000,
                'penggunaan_per_hari_satuan_id' => 4,
                'harga'                         => 30_000,
                'harga_per_satuan'              => 2000,
                'harga_per_satuan_id'           => 4,
            ],
            [
                'jenis_ovk_id'                  => 3,
                'nama'                          => 'Fortevit',
                'dosis_pembilang'               => 1,
                'dosis_pembilang_satuan_id'     => 6,
                'dosis_penyebut'                => 10,
                'dosis_penyebut_satuan_id'      => 2,
                'penggunaan_per_hari'           => 100,
                'penggunaan_per_hari_satuan_id' => 6,
                'harga'                         => 58_028,
                'harga_per_satuan'              => 100,
                'harga_per_satuan_id'           => 6,
            ],
            [
                'jenis_ovk_id'                  => 4,
                'nama'                          => 'Niclosamine',
                'dosis_pembilang'               => 1,
                'dosis_pembilang_satuan_id'     => 7,
                'dosis_penyebut'                => 1,
                'dosis_penyebut_satuan_id'      => 8,
                'penggunaan_per_hari'           => 450,
                'penggunaan_per_hari_satuan_id' => 7,
                'harga'                         => 700_000,
                'harga_per_satuan'              => 1_000,
                'harga_per_satuan_id'           => 6,
            ],
        ];

        Ovk::insert($ovk);
    }
}
