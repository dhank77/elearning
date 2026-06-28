<?php

use App\Models\Course;
use App\Models\CourseOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('student can view their own orders', function () {
    $student = User::factory()->create(['role' => 'student']);
    $otherStudent = User::factory()->create(['role' => 'student']);
    $course1 = Course::factory()->create(['title' => 'My Course 1']);
    $course2 = Course::factory()->create(['title' => 'Other Course']);

    $order1 = CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course1->id,
        'amount' => 100000,
        'status' => 'pending',
        'order_number' => 'ORD-MY-1',
    ]);

    $order2 = CourseOrder::factory()->create([
        'user_id' => $otherStudent->id,
        'course_id' => $course2->id,
        'amount' => 200000,
        'status' => 'paid',
        'order_number' => 'ORD-OTHER-2',
    ]);

    $response = $this->actingAs($student)->get(route('student.orders.index'));

    $response->assertSuccessful();
    $response->assertSee('My Course 1');
    $response->assertSee('ORD-MY-1');
    $response->assertSee('Rp 100.000');
    $response->assertSee('Menunggu');
    $response->assertSee('Bayar');

    $response->assertDontSee('Other Course');
    $response->assertDontSee('ORD-OTHER-2');
});

test('guests cannot view student orders list', function () {
    $response = $this->get(route('student.orders.index'));

    $response->assertRedirect(route('login'));
});
