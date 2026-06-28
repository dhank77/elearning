<?php

use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseOrder;
use App\Models\User;
use App\Services\FonnteService;
use App\Services\XenditService;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Xendit\Invoice\Invoice;
use Xendit\Invoice\InvoiceStatus;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    config(['services.xendit.api_key' => 'xnd_test_key']);
    config(['services.xendit.webhook_token' => 'xnd_test_token']);
    config(['services.xendit.callback_token' => 'xnd_test_callback_token']);
});

test('xendit service verifies callback token', function () {
    $service = new XenditService;

    expect($service->verifyCallback('xnd_test_callback_token'))->toBeTrue();
    expect($service->verifyCallback('wrong-token'))->toBeFalse();
});

test('user can create order with xendit payment method', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create(['price' => 100000]);

    $this->actingAs($user)
        ->withoutMiddleware([ValidateCsrfToken::class])
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

test('user can create order with applied coupon discount', function () {
    $user = User::factory()->create();
    $teacher = User::factory()->create(['role' => 'teacher']);
    $coupon = Coupon::create([
        'code' => 'DISCOUNT30',
        'discount_percentage' => 30.00,
        'is_active' => true,
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->published()->create([
        'price' => 100000,
        'coupon_id' => $coupon->id,
    ]);

    $this->actingAs($user)
        ->withoutMiddleware([ValidateCsrfToken::class])
        ->post(route('checkout.store', $course), [
            'payment_method' => 'xendit',
            'promo_code' => 'DISCOUNT30',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('course_orders', [
        'user_id' => $user->id,
        'course_id' => $course->id,
        'payment_method' => 'xendit',
        'status' => 'pending',
        'amount' => 70000,
    ]);
});

test('user cannot purchase unpublished course', function () {
    $user = User::factory()->create();
    $course = Course::factory()->draft()->create();

    $this->actingAs($user)
        ->withoutMiddleware([ValidateCsrfToken::class])
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
        ->withoutMiddleware([ValidateCsrfToken::class])
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
        ->withoutMiddleware([ValidateCsrfToken::class])
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

test('success redirects to dashboard when already paid', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('checkout.success', $order))
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('success');
});

test('success for pending xendit order redirects to dashboard with info when xendit api returns pending', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'payment_method' => 'xendit',
        'xendit_invoice_id' => 'xnd_123',
    ]);

    $invoiceMock = Mockery::mock(Invoice::class);
    $invoiceStatusMock = Mockery::mock(InvoiceStatus::class);
    $invoiceStatusMock->shouldReceive('__toString')->andReturn('PENDING');
    $invoiceMock->shouldReceive('getStatus')->andReturn($invoiceStatusMock);

    $this->mock(XenditService::class)
        ->shouldReceive('getInvoice')
        ->with('xnd_123')
        ->once()
        ->andReturn($invoiceMock);

    $this->actingAs($user)
        ->get(route('checkout.success', $order))
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('info');

    $this->assertDatabaseHas('course_orders', [
        'id' => $order->id,
        'status' => 'pending',
    ]);
});

test('success for pending xendit order updates status and redirects to dashboard with success when xendit api returns paid', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'payment_method' => 'xendit',
        'xendit_invoice_id' => 'xnd_123',
    ]);

    $invoiceMock = Mockery::mock(Invoice::class);
    $invoiceStatusMock = Mockery::mock(InvoiceStatus::class);
    $invoiceStatusMock->shouldReceive('__toString')->andReturn('PAID');
    $invoiceMock->shouldReceive('getStatus')->andReturn($invoiceStatusMock);

    $this->mock(XenditService::class)
        ->shouldReceive('getInvoice')
        ->with('xnd_123')
        ->once()
        ->andReturn($invoiceMock);

    $this->actingAs($user)
        ->get(route('checkout.success', $order))
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('course_orders', [
        'id' => $order->id,
        'status' => 'paid',
    ]);
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

    $payload = [
        'external_id' => 'ORD-TEST123',
        'status' => 'SETTLED',
        'amount' => 100000,
    ];

    $response = $this->withoutMiddleware([ValidateCsrfToken::class])
        ->postJson(route('webhooks.xendit'), $payload, [
            'x-callback-token' => config('services.xendit.callback_token'),
        ]);

    $response->assertOk();

    $this->assertDatabaseHas('course_orders', [
        'id' => $order->id,
        'status' => 'paid',
    ]);
});

