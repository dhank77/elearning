<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests can view published course detail page', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $course = Course::factory()->for($teacher, 'teacher')->published()->create([
        'title' => 'Test Course',
        'description' => 'This is a test course description.',
    ]);

    $module = $course->modules()->create([
        'title' => 'Module 1',
        'position' => 1,
    ]);

    $module->lessons()->create([
        'title' => 'Lesson 1',
        'content_type' => 'youtube',
        'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'position' => 1,
    ]);

    $response = $this->get(route('courses.show', $course));

    $response->assertSuccessful();
    $response->assertSee('Test Course');
    $response->assertSee('This is a test course description.');
    $response->assertSee('Module 1');
    $response->assertSee('Lesson 1');
});

test('guests cannot view draft course detail page', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $course = Course::factory()->for($teacher, 'teacher')->draft()->create([
        'title' => 'Draft Course',
    ]);

    $response = $this->get(route('courses.show', $course));

    $response->assertNotFound();
});
