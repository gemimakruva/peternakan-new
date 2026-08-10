<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\UserSeeder::class);
    $this->seed(\Modules\Kandang\Database\Seeders\KandangDatabaseSeeder::class);
});

function userByEmail(string $email): User
{
    return User::where('email', $email)->first();
}

test('all 8 roles exist after seeding', function () {
    $roles = [
        'Superadmin', 'Admin User', 'Manager Produksi', 'SPV Kandang',
        'Petugas Kandang', 'Dokter Hewan', 'Petugas Gudang Telur', 'Petugas Gudang Pakan',
    ];

    foreach ($roles as $role) {
        $user = User::where('name', $role)->first();
        expect($user)->not->toBeNull("User $role should exist");
        expect($user->hasRole($role))->toBeTrue("User should have role $role");
    }
});

test('superadmin bypasses all permission gates', function () {
    $user = userByEmail('superadmin@peternakan.com');

    expect($user->can('master-data.setting.menu-user'))->toBeTrue();
    expect($user->can('any.random.permission'))->toBeTrue();
});

test('admin user has only user/role management permissions', function () {
    $user = userByEmail('admin-user@peternakan.com');

    expect($user->can('master-data.setting.menu-user'))->toBeTrue();
    expect($user->can('master-data.setting.menu-role-permission'))->toBeTrue();
    expect($user->can('kandang.populasi.menu-populasi-ayam'))->toBeFalse();
});

test('petugas kandang has kandang permissions but not admin', function () {
    $user = userByEmail('petugas-kandang@peternakan.com');

    expect($user->can('kandang.populasi.menu-populasi-ayam'))->toBeTrue();
    expect($user->can('kandang.telur.menu-produksi-telur'))->toBeTrue();
    expect($user->can('master-data.setting.menu-user'))->toBeFalse();
    expect($user->can('gudang-pakan.pakan-mixing.menu-pakan-mixing'))->toBeFalse();
});

test('dokter hewan has treatment and monitoring permissions only', function () {
    $user = userByEmail('dokter-hewan@peternakan.com');

    expect($user->can('kandang.treatment.menu-penjadwalan-treatment'))->toBeTrue();
    expect($user->can('kandang.monitoring.menu-monitoring-kesehatan'))->toBeTrue();
    expect($user->can('kandang.populasi.menu-populasi-ayam'))->toBeFalse();
    expect($user->can('gudang-telur.grading-telur.menu-grading-telur'))->toBeFalse();
});

test('petugas gudang telur has telur permissions only', function () {
    $user = userByEmail('petugas-gudang-telur@peternakan.com');

    expect($user->can('gudang-telur.grading-telur.menu-grading-telur'))->toBeTrue();
    expect($user->can('gudang-telur.telur-masuk.menu-telur-masuk'))->toBeTrue();
    expect($user->can('gudang-pakan.pakan-mixing.menu-pakan-mixing'))->toBeFalse();
    expect($user->can('master-data.setting.menu-user'))->toBeFalse();
});

test('petugas gudang pakan has pakan permissions only', function () {
    $user = userByEmail('petugas-gudang-pakan@peternakan.com');

    expect($user->can('gudang-pakan.bahan-pakan-formulasi.menu-bahan-pakan-formulasi'))->toBeTrue();
    expect($user->can('gudang-pakan.pakan-mixing.menu-pakan-mixing'))->toBeTrue();
    expect($user->can('gudang-telur.grading-telur.menu-grading-telur'))->toBeFalse();
    expect($user->can('master-data.setting.menu-user'))->toBeFalse();
});

test('dashboard is accessible by all roles', function () {
    $emails = [
        'superadmin@peternakan.com',
        'admin-user@peternakan.com',
        'manager-produksi@peternakan.com',
        'spv-kandang@peternakan.com',
        'petugas-kandang@peternakan.com',
        'dokter-hewan@peternakan.com',
        'petugas-gudang-telur@peternakan.com',
        'petugas-gudang-pakan@peternakan.com',
    ];

    foreach ($emails as $email) {
        $this->actingAs(userByEmail($email))
            ->get('/home')
            ->assertOk();
    }
});

test('guest cannot access protected routes', function () {
    $protectedRoutes = ['/home', '/user', '/role', '/setting'];

    foreach ($protectedRoutes as $route) {
        $this->get($route)->assertRedirect('/login');
    }
});
