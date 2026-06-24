<?php

use App\Models\Coupon;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        'content_type' => 'youtube',
        'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
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

test('teachers can update module titles', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create();
    $module = $course->modules()->create([
        'title' => 'Old Module',
        'position' => 1,
    ]);

    $this->actingAs($teacher)
        ->patch(route('teacher.course-settings.modules.update', $module), [
            'title' => 'Updated Module',
        ])
        ->assertRedirect(route('teacher.course-settings', ['course' => $course]));

    expect($module->refresh()->title)->toBe('Updated Module');
});

test('teachers can move modules', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create();
    $firstModule = $course->modules()->create([
        'title' => 'First Module',
        'position' => 1,
    ]);
    $secondModule = $course->modules()->create([
        'title' => 'Second Module',
        'position' => 2,
    ]);

    $this->actingAs($teacher)
        ->patch(route('teacher.course-settings.modules.move', [$secondModule, 'up']))
        ->assertRedirect(route('teacher.course-settings', ['course' => $course]));

    expect($secondModule->refresh()->position)->toBe(1)
        ->and($firstModule->refresh()->position)->toBe(2);
});

test('teachers can update course settings with a cover image', function () {
    Storage::fake('public');

    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create([
        'title' => 'Old Course Title',
        'description' => '<p>Old description</p>',
    ]);

    $this->actingAs($teacher)
        ->patch(route('teacher.course-settings.settings.update', $course), [
            'title' => 'Updated Course Title',
            'description' => '<p>Updated description</p>',
            'cover_image' => UploadedFile::fake()->image('cover.png', 1200, 675),
        ])
        ->assertRedirect(route('teacher.course-settings', ['course' => $course, 'tab' => 'settings']));

    $course->refresh();

    expect($course->title)->toBe('Updated Course Title')
        ->and($course->description)->toBe('<p>Updated description</p>')
        ->and($course->cover_image_path)->not->toBeNull();

    Storage::disk('public')->assertExists($course->cover_image_path);
});

test('course cover image must be an image file', function () {
    Storage::fake('public');

    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create();

    $this->actingAs($teacher)
        ->from(route('teacher.course-settings', ['course' => $course, 'tab' => 'settings']))
        ->patch(route('teacher.course-settings.settings.update', $course), [
            'title' => $course->title,
            'description' => '<p>Description</p>',
            'cover_image' => UploadedFile::fake()->create('notes.pdf', 100, 'application/pdf'),
        ])
        ->assertRedirect(route('teacher.course-settings', ['course' => $course, 'tab' => 'settings']))
        ->assertSessionHasErrors('cover_image');

    expect($course->refresh()->cover_image_path)->toBeNull();
});

test('teachers can update lesson content', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create();
    $module = $course->modules()->create([
        'title' => 'Module',
        'position' => 1,
    ]);
    $lesson = $module->lessons()->create([
        'title' => 'Old Lesson',
        'content_type' => 'youtube',
        'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'position' => 1,
    ]);

    $this->actingAs($teacher)
        ->patch(route('teacher.course-settings.lessons.update', $lesson), [
            'title' => 'Updated Lesson',
            'youtube_url' => 'https://youtu.be/dQw4w9WgXcQ',
        ])
        ->assertRedirect(route('teacher.course-settings', [
            'course' => $course,
            'open_module' => $module,
        ]).'#module-'.$module->id);

    $lesson->refresh();

    expect($lesson->title)->toBe('Updated Lesson')
        ->and($lesson->content_type)->toBe('youtube')
        ->and($lesson->metadata)->toBe('https://youtu.be/dQw4w9WgXcQ');
});

test('teachers can add youtube lessons only', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create();
    $module = $course->modules()->create([
        'title' => 'Module',
        'position' => 1,
    ]);

    $this->actingAs($teacher)
        ->post(route('teacher.course-settings.lessons.store', $module), [
            'title' => 'YouTube Lesson',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ])
        ->assertRedirect(route('teacher.course-settings', [
            'course' => $course,
            'open_module' => $module,
        ]).'#module-'.$module->id);

    $lesson = $module->lessons()->first();

    expect($lesson->title)->toBe('YouTube Lesson')
        ->and($lesson->content_type)->toBe('youtube')
        ->and($lesson->metadata)->toBe('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
});

test('teachers cannot add non youtube lesson links', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create();
    $module = $course->modules()->create([
        'title' => 'Module',
        'position' => 1,
    ]);

    $this->actingAs($teacher)
        ->from(route('teacher.course-settings', ['course' => $course]))
        ->post(route('teacher.course-settings.lessons.store', $module), [
            'title' => 'External Lesson',
            'youtube_url' => 'https://vimeo.com/example',
        ])
        ->assertRedirect(route('teacher.course-settings', ['course' => $course]))
        ->assertSessionHasErrors('youtube_url');

    expect($module->lessons()->count())->toBe(0);
});

test('teachers return to the opened module after deleting lesson content', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create();
    $module = $course->modules()->create([
        'title' => 'Module',
        'position' => 1,
    ]);
    $lesson = $module->lessons()->create([
        'title' => 'Lesson to Delete',
        'content_type' => 'youtube',
        'metadata' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'position' => 1,
    ]);

    $this->actingAs($teacher)
        ->delete(route('teacher.course-settings.lessons.destroy', $lesson))
        ->assertRedirect(route('teacher.course-settings', [
            'course' => $course,
            'open_module' => $module,
        ]).'#module-'.$module->id);

    expect($module->lessons()->whereKey($lesson)->exists())->toBeFalse();
});

test('teachers can update course pricing with a valid coupon', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create([
        'price' => 0,
    ]);
    $coupon = Coupon::create([
        'code' => 'PROMO50',
        'discount_percentage' => 50.00,
        'is_active' => true,
    ]);

    $this->actingAs($teacher)
        ->patch(route('teacher.course-settings.pricing.update', $course), [
            'price' => 200000,
            'promo_code' => 'PROMO50',
        ])
        ->assertRedirect(route('teacher.course-settings', ['course' => $course, 'tab' => 'pricing']));

    $course->refresh();

    expect($course->price)->toEqual(200000)
        ->and($course->coupon_id)->toBe($coupon->id);
});

test('teachers cannot update course pricing with invalid coupon', function () {
    $teacher = User::factory()->create([
        'role' => 'teacher',
    ]);
    $course = Course::factory()->for($teacher, 'teacher')->create([
        'price' => 0,
    ]);

    $this->actingAs($teacher)
        ->from(route('teacher.course-settings', ['course' => $course, 'tab' => 'pricing']))
        ->patch(route('teacher.course-settings.pricing.update', $course), [
            'price' => 200000,
            'promo_code' => 'INVALIDCODE',
        ])
        ->assertRedirect(route('teacher.course-settings', ['course' => $course, 'tab' => 'pricing']))
        ->assertSessionHasErrors('promo_code');

    $course->refresh();

    expect($course->price)->toEqual(0)
        ->and($course->coupon_id)->toBeNull();
});
