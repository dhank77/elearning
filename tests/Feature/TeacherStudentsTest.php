<?php

use App\Models\Course;
use App\Models\CourseOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('teachers can view dedicated students page with empty state', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);

    $response = $this->actingAs($teacher)->get(route('teacher.students'));

    $response->assertSuccessful();
    $response->assertSee('No Students Enrolled');
});

test('teachers can see enrolled students list with student details', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);

    $course = Course::factory()->for($teacher, 'teacher')->create([
        'title' => 'Laravel Mastery',
    ]);

    $student = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'phone' => '081234567890',
    ]);

    CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'paid',
    ]);

    $response = $this->actingAs($teacher)->get(route('teacher.students'));

    $response->assertSuccessful();
    $response->assertSee('John Doe');
    $response->assertSee('johndoe@example.com');
    $response->assertSee('081234567890');
    $response->assertSee('Laravel Mastery');
});

test('students cannot view dedicated teacher students page', function () {
    $student = User::factory()->create([
        'role' => 'student',
    ]);

    $response = $this->actingAs($student)->get(route('teacher.students'));

    $response->assertForbidden();
});

test('guests cannot view dedicated teacher students page', function () {
    $response = $this->get(route('teacher.students'));

    $response->assertRedirect(route('login'));
});
