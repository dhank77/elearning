<?php

use App\Models\Course;
use App\Models\CourseOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can view orders list', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $student = User::factory()->create(['role' => 'student', 'name' => 'Ahmad Student']);
    $course = Course::factory()->create(['title' => 'Advanced PHP Laravel']);

    $order = CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'amount' => 150000,
        'status' => 'paid',
        'order_number' => 'ORD-12345',
        'payment_method' => 'xendit',
    ]);

    $response = $this->actingAs($admin)->get(route('orders.index'));

    $response->assertSuccessful();
    $response->assertSee('Ahmad Student');
    $response->assertSee('Advanced PHP Laravel');
    $response->assertSee('ORD-12345');
    $response->assertSee('Rp 150.000');
    $response->assertSee('Berhasil');
});

test('non-admin cannot view admin orders list', function () {
    $student = User::factory()->create(['role' => 'student']);

    $response = $this->actingAs($student)->get(route('orders.index'));

    $response->assertForbidden();
});

test('guests cannot view admin orders list', function () {
    $response = $this->get(route('orders.index'));

    $response->assertRedirect(route('login'));
});
