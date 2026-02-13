<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // # SISTEM
        // ## Superadmin
        $superadmin = User::factory()->create([
            'name' => 'Superadmin',
            'email' => 'superadmin@peternakan.com',
        ]);
        $roleSuperadmin = Role::create(['name' => 'Superadmin']);
        $superadmin->assignRole($roleSuperadmin);

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
                'kandang.pakan.menu-rekapan-pakan-harian',

                'kandang.telur.menu-produksi-telur',
                'kandang.telur.menu-rekapan-produksi-telur',

                'kandang.sampling.menu-sampling-bobot-ayam',
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
                'kandang.telur.menu-produksi-telur',
                'kandang.sampling.menu-sampling-bobot-ayam',
                'kandang.treatment.menu-pelaksanaan-treatment',
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
                'kandang.monitoring.menu-monitoring-kesehatan',
            ]
        );
    }

    private function generateUserWithRole($userName, $userEmail, $roleName, $permissions)
    {
        $user = User::factory()->create([
            'name' => $userName,
            'email' => $userEmail,
        ]);
        $role = Role::create(['name' => $userName]);
        $user->assignRole($roleName);

        foreach ($permissions as $name) {
            $permissionsObjs[] = Permission::firstOrCreate([
                'name' => $name,
            ]);
        }
        $role->permissions()->attach($permissionsObjs);
    }

    private function permissions()
    {
        return [
            'master-data.setting.menu-user',
            'master-data.setting.menu-role-permission',

            'master-data.master-data.menu-peternakan',
            'master-data.master-data.menu-kandang',
            'master-data.master-data.menu-flock',
            'master-data.master-data.menu-list',
            'master-data.master-data.menu-jenis-pakan',
            'master-data.master-data.menu-jenis-treatment',
            'master-data.master-data.menu-metode-treatment',

            'kandang.strain.menu-strain-list',

            'kandang.rekapan.menu-rekapan-produksi',

            'kandang.populasi.menu-pengadaan-ayam',
            'kandang.populasi.menu-populasi-ayam',
            'kandang.populasi.menu-rekapan-populasi-ayam',
            'kandang.populasi.menu-afkir-ayam',
            'kandang.populasi.menu-karantina-ayam',
            'kandang.populasi.menu-rekapan-karantina',

            'kandang.pakan.menu-perhitungan-pemberian-pakan',
            'kandang.pakan.menu-pemberian-pakan-dan-sisa-pakan',
            'kandang.pakan.menu-rekapan-pakan-harian',

            'kandang.telur.menu-produksi-telur',
            'kandang.telur.menu-rekapan-produksi-telur',

            'kandang.sampling.menu-sampling-bobot-ayam',

            'kandang.treatment.menu-penjadwalan-treatment',
            'kandang.treatment.menu-pelaksanaan-treatment',

            'kandang.monitoring.menu-monitoring-kesehatan',
        ];
    }
}
