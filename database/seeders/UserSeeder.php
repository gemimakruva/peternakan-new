<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // # SISTEM
        // ## Superadmin
        $superadmin = User::firstOrCreate([
            'name' => 'Superadmin',
            'email' => 'superadmin@peternakan.com',
        ], [
            'password' => Hash::make('password'),
        ]);
        $roleSuperadmin = Role::firstOrCreate(['name' => 'Superadmin']);
        $superadmin->syncRoles($roleSuperadmin);

        // ## Admin User
        $this->generateUserWithRole(
            'Admin User',
            'admin-user@peternakan.com',
            'Admin User',
            [
                'master-data.setting.menu-user',
                'master-data.setting.menu-role-permission',
            ]
        );

        // ## Manager Produksi
        $this->generateUserWithRole(
            'Manager Produksi',
            'manager-produksi@peternakan.com',
            'Manager Produksi',
            [
                'master-data.master-data.menu-peternakan',
                'master-data.master-data.menu-kandang',
                'master-data.master-data.menu-flock',
                'master-data.master-data.menu-list',
                'master-data.master-data.menu-jenis-pakan',
                'master-data.master-data.menu-jenis-treatment',
                'master-data.master-data.menu-metode-treatment',

                'kandang.strain.menu-strain-list',

                'kandang.rekapan.menu-rekapan-produksi',
                'kandang.populasi.menu-rekapan-populasi-ayam',
                'kandang.populasi.menu-rekapan-karantina',
                'kandang.pakan.menu-rekapan-pakan-harian',
                'kandang.telur.menu-rekapan-produksi-telur',

                'kandang.treatment.menu-pelaksanaan-treatment',

                'kandang.sampling.menu-sampling-bobot-ayam',
                'kandang.sampling.list-sampling-bobot-ayam',
                'kandang.sampling.detail-sampling-bobot-ayam',

                'kandang.monitoring.menu-monitoring-kesehatan',
                'kandang.monitoring.list-monitoring-kesehatan',
                'kandang.monitoring.detail-monitoring-kesehatan',
            ]
        );

        // ## SPV Kandang
        $this->generateUserWithRole(
            'SPV Kandang',
            'spv-kandang@peternakan.com',
            'SPV Kandang',
            [
                'kandang.rekapan.menu-rekapan-produksi',

                'kandang.populasi.menu-pengadaan-ayam',
                'kandang.populasi.menu-populasi-ayam',
                'kandang.populasi.menu-rekapan-populasi-ayam',
                'kandang.populasi.menu-afkir-ayam',
                'kandang.populasi.menu-karantina-ayam',
                'kandang.populasi.menu-rekapan-karantina',

                'kandang.pakan.menu-perhitungan-pemberian-pakan',
                'kandang.pakan.menu-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.list-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.edit-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.detail-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.menu-rekapan-pakan-harian',

                'kandang.telur.menu-produksi-telur',
                'kandang.telur.list-produksi-telur',
                'kandang.telur.detail-produksi-telur',
                'kandang.telur.menu-rekapan-produksi-telur',

                'kandang.treatment.menu-penjadwalan-treatment',
                'kandang.treatment.menu-pelaksanaan-treatment',
                'kandang.treatment.edit-pelaksanaan-treatment',

                'kandang.sampling.menu-sampling-bobot-ayam',
                'kandang.sampling.list-sampling-bobot-ayam',
                'kandang.sampling.create-sampling-bobot-ayam',
                'kandang.sampling.detail-sampling-bobot-ayam',
                'kandang.sampling.edit-sampling-bobot-ayam',
                'kandang.sampling.delete-sampling-bobot-ayam',

                'kandang.monitoring.menu-monitoring-kesehatan',
                'kandang.monitoring.list-monitoring-kesehatan',
                'kandang.monitoring.detail-monitoring-kesehatan',
            ]
        );

        ## Petugas Kandang
        $this->generateUserWithRole(
            'Petugas Kandang',
            'petugas-kandang@peternakan.com',
            'Petugas Kandang',
            [
                'kandang.populasi.menu-populasi-ayam',
                'kandang.populasi.menu-karantina-ayam',
                'kandang.pakan.menu-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.list-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.edit-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.detail-pemberian-pakan-dan-sisa-pakan',
                'kandang.telur.menu-produksi-telur',
                'kandang.telur.list-produksi-telur',
                'kandang.telur.detail-produksi-telur',
                'kandang.sampling.menu-sampling-bobot-ayam',
                'kandang.sampling.list-sampling-bobot-ayam',
                'kandang.sampling.create-sampling-bobot-ayam',
                'kandang.sampling.detail-sampling-bobot-ayam',
                'kandang.sampling.edit-sampling-bobot-ayam',

                'kandang.treatment.menu-pelaksanaan-treatment',
                'kandang.treatment.edit-pelaksanaan-treatment',
                'kandang.treatment.list-unexecuted-only-pelaksanaan-treatment',
            ]
        );

        ## Dokter Hewan
        $this->generateUserWithRole(
            'Dokter Hewan',
            'dokter-hewan@peternakan.com',
            'Dokter Hewan',
            [
                'kandang.treatment.menu-penjadwalan-treatment',
                'kandang.treatment.menu-pelaksanaan-treatment',
                'kandang.treatment.edit-pelaksanaan-treatment',
                'kandang.monitoring.menu-monitoring-kesehatan',
                'kandang.monitoring.list-monitoring-kesehatan',
                'kandang.monitoring.create-monitoring-kesehatan',
                'kandang.monitoring.detail-monitoring-kesehatan',
                'kandang.monitoring.edit-monitoring-kesehatan',
            ]
        );

        ## Petugas Gudang Telur
        $this->generateUserWithRole(
            'Petugas Gudang Telur',
            'petugas-gudang-telur@peternakan.com',
            'Petugas Gudang Telur',
            [
                'kandang.telur.menu-produksi-telur',
                'kandang.telur.list-produksi-telur',
                'kandang.telur.detail-produksi-telur',

                'gudang-telur.grading-telur.menu-grading-telur',

                'gudang-telur.input-kemasan.menu-input-kemasan',
                'gudang-telur.output-kemasan.menu-output-kemasan',
                'gudang-telur.opname-kemasan.menu-opname-kemasan',
                'gudang-telur.inventory-kemasan.menu-inventory-kemasan',

                'gudang-telur.supplier-kemasan.menu-supplier-kemasan',

                'gudang-telur.telur-masuk.menu-telur-masuk',
                'gudang-telur.telur-keluar.menu-telur-keluar',
                'gudang-telur.telur-opname.menu-telur-opname',
                'gudang-telur.inventory-telur.menu-inventory-telur',
            ]
        );

        ## Petugas Gudang Pakan
        $this->generateUserWithRole(
            'Petugas Gudang Pakan',
            'petugas-gudang-pakan@peternakan.com',
            'Petugas Gudang Pakan',
            [
                'kandang.pakan.menu-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.list-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.detail-pemberian-pakan-dan-sisa-pakan',

                'master-data.master-data.menu-bahan-pakan',
                'gudang-pakan.supplier-bahan-pakan.menu-supplier-bahan-pakan',

                'gudang-pakan.bahan-pakan-pembelian.menu-bahan-pakan-pembelian',
                'gudang-pakan.bahan-pakan-masuk.menu-bahan-pakan-masuk',
                'gudang-pakan.bahan-pakan-inventory.menu-bahan-pakan-inventory',
                'gudang-pakan.bahan-pakan-formulasi.menu-bahan-pakan-formulasi',
            ]
        );
    }

    private function generateUserWithRole($userName, $userEmail, $roleName, $permissions)
    {
        $user = User::firstOrCreate([
            'name' => $userName,
            'email' => $userEmail,
        ], [
            'password' => Hash::make('password'),
        ]);
        $role = Role::firstOrCreate(['name' => $userName]);
        $user->syncRoles($roleName);

        foreach ($permissions as $name) {
            $permissionsObjs[] = Permission::firstOrCreate([
                'name' => $name,
            ]);
        }   
        $role->permissions()->sync($permissionsObjs);
    }

    private function permissions()
    {
        return [
            'master-data.setting.menu-user',
            'master-data.setting.menu-role-permission',

            'master-data.master-data.menu-peternakan',
            'master-data.master-data.menu-kandang',
            'master-data.master-data.menu-flock',
            'master-data.master-data.menu-pipe',
            'master-data.master-data.menu-jenis-pakan',
            'master-data.master-data.menu-jenis-treatment',
            'master-data.master-data.menu-metode-treatment',

            'master-data.master-data.menu-kemasan',
            'master-data.master-data.menu-bahan-pakan',

            'kandang.strain.menu-strain',

            'kandang.rekapan.menu-rekapan-produksi',

            'kandang.populasi.menu-pengadaan-ayam',
            'kandang.populasi.menu-populasi-ayam',
            'kandang.populasi.menu-rekapan-populasi-ayam',
            'kandang.populasi.menu-afkir-ayam',
            'kandang.populasi.menu-karantina-ayam',
            'kandang.populasi.menu-rekapan-karantina',

            'kandang.pakan.menu-perhitungan-pemberian-pakan',
            'kandang.pakan.menu-pemberian-pakan-dan-sisa-pakan',
            'kandang.pakan.list-pemberian-pakan-dan-sisa-pakan',
            'kandang.pakan.edit-pemberian-pakan-dan-sisa-pakan',
            'kandang.pakan.detail-pemberian-pakan-dan-sisa-pakan',
            'kandang.pakan.menu-rekapan-pakan-harian',

            'kandang.telur.menu-produksi-telur',
            'kandang.telur.list-produksi-telur',
            'kandang.telur.create-produksi-telur',
            'kandang.telur.edit-produksi-telur',
            'kandang.telur.detail-produksi-telur',
            'kandang.pakan.menu-rekapan-produksi-telur',

            'kandang.sampling.menu-sampling-bobot-ayam',
            'kandang.sampling.list-sampling-bobot-ayam',
            'kandang.sampling.create-sampling-bobot-ayam',
            'kandang.sampling.detail-sampling-bobot-ayam',
            'kandang.sampling.edit-sampling-bobot-ayam',
            'kandang.sampling.delete-sampling-bobot-ayam',

            'kandang.treatment.menu-penjadwalan-treatment',
            'kandang.treatment.menu-pelaksanaan-treatment',
            'kandang.treatment.edit-pelaksanaan-treatment',
            'kandang.treatment.list-unexecuted-only-pelaksanaan-treatment',

            'kandang.monitoring.menu-monitoring-kesehatan',
            'kandang.monitoring.list-monitoring-kesehatan',
            'kandang.monitoring.create-monitoring-kesehatan',
            'kandang.monitoring.detail-monitoring-kesehatan',
            'kandang.monitoring.edit-monitoring-kesehatan',

            'gudang-telur.grading-telur.menu-grading-telur',

            'gudang-telur.input-kemasan.menu-input-kemasan',
            'gudang-telur.output-kemasan.menu-output-kemasan',
            'gudang-telur.opname-kemasan.menu-opname-kemasan',
            'gudang-telur.inventory-kemasan.menu-inventory-kemasan',

            'gudang-telur.supplier-kemasan.menu-supplier-kemasan',

            'gudang-telur.telur-masuk.menu-telur-masuk',
            'gudang-telur.telur-keluar.menu-telur-keluar',
            'gudang-telur.telur-opname.menu-telur-opname',
            'gudang-telur.inventory-telur.menu-inventory-telur',

            'gudang-pakan.supplier-bahan-pakan.menu-supplier-bahan-pakan',
            'gudang-pakan.bahan-pakan-pembelian.menu-bahan-pakan-pembelian',
            'gudang-pakan.bahan-pakan-masuk.menu-bahan-pakan-masuk',
            'gudang-pakan.bahan-pakan-inventory.menu-bahan-pakan-inventory',
            'gudang-pakan.bahan-pakan-formulasi.menu-bahan-pakan-formulasi',
        ];
    }
}
