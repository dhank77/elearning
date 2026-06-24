<?php

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mews\Captcha\Facades\Captcha;

uses(RefreshDatabase::class);

test('login requires captcha validation', function () {
    $response = $this->withoutMiddleware([PreventRequestForgery::class])
        ->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
            'captcha' => 'invalid-captcha',
        ]);

    $response->assertSessionHasErrors([
        'captcha' => 'Kode verifikasi tidak sesuai.',
    ]);
});

test('login succeeds with valid captcha', function () {
    Captcha::shouldReceive('check')->once()->andReturn(true);

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->withoutMiddleware([PreventRequestForgery::class])
        ->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
            'captcha' => '123',
        ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('register requires captcha validation', function () {
    $response = $this->withoutMiddleware([PreventRequestForgery::class])
        ->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => 'on',
            'captcha' => 'invalid-captcha',
        ]);

    $response->assertSessionHasErrors([
        'captcha' => 'Kode verifikasi tidak sesuai.',
    ]);
});

test('register succeeds with valid captcha', function () {
    Captcha::shouldReceive('check')->once()->andReturn(true);

    $response = $this->withoutMiddleware([PreventRequestForgery::class])
        ->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => 'on',
            'captcha' => '123',
        ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});
