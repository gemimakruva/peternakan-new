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
            'Lihat Semua User',
            'Tambah User',
            'Edit User',
            'Hapus User',
            'Lihat Semua Role',
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

        // # MASTER DATA
        // ## Kandang
        $userPetugasKandang = User::factory()->create([
            'name' => 'Petugas Kandang',
            'email' => 'petugas-kandang@peternakan.com'
        ]);
        $rolePetugasKandang = Role::create(['name' => 'Petugas Kandang']);
        $userPetugasKandang->assignRole($rolePetugasKandang);

        $kandangPermissionsNames = [
            'Lihat Semua Kandang',
            'Tambah Kandang',
            'Edit Kandang',
            'Hapus Kandang',
            'Lihat Semua Flock',
            'Tambah Flock',
            'Edit Flock',
            'Hapus Flock',
            'Lihat Semua Pipe',
            'Tambah Pipe',
            'Edit Pipe',
            'Hapus Pipe',
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
