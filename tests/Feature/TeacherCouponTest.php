<?php

use App\Models\Coupon;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('teacher can view only their coupons', function () {
    $teacher1 = User::factory()->create(['role' => 'teacher']);
    $teacher2 = User::factory()->create(['role' => 'teacher']);

    $course1 = Course::factory()->for($teacher1, 'teacher')->create();
    $course2 = Course::factory()->for($teacher2, 'teacher')->create();

    $coupon1 = Coupon::create(['code' => 'TEACHER1CPN', 'discount_percentage' => 10]);
    $coupon2 = Coupon::create(['code' => 'TEACHER2CPN', 'discount_percentage' => 20]);

    $course1->update(['coupon_id' => $coupon1->id]);
    $course2->update(['coupon_id' => $coupon2->id]);

    $this->actingAs($teacher1)
        ->get(route('teacher.coupons.index'))
        ->assertSuccessful()
        ->assertSee('TEACHER1CPN')
        ->assertDontSee('TEACHER2CPN');
});

test('teacher can create coupon and associate with their course', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $course = Course::factory()->for($teacher, 'teacher')->create();

    $this->actingAs($teacher)
        ->post(route('teacher.coupons.store'), [
            'course_id' => $course->id,
            'code' => 'NEWCOUPON',
            'discount_percentage' => 15,
            'description' => 'Test Coupon Description',
            'is_active' => true,
        ])
        ->assertRedirect(route('teacher.coupons.index'));

    $this->assertDatabaseHas('coupons', [
        'code' => 'NEWCOUPON',
        'discount_percentage' => 15,
    ]);

    $coupon = Coupon::where('code', 'NEWCOUPON')->first();
    $course->refresh();

    expect($course->coupon_id)->toBe($coupon->id);
});

test('teacher cannot create coupon for other teacher course', function () {
    $teacher1 = User::factory()->create(['role' => 'teacher']);
    $teacher2 = User::factory()->create(['role' => 'teacher']);
    $courseOfTeacher2 = Course::factory()->for($teacher2, 'teacher')->create();

    $this->actingAs($teacher1)
        ->post(route('teacher.coupons.store'), [
            'course_id' => $courseOfTeacher2->id,
            'code' => 'BADCOUPON',
            'discount_percentage' => 15,
        ])
        ->assertSessionHasErrors('course_id');
});

test('teacher can update coupon and change course association', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $course1 = Course::factory()->for($teacher, 'teacher')->create();
    $course2 = Course::factory()->for($teacher, 'teacher')->create();

    $coupon = Coupon::create(['code' => 'OLDCODE', 'discount_percentage' => 10]);
    $course1->update(['coupon_id' => $coupon->id]);

    $this->actingAs($teacher)
        ->put(route('teacher.coupons.update', $coupon), [
            'course_id' => $course2->id,
            'code' => 'NEWCODE',
            'discount_percentage' => 20,
        ])
        ->assertRedirect(route('teacher.coupons.index'));

    $coupon->refresh();
    $course1->refresh();
    $course2->refresh();

    expect($coupon->code)->toBe('NEWCODE')
        ->and($coupon->discount_percentage)->toEqual(20)
        ->and($course1->coupon_id)->toBeNull()
        ->and($course2->coupon_id)->toBe($coupon->id);
});

test('teacher cannot edit or update other teacher coupon', function () {
    $teacher1 = User::factory()->create(['role' => 'teacher']);
    $teacher2 = User::factory()->create(['role' => 'teacher']);

    $course2 = Course::factory()->for($teacher2, 'teacher')->create();
    $coupon2 = Coupon::create(['code' => 'COUPON2', 'discount_percentage' => 20]);
    $course2->update(['coupon_id' => $coupon2->id]);

    $this->actingAs($teacher1)
        ->get(route('teacher.coupons.edit', $coupon2))
        ->assertForbidden();

    $this->actingAs($teacher1)
        ->put(route('teacher.coupons.update', $coupon2), [
            'course_id' => $course2->id,
            'code' => 'COUPON2EDIT',
            'discount_percentage' => 25,
        ])
        ->assertForbidden();
});

test('teacher can delete coupon', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);
    $course = Course::factory()->for($teacher, 'teacher')->create();
    $coupon = Coupon::create(['code' => 'DELCOUPON', 'discount_percentage' => 10]);
    $course->update(['coupon_id' => $coupon->id]);

    $this->actingAs($teacher)
        ->delete(route('teacher.coupons.destroy', $coupon))
        ->assertRedirect(route('teacher.coupons.index'));

    $this->assertDatabaseMissing('coupons', ['id' => $coupon->id]);
    $course->refresh();
    expect($course->coupon_id)->toBeNull();
});
