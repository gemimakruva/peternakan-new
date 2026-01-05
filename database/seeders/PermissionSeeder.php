<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'kandang.rekapan-produksi.rekapan-produksi-list',
            'kandang.rekapan-produksi.rekapan-produksi-export',

            'kandang.pengadaan-ayam.pengadaan-ayam-list',
            'kandang.pengadaan-ayam.pengadaan-ayam-tambah',
            'kandang.pengadaan-ayam.pengadaan-ayam-edit',

            'kandang.pencatatan-harian.pencatatan-harian-list',
            'kandang.pencatatan-harian.pencatatan-harian-tambah',
            'kandang.pencatatan-harian.pencatatan-harian-edit',
            
            'kandang.ayam-afkir.ayam-afkir-list',
            'kandang.ayam-afkir.ayam-afkir-edit',
            
            'kandang.ayam-karantina.ayam-karantina-overview',
            'kandang.ayam-karantina.ayam-karantina-edit',
            'kandang.ayam-karantina.ayam-karantina-list',
            
            'kandang.pakan-harian.pakan-harian-list',
            'kandang.pakan-harian.pakan-harian-tambah',
            'kandang.pakan-harian.pakan-harian-edit',
            'kandang.pakan-harian.pakan-harian-hapus',
            
            'kandang.sisa-pakan-harian.sisa-pakan-harian-list',
            'kandang.sisa-pakan-harian.sisa-pakan-harian-tambah',
            'kandang.sisa-pakan-harian.sisa-pakan-harian-edit',
            'kandang.sisa-pakan-harian.sisa-pakan-harian-hapus',
            
            'kandang.record-telur.record-telur-tambah',
            'kandang.record-telur.record-telur-edit',
            'kandang.record-telur.record-telur-hapus',
            'kandang.record-telur.record-telur-list',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
