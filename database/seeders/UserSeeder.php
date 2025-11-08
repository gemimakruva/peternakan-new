<?php

namespace Database\Seeders;

use App\Enums\Modul;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $superadmin = User::factory()->create([
            'name' => 'Superadmin',
            'email' => 'superadmin@peternakan.com',
        ]);
        $roleSuperadmin = Role::create(['name' => 'Superadmin']);
        $superadmin->assignRole($roleSuperadmin);

        // # MASTER DATA
        // ## User & Role
        $adminUser = User::factory()->create([
            'name' => 'adminUser',
            'email' => 'adminUser@peternakan.com',
        ]);
        $roleAdminUser = Role::create(['name' => 'Admin User']);
        $adminUser->assignRole($roleAdminUser);

        $systemPermissionsNames = [
            'Tambah User',
            'Edit User',
            'Hapus User',
            'Tambah Role',
            'Edit Role',
            'Hapus Role',
        ];
        foreach ($systemPermissionsNames as $name) {
            $sistemPermissions[] = Permission::create([
                'name' => $name,
                'modul' => Modul::SISTEM->value,
            ]);
        }
        $roleAdminUser->permissions()->attach($sistemPermissions);

        // ## Kandang
        $userPetugasKandang = User::factory()->create([
            'name' => 'Petugas Kandang',
            'email' => 'petugas-kandang@peternakan.com'
        ]);
        $rolePetugasKandang = Role::create(['name' => 'Petugas Kandang']);
        $userPetugasKandang->assignRole($rolePetugasKandang);

        $kandangPermissionsNames = [
            'Tambah Kandang',
            'Edit Kandang',
            'Hapus Kandang',
        ];
        foreach ($kandangPermissionsNames as $name) {
            $kandangPermissions[] = Permission::create([
                'name' => $name,
                'modul' => Modul::KANDANG->value,
            ]);
        }
        $rolePetugasKandang->permissions()->attach($kandangPermissions);
    }
}