test('webhook rejects invalid signature', function () {
    $payload = [
        'external_id' => 'ORD-TEST123',
        'status' => 'SETTLED',
    ];

    $response = $this->withoutMiddleware([ValidateCsrfToken::class])
        ->postJson(route('webhooks.xendit'), $payload, [
            'x-callback-token' => 'invalid_callback_token',
        ]);

    $response->assertForbidden()
        ->assertJson([
            'success' => false,
            'message' => 'Invalid callback token',
        ]);
});

test('webhook ignores non settled payment', function () {
    $payload = [
        'external_id' => 'ORD-TEST123',
        'status' => 'PENDING',
    ];

    $response = $this->withoutMiddleware([ValidateCsrfToken::class])
        ->postJson(route('webhooks.xendit'), $payload, [
            'x-callback-token' => config('services.xendit.callback_token'),
        ]);

    $response->assertOk();
});

test('manual transfer payment method still works', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create(['price' => 50000]);

    $this->actingAs($user)
        ->withoutMiddleware([ValidateCsrfToken::class])
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

test('free course auto-enrolls without payment', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create(['price' => 0]);

    $this->actingAs($user)
        ->withoutMiddleware([ValidateCsrfToken::class])
        ->post(route('checkout.store', $course), [
            'payment_method' => 'xendit',
        ])
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('course_orders', [
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'paid',
        'payment_method' => 'free',
        'amount' => 0,
    ]);
});

test('pay page auto-completes zero-amount pending order', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create(['price' => 0]);

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'amount' => 0,
        'payment_method' => 'xendit',
    ]);

    $this->actingAs($user)
        ->get(route('checkout.pay', $order))
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('course_orders', [
        'id' => $order->id,
        'status' => 'paid',
        'payment_method' => 'free',
    ]);
});

test('invalid payment method rejected', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create();

    $this->actingAs($user)
        ->withoutMiddleware([ValidateCsrfToken::class])
        ->post(route('checkout.store', $course), [
            'payment_method' => 'invalid_method',
        ])
        ->assertSessionHasErrors('payment_method');
});

test('order updates to paid sends whatsapp notification via fonnte', function () {
    config(['services.fonnte.token' => 'test_fonnte_token']);

    $user = User::factory()->create(['phone' => '08123456789']);
    $course = Course::factory()->published()->create(['title' => 'Laravel Masterclass']);

    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'payment_method' => 'xendit',
        'amount' => 150000,
    ]);

    $this->mock(FonnteService::class)
        ->shouldReceive('sendMessage')
        ->once()
        ->withArgs(function ($target, $message) {
            return $target === '08123456789'
                && str_contains($message, 'Pembayaran Anda untuk kelas *Laravel Masterclass* telah berhasil dikonfirmasi');
        })
        ->andReturn(true);

    $order->update(['status' => 'paid']);
});

test('user can apply coupon to pending order', function () {
    $user = User::factory()->create();
    $course = Course::factory()->published()->create(['price' => 100000]);
    $order = CourseOrder::factory()->create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'amount' => 100000,
        'payment_method' => 'manual_transfer',
    ]);

    $coupon = Coupon::create([
        'code' => 'PROMO30',
        'discount_percentage' => 30.00,
        'is_active' => true,
    ]);

    $this->actingAs($user)
        ->withoutMiddleware([ValidateCsrfToken::class])
        ->post(route('checkout.apply-coupon', $order), [
            'coupon_code' => 'PROMO30',
        ])
        ->assertRedirect();

    $order->refresh();
    expect($order->amount)->toEqual(70000);
});
