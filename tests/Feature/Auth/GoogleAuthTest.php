<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

uses(RefreshDatabase::class);

test('google redirect stores selected role in session', function () {
    $response = $this->get(route('auth.google', ['role' => 'teacher']));

    $response->assertRedirect();
    expect(session('register_role'))->toBe('teacher');
});

test('google callback registers new user with role from session', function () {
    session(['register_role' => 'teacher']);

    $googleUserMock = Mockery::mock(SocialiteUser::class);
    $googleUserMock->shouldReceive('getId')->andReturn('google-id-123');
    $googleUserMock->shouldReceive('getEmail')->andReturn('google@example.com');
    $googleUserMock->shouldReceive('getName')->andReturn('Google User');
    $googleUserMock->token = 'mock-token';
    $googleUserMock->refreshToken = 'mock-refresh-token';

    $providerMock = Mockery::mock(Provider::class);
    $providerMock->shouldReceive('user')->andReturn($googleUserMock);

    Socialite::shouldReceive('driver')->with('google')->andReturn($providerMock);

    $response = $this->get('/auth/google/callback');

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('users', [
        'email' => 'google@example.com',
        'role' => 'teacher',
        'google_id' => 'google-id-123',
    ]);
});

test('google callback defaults new user to user role if session is empty', function () {
    $googleUserMock = Mockery::mock(SocialiteUser::class);
    $googleUserMock->shouldReceive('getId')->andReturn('google-id-456');
    $googleUserMock->shouldReceive('getEmail')->andReturn('google2@example.com');
    $googleUserMock->shouldReceive('getName')->andReturn('Google User 2');
    $googleUserMock->token = 'mock-token';
    $googleUserMock->refreshToken = 'mock-refresh-token';

    $providerMock = Mockery::mock(Provider::class);
    $providerMock->shouldReceive('user')->andReturn($googleUserMock);

    Socialite::shouldReceive('driver')->with('google')->andReturn($providerMock);

    $response = $this->get('/auth/google/callback');

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('users', [
        'email' => 'google2@example.com',
        'role' => 'user',
        'google_id' => 'google-id-456',
    ]);
});

test('google callback does not overwrite role of existing user', function () {
    session(['register_role' => 'user']);

    $existingUser = User::factory()->create([
        'email' => 'existing@example.com',
        'role' => 'teacher',
    ]);

    $googleUserMock = Mockery::mock(SocialiteUser::class);
    $googleUserMock->shouldReceive('getId')->andReturn('google-id-789');
    $googleUserMock->shouldReceive('getEmail')->andReturn('existing@example.com');
    $googleUserMock->shouldReceive('getName')->andReturn('Existing Teacher');
    $googleUserMock->token = 'mock-token';
    $googleUserMock->refreshToken = 'mock-refresh-token';

    $providerMock = Mockery::mock(Provider::class);
    $providerMock->shouldReceive('user')->andReturn($googleUserMock);

    Socialite::shouldReceive('driver')->with('google')->andReturn($providerMock);

    $response = $this->get('/auth/google/callback');

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('users', [
        'email' => 'existing@example.com',
        'role' => 'teacher', // Still teacher, not overwritten to user
        'google_id' => 'google-id-789',
    ]);
});
