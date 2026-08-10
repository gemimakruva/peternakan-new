<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\UserSeeder::class);
});

test('login page is accessible', function () {
    $this->get('/login')->assertStatus(200);
});

test('user can login with valid credentials', function () {
    $this->post('/login', [
        'email' => 'superadmin@peternakan.com',
        'password' => 'password',
    ])->assertRedirect('/home');

    $this->assertAuthenticated();
});

test('user cannot login with invalid credentials', function () {
    $this->post('/login', [
        'email' => 'superadmin@peternakan.com',
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('authenticated user can access dashboard', function () {
    $user = User::where('email', 'superadmin@peternakan.com')->first();

    $this->actingAs($user)
        ->get('/home')
        ->assertStatus(200);
});

test('guest cannot access dashboard', function () {
    $this->get('/home')
        ->assertRedirect('/login');
});

test('authenticated user can logout', function () {
    $user = User::where('email', 'superadmin@peternakan.com')->first();

    $this->actingAs($user)
        ->post('/logout')
        ->assertRedirect('/');

    $this->assertGuest();
});

test('all 8 seeded users can login', function () {
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
        $this->post('/login', [
            'email' => $email,
            'password' => 'password',
        ])->assertRedirect('/home');

        $this->post('/logout');
    }
});
