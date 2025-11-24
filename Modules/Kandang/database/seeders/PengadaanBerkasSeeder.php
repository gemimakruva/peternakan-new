<?php

namespace Modules\Kandang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kandang\Models\BerkasPengadaanAyam;

class PengadaanBerkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['pengadaan_ayam_id' => 1, 'file_path' => 'berkas/supplier1.pdf', 'nama_berkas' => 'Surat Supplier 1'],
            ['pengadaan_ayam_id' => 1, 'file_path' => 'berkas/supplier2.pdf', 'nama_berkas' => 'Surat Supplier 2'],
        ];
        BerkasPengadaanAyam::insert($data);
    }
}
