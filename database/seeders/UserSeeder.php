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

        // ## User & Role
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin-user@peternakan.com',
        ]);
        $roleAdminUser = Role::create(['name' => 'Admin User']);
        $adminUser->assignRole($roleAdminUser);

        $systemPermissionsNames = [
            'master-data.user.user-list',
            'master-data.user.user-tambah',
            'master-data.user.user-edit',
            'master-data.user.user-hapus',

            'master-data.role.role-list',
            'master-data.role.role-tambah',
            'master-data.role.role-edit',
            'master-data.role.role-hapus',
        ];
        foreach ($systemPermissionsNames as $name) {
            $sistemPermissions[] = Permission::create([
                'name' => $name,
            ]);
        }
        $roleAdminUser->permissions()->attach($sistemPermissions);

        // # MASTER DATA
        // ## Kandang
        $userPetugasKandang = User::factory()->create([
            'name' => 'Petugas Kandang',
            'email' => 'petugas-kandang@peternakan.com'
        ]);
        $rolePetugasKandang = Role::create(['name' => 'Petugas Kandang']);
        $userPetugasKandang->assignRole($rolePetugasKandang);

        $kandangPermissionsNames = [
            'master-data.strain.strain-list',

            'master-data.peternakan.peternakan-list',
            'master-data.peternakan.peternakan-tambah',
            'master-data.peternakan.peternakan-edit',
            'master-data.peternakan.peternakan-hapus',

            'master-data.kandang.kandang-list',
            'master-data.kandang.kandang-tambah',
            'master-data.kandang.kandang-edit',
            'master-data.kandang.kandang-hapus',

            'master-data.flock.flock-list',
            'master-data.flock.flock-tambah',
            'master-data.flock.flock-edit',
            'master-data.flock.flock-hapus',

            'master-data.pipe.pipe-list',
            'master-data.pipe.pipe-tambah',
            'master-data.pipe.pipe-edit',
            'master-data.pipe.pipe-hapus',

            'master-data.jenis-pakan.jenis-pakan-list',
            'master-data.jenis-pakan.jenis-pakan-tambah',
            'master-data.jenis-pakan.jenis-pakan-edit',
            'master-data.jenis-pakan.jenis-pakan-hapus',

            'master-data.jenis-disinfektan.jenis-disinfektan-list',
            'master-data.jenis-disinfektan.jenis-disinfektan-tambah',
            'master-data.jenis-disinfektan.jenis-disinfektan-edit',
            'master-data.jenis-disinfektan.jenis-disinfektan-hapus',

            'master-data.jenis-treatment.jenis-treatment-list',
            'master-data.jenis-treatment.jenis-treatment-tambah',
            'master-data.jenis-treatment.jenis-treatment-edit',
            'master-data.jenis-treatment.jenis-treatment-hapus',

            'master-data.metode-treatment.metode-treatment-list',
            'master-data.metode-treatment.metode-treatment-tambah',
            'master-data.metode-treatment.metode-treatment-edit',
            'master-data.metode-treatment.metode-treatment-hapus',
        ];
        foreach ($kandangPermissionsNames as $name) {
            $kandangPermissions[] = Permission::create([
                'name' => $name,
            ]);
        }
        $rolePetugasKandang->permissions()->attach($kandangPermissions);
    }
}
