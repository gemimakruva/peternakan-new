<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\UserSeeder::class);
    $this->seed(\Modules\Kandang\Database\Seeders\KandangDatabaseSeeder::class);
    $this->superadmin = User::where('email', 'superadmin@peternakan.com')->first();
});

test('user index page loads', function () {
    $this->actingAs($this->superadmin)
        ->get('/user')
        ->assertOk();
});

test('role index page loads', function () {
    $this->actingAs($this->superadmin)
        ->get('/role')
        ->assertOk();
});

test('user create page loads', function () {
    $this->actingAs($this->superadmin)
        ->get('/user/create')
        ->assertOk();
});

test('user can be created', function () {
    $this->actingAs($this->superadmin)
        ->post('/user', [
            'name' => 'Test User',
            'email' => 'test@peternakan.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'roles' => ['Petugas Kandang'],
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@peternakan.com',
    ]);
});

test('setting page loads for superadmin', function () {
    $this->actingAs($this->superadmin)
        ->get('/setting')
        ->assertOk();
});

test('profile page loads', function () {
    $this->actingAs($this->superadmin)
        ->get('/profile')
        ->assertOk();
});

test('profile can be updated', function () {
    $this->actingAs($this->superadmin)
        ->put('/profile', [
            'name' => 'Updated Superadmin',
            'email' => 'superadmin@peternakan.com',
        ]);

    $this->superadmin->refresh();
    expect($this->superadmin->name)->toBe('Updated Superadmin');
});

test('error pages render correctly', function () {
    $this->actingAs($this->superadmin)
        ->get('/nonexistent-route-for-404-test')
        ->assertStatus(404);
});
