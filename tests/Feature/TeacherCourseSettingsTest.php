<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('teachers can view course settings', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);

    $response = $this->actingAs($teacher)->get(route('teacher.course-settings'));

    $response->assertSuccessful();
    $response->assertSee('Course Settings');
});

test('students cannot view teacher course settings', function () {
    $student = User::factory()->create();

    $response = $this->actingAs($student)->get(route('teacher.course-settings'));

    $response->assertForbidden();
});
