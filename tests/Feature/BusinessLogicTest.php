<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Services\PopulasiAyamService;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(\Database\Seeders\UserSeeder::class);
    $this->seed(\Modules\Kandang\Database\Seeders\KandangDatabaseSeeder::class);
});

test('kandang has correct structure after seeding', function () {
    $kandang = Kandang::first();

    expect($kandang)->not->toBeNull();
    expect($kandang->nama)->toBeString();
    expect($kandang->flocks)->not->toBeEmpty();
});

test('kandang has flocks with pipes', function () {
    $kandang = Kandang::with('flocks.pipes')->first();

    if ($kandang) {
        foreach ($kandang->flocks as $flock) {
            expect($flock->pipes)->not->toBeEmpty();
            expect($flock->kandang_id)->toBe($kandang->id);
        }
    }
});

test('populasi ayam service returns correct data structure', function () {
    $kandang = Kandang::first();
    if (!$kandang) {
        $this->markTestSkipped('No kandang data available');
    }

    $service = app(PopulasiAyamService::class);
    $result = $service->getCurrentAyamSehatByKandang($kandang->id);

    expect($result)->toBeNumeric();
});

test('tour seen endpoint works for authenticated user', function () {
    $user = User::where('email', 'superadmin@peternakan.com')->first();

    $response = $this->actingAs($user)
        ->postJson('/api/tour/seen');

    $response->assertOk()
        ->assertJson(['ok' => true]);

    $user->refresh();
    expect((bool) $user->has_seen_tour)->toBeTrue();
});

test('tour seen endpoint requires authentication', function () {
    $this->postJson('/api/tour/seen')
        ->assertUnauthorized();
});
