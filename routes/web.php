<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\CourseController;
use App\Http\Controllers\Back\CourseVideoController;
use App\Http\Controllers\Back\PaymentController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\MenteeController;
use App\Http\Controllers\Back\MentorController;
use App\Http\Controllers\Back\UserCourseController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('lms')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('lms.dashboard')
    ->middleware('access:owner');

    Route::resource('/courses', CourseController::class)
    ->names('lms.courses')
    ->middleware('access:owner,mentor,mentee');

    Route::get('/course-video/create/{course}', [CourseVideoController::class, 'createVideo'])
    ->name('lms.videos.create_video')
    ->middleware('access:owner,mentor');

    Route::resource('/course-video', CourseVideoController::class)
    ->except(['create'])
    ->names('lms.videos');

    Route::resource('/mentors', MentorController::class)
    ->except(['show'])
    ->names('lms.mentors')
    ->middleware('access:owner,mentor');

    Route::resource('/mentees', MenteeController::class)
    ->except(['show'])
    ->names('lms.mentees')
    ->middleware('access:owner');

    Route::put('/payments/{payment}/approved', [PaymentController::class, 'approvedCourse'])->name('lms.payments.approved');
    Route::get('/payments/{payment}/process', [PaymentController::class, 'paymentCourse'])->name('lms.payments.process');
    Route::resource('/payments', PaymentController::class)
    ->except('create', 'edit', 'update')
    ->names('lms.payments')
    ->middleware('access:owner,mentee');

    Route::get('/charts/{user}', [UserCourseController::class, 'chart'])->name('lms.charts');
    Route::post('/courses/buy/{course}', [UserCourseController::class, 'buy'])->name('lms.courses.buy');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
