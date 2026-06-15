<?php

use App\Models\Course;
use App\Models\CourseOrder;
use App\Models\User;
use App\Services\XenditService;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Xendit\Invoice\Invoice;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    config(['services.xendit.api_key' => 'xnd_test_key']);
    config(['services.xendit.webhook_token' => 'xnd_test_token']);
});

test('user can create order with xendit payment method', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create(['price' => 100000]);

    $this->actingAs($user)
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->post(route('checkout.store', $course), [
            'payment_method' => 'xendit',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('course_orders', [
        'user_id' => $user->id,
        'course_id' => $course->id,
        'payment_method' => 'xendit',
        'status' => 'pending',
        'amount' => 100000,
    ]);
});

test('user cannot purchase unpublished course', function () {
    $user = User::factory()->create();
    $course = Course::factory()->draft()->create();

    $this->actingAs($user)
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->post(route('checkout.store', $course), [
            'payment_method' => 'xendit',
        ])
        ->assertNotFound();
});

test('user cannot duplicate paid order', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    $this->actingAs($user)
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->post(route('checkout.store', $course), [
            'payment_method' => 'xendit',
        ])
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('info');
});

test('redirects to existing pending order', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'payment_method' => 'xendit',
    ]);

    $this->actingAs($user)
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->post(route('checkout.store', $course), [
            'payment_method' => 'xendit',
        ])
        ->assertRedirect(route('checkout.pay', $order));
});

test('pay page creates xendit invoice and redirects to payment url', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create(['price' => 150000]);

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'payment_method' => 'xendit',
    ]);

    $this->mock(XenditService::class)
        ->shouldReceive('createInvoice')
        ->once()
        ->andReturn([
            'invoice_id' => 'xnd_invoice_123',
            'invoice_url' => 'https://checkout.xendit.co/invoice/test123',
        ]);

    $this->actingAs($user)
        ->get(route('checkout.pay', $order))
        ->assertRedirect('https://checkout.xendit.co/invoice/test123');

    $this->assertDatabaseHas('course_orders', [
        'id' => $order->id,
        'xendit_invoice_id' => 'xnd_invoice_123',
        'xendit_payment_url' => 'https://checkout.xendit.co/invoice/test123',
    ]);
});

test('user cannot access other user order pay page', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $course = Course::factory()->published()->create();

    $order = CourseOrder::factory()->create([
        'user_id' => $otherUser->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'payment_method' => 'xendit',
    ]);

    $this->actingAs($user)
        ->get(route('checkout.pay', $order))
        ->assertForbidden();
});

test('paid order redirects to dashboard', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('checkout.pay', $order))
        ->assertRedirect(route('dashboard'));
});

test('success redirects to complete page', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'payment_method' => 'xendit',
    ]);

    $this->actingAs($user)
        ->get(route('checkout.success', $order))
        ->assertRedirect(route('checkout.complete', $order));
});

test('complete marks order as paid', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'payment_method' => 'xendit',
    ]);

    $this->actingAs($user)
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->post(route('checkout.complete', $order))
        ->assertRedirect(route('dashboard'));

    $this->assertDatabaseHas('course_orders', [
        'id' => $order->id,
        'status' => 'paid',
    ]);

    expect($order->fresh()->paid_at)->not()->toBeNull();
});

test('webhook marks order as paid', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'order_number' => 'ORD-TEST123',
        'status' => 'pending',
        'payment_method' => 'xendit',
    ]);

    $payload = json_encode([
        'external_id' => 'ORD-TEST123',
        'status' => 'SETTLED',
        'amount' => 100000,
    ]);

    $signature = hash_hmac('sha256', $payload, config('services.xendit.webhook_token'));

    $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->withHeaders([
            'Content-Type' => 'application/json',
            'x-xendit-webhook-token' => $signature,
        ])->post(route('webhooks.xendit'), json_decode($payload, true))
        ->assertOk();

    $this->assertDatabaseHas('course_orders', [
        'id' => $order->id,
        'status' => 'paid',
    ]);
});

test('webhook rejects invalid signature', function () {
    $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->withHeaders([
            'Content-Type' => 'application/json',
            'x-xendit-webhook-token' => 'invalid_signature',
        ])->post(route('webhooks.xendit'), [
            'external_id' => 'ORD-TEST123',
            'status' => 'SETTLED',
        ])->assertUnauthorized();
});

test('webhook ignores non settled payment', function () {
    $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->withHeaders([
            'Content-Type' => 'application/json',
            'x-xendit-webhook-token' => 'valid_signature',
        ])->post(route('webhooks.xendit'), [
            'external_id' => 'ORD-TEST123',
            'status' => 'PENDING',
        ])->assertOk();
});

test('manual transfer payment method still works', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create(['price' => 50000]);

    $this->actingAs($user)
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->post(route('checkout.store', $course), [
            'payment_method' => 'manual_transfer',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('course_orders', [
        'user_id' => $user->id,
        'course_id' => $course->id,
        'payment_method' => 'manual_transfer',
        'status' => 'pending',
    ]);
});

test('invalid payment method rejected', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $this->actingAs($user)
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->post(route('checkout.store', $course), [
            'payment_method' => 'invalid_method',
        ])
        ->assertSessionHasErrors('payment_method');
});
