<?php

use App\Models\Course;
use App\Models\CourseModule;
use App\Models\CourseOrder;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows student dashboard with enrolled courses from paid orders', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'user']);

    $course = Course::factory()->create([
        'teacher_id' => $teacher->id,
        'status' => 'published',
        'price' => 100000,
    ]);

    $order = CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'paid',
        'amount' => 100000,
        'paid_at' => now(),
    ]);

    $response = $this->actingAs($student)->get(route('dashboard'));

    $response->assertOk();
    $response->assertViewHas('enrolledCourses');
    $response->assertViewHas('paidOrders');
    $response->assertViewHas('totalSpent', 100000);
    $response->assertSee($course->title);
    $response->assertSee($order->order_number);
});

it('shows empty state when student has no paid orders', function () {
    $student = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($student)->get(route('dashboard'));

    $response->assertOk();
    $response->assertViewHas('enrolledCourses');
    $response->assertSee('Belum ada kursus yang dibeli');
});

it('does not show unpaid orders as enrolled courses', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'user']);

    $course = Course::factory()->create([
        'teacher_id' => $teacher->id,
        'status' => 'published',
        'price' => 50000,
    ]);

    CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'pending',
        'amount' => 50000,
    ]);

    $response = $this->actingAs($student)->get(route('dashboard'));

    $response->assertOk();
    $response->assertViewHas('totalSpent', 0);
    $response->assertSee('Belum ada kursus yang dibeli');
});

it('shows recommended courses excluding enrolled ones', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'user']);

    $enrolledCourse = Course::factory()->create([
        'teacher_id' => $teacher->id,
        'status' => 'published',
        'title' => 'Enrolled Course',
        'price' => 75000,
    ]);

    $recommendedCourse = Course::factory()->create([
        'teacher_id' => $teacher->id,
        'status' => 'published',
        'title' => 'Recommended Course',
        'price' => 50000,
    ]);

    CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $enrolledCourse->id,
        'status' => 'paid',
        'amount' => 75000,
        'paid_at' => now(),
    ]);

    $response = $this->actingAs($student)->get(route('dashboard'));

    $response->assertOk();
    $response->assertViewHas('recommendedCourses');
    $recommendedCourses = $response->viewData('recommendedCourses');
    expect($recommendedCourses->pluck('id')->contains($enrolledCourse->id))->toBeFalse();
    expect($recommendedCourses->pluck('id')->contains($recommendedCourse->id))->toBeTrue();
});

it('redirects admin to categories index', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('dashboard'));

    $response->assertRedirect(route('categories.index'));
});

it('shows teacher dashboard for teacher role', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);

    $response = $this->actingAs($teacher)->get(route('dashboard'));

    $response->assertOk();
    $response->assertViewIs('teacher-dashboard');
});

it('shows student my-courses page with enrolled courses', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'user']);

    $course = Course::factory()->create([
        'teacher_id' => $teacher->id,
        'status' => 'published',
        'price' => 100000,
    ]);

    $order = CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'paid',
        'amount' => 100000,
        'paid_at' => now(),
    ]);

    $response = $this->actingAs($student)->get(route('student.courses'));

    $response->assertOk();
    $response->assertViewIs('student.my-courses');
    $response->assertViewHas('enrolledCourses');
    $response->assertViewHas('totalSpent', 100000);
    $response->assertSee($course->title);
});

it('shows empty state on my-courses when no enrolled courses', function () {
    $student = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($student)->get(route('student.courses'));

    $response->assertOk();
    $response->assertSee('Belum ada kursus yang dibeli');
    $response->assertSee('Jelajahi Kursus');
});

it('shows learning page for enrolled student with YouTube lesson', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'user']);

    $course = Course::factory()->create([
        'teacher_id' => $teacher->id,
        'status' => 'published',
    ]);

    $module = CourseModule::factory()->create([
        'course_id' => $course->id,
        'title' => 'Modul Pertama',
    ]);

    $lesson = Lesson::factory()->create([
        'course_module_id' => $module->id,
        'title' => 'Video Pengantar',
        'content_type' => 'youtube',
        'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'position' => 1,
    ]);

    CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'paid',
        'amount' => 100000,
        'paid_at' => now(),
    ]);

    $response = $this->actingAs($student)->get(route('student.learn', $course));

    $response->assertOk();
    $response->assertViewIs('student.learn');
    $response->assertViewHas('course');
    $response->assertViewHas('activeLesson');
    $response->assertViewHas('youtubeId', 'dQw4w9WgXcQ');
    $response->assertSee('Video Pengantar');
    $response->assertSee('Modul Pertama');
    $response->assertSee('youtube.com/embed/dQw4w9WgXcQ');
});

it('denies access to learning page for non-enrolled users', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'user']);

    $course = Course::factory()->create([
        'teacher_id' => $teacher->id,
        'status' => 'published',
    ]);

    $response = $this->actingAs($student)->get(route('student.learn', $course));

    $response->assertForbidden();
});

it('shows learning page with navigation between lessons', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'user']);

    $course = Course::factory()->create([
        'teacher_id' => $teacher->id,
        'status' => 'published',
    ]);

    $module = CourseModule::factory()->create([
        'course_id' => $course->id,
        'title' => 'Modul',
    ]);

    $lesson1 = Lesson::factory()->create([
        'course_module_id' => $module->id,
        'title' => 'Lesson One',
        'content_type' => 'youtube',
        'metadata' => 'https://www.youtube.com/watch?v=aaa111bbb22',
        'position' => 1,
    ]);

    $lesson2 = Lesson::factory()->create([
        'course_module_id' => $module->id,
        'title' => 'Lesson Two',
        'content_type' => 'youtube',
        'metadata' => 'https://www.youtube.com/watch?v=ccc333ddd44',
        'position' => 2,
    ]);

    CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'paid',
        'amount' => 100000,
        'paid_at' => now(),
    ]);

    $response = $this->actingAs($student)->get(route('student.learn', ['course' => $course, 'lesson' => $lesson1->id]));

    $response->assertOk();
    $response->assertSee('Lesson One');
    $response->assertSee('Lesson Two');
    $response->assertSee('Selanjutnya');
    $response->assertDontSee('Sebelumnya');

    $response = $this->actingAs($student)->get(route('student.learn', ['course' => $course, 'lesson' => $lesson2->id]));
    $response->assertSee('Sebelumnya');
});

it('shows empty state when course has no modules', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $student = User::factory()->create(['role' => 'user']);

    $course = Course::factory()->create([
        'teacher_id' => $teacher->id,
        'status' => 'published',
    ]);

    CourseOrder::factory()->create([
        'user_id' => $student->id,
        'course_id' => $course->id,
        'status' => 'paid',
        'amount' => 100000,
        'paid_at' => now(),
    ]);

    $response = $this->actingAs($student)->get(route('student.learn', $course));

    $response->assertOk();
    $response->assertSee('belum memiliki materi');
});
