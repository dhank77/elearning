<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('authenticated users can view their profile page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('profile.edit'));

    $response->assertSuccessful();
    $response->assertSee('Profil Saya');
});

test('authenticated users can update their profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('profile.update'), [
            'name' => 'Admin Baru',
            'email' => 'admin-baru@example.com',
        ])
        ->assertRedirect(route('profile.edit'));

    $user->refresh();

    expect($user->name)->toBe('Admin Baru')
        ->and($user->email)->toBe('admin-baru@example.com');
});

test('authenticated users can update their password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password-lama'),
    ]);

    $this->actingAs($user)
        ->put(route('profile.password.update'), [
            'current_password' => 'password-lama',
            'password' => 'password-baru',
            'password_confirmation' => 'password-baru',
        ])
        ->assertRedirect(route('profile.password.edit'));

    expect(Hash::check('password-baru', $user->refresh()->password))->toBeTrue();
});
