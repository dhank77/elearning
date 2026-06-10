<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('teachers can view course settings', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);

    $course = Course::factory()
        ->for($teacher, 'teacher')
        ->published()
        ->create([
            'title' => 'Dynamic UX Course',
        ]);

    $module = $course->modules()->create([
        'title' => 'Module 1: Dynamic Curriculum',
        'position' => 1,
    ]);

    $module->lessons()->create([
        'title' => '1.1 Dynamic Lesson',
        'content_type' => 'video',
        'metadata' => '09:00 Video',
        'position' => 1,
    ]);

    $response = $this->actingAs($teacher)->get(route('teacher.course-settings', ['course' => $course]));

    $response->assertSuccessful();
    $response->assertSee('Course Management');
    $response->assertSee('Dynamic UX Course');
    $response->assertSee('Module 1: Dynamic Curriculum');
    $response->assertSee('1.1 Dynamic Lesson');
});

test('students cannot view teacher course settings', function () {
    $student = User::factory()->create();

    $response = $this->actingAs($student)->get(route('teacher.course-settings'));

    $response->assertForbidden();
});

test('teachers can add modules to their courses', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create();

    $this->actingAs($teacher)
        ->post(route('teacher.course-settings.modules.store', $course))
        ->assertRedirect(route('teacher.course-settings', ['course' => $course]));

    expect($course->modules()->count())->toBe(1);
});
