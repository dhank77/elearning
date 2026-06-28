<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CourseOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\StudentOrderController;
use App\Http\Controllers\Teacher\CourseSettingsController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Webhook\XenditWebhookController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/courses/{course}', [WelcomeController::class, 'show'])->name('courses.show');
Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');
Route::post('/chatbot/stream', [ChatbotController::class, 'stream'])->name('chatbot.stream');

// Xendit webhook (no auth required - verified via signature)
// Route::post('webhooks/xendit', XenditWebhookController::class)->name('webhooks.xendit');

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::post('checkout/{course}', [CourseOrderController::class, 'store'])->name('checkout.store');
    Route::get('checkout/{order}/pay', [CourseOrderController::class, 'pay'])->name('checkout.pay');
    Route::get('checkout/{order}/success', [CourseOrderController::class, 'success'])->name('checkout.success');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('my-courses', [StudentCourseController::class, 'index'])->name('student.courses');
    Route::get('my-orders', [StudentOrderController::class, 'index'])->name('student.orders.index');
    Route::get('learn/{course}/{lesson?}', [StudentCourseController::class, 'show'])->name('student.learn');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('coupons', CouponController::class)->except(['show']);
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
});

Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('course-settings', [CourseSettingsController::class, 'index'])->name('course-settings');
    Route::post('course-settings', [CourseSettingsController::class, 'store'])->name('course-settings.store');
    Route::patch('course-settings/{course}/settings', [CourseSettingsController::class, 'updateSettings'])->name('course-settings.settings.update');
    Route::patch('course-settings/{course}/pricing', [CourseSettingsController::class, 'updatePricing'])->name('course-settings.pricing.update');
    Route::patch('course-settings/{course}/draft', [CourseSettingsController::class, 'saveDraft'])->name('course-settings.draft');
    Route::patch('course-settings/{course}/publish', [CourseSettingsController::class, 'publish'])->name('course-settings.publish');
    Route::post('course-settings/{course}/modules', [CourseSettingsController::class, 'storeModule'])->name('course-settings.modules.store');
    Route::post('course-settings/{course}/modules/generate', [CourseSettingsController::class, 'autoGenerateModule'])->name('course-settings.modules.generate');
    Route::patch('course-settings/modules/{module}', [CourseSettingsController::class, 'updateModule'])->name('course-settings.modules.update');
    Route::patch('course-settings/modules/{module}/move/{direction}', [CourseSettingsController::class, 'moveModule'])->name('course-settings.modules.move');
    Route::delete('course-settings/modules/{module}', [CourseSettingsController::class, 'destroyModule'])->name('course-settings.modules.destroy');
    Route::post('course-settings/modules/{module}/lessons', [CourseSettingsController::class, 'storeLesson'])->name('course-settings.lessons.store');
    Route::patch('course-settings/lessons/{lesson}', [CourseSettingsController::class, 'updateLesson'])->name('course-settings.lessons.update');
    Route::delete('course-settings/lessons/{lesson}', [CourseSettingsController::class, 'destroyLesson'])->name('course-settings.lessons.destroy');
    Route::get('students', [StudentController::class, 'index'])->name('students');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);

    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
});
