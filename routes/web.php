<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\CourseController;
use App\Http\Controllers\Back\CourseVideoController;
use App\Http\Controllers\Back\PaymentController;
use App\Http\Controllers\Back\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('lms')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('lms.dashboard');

    Route::resource('/courses', CourseController::class)->names('lms.courses');

    Route::get('/course-video/create/{course}', [CourseVideoController::class, 'createVideo'])->name('lms.videos.create_video');

    Route::resource('/course-video', CourseVideoController::class)
    ->except(['create'])
    ->names('lms.videos');

    Route::put('/payments/{payment}/approved', [PaymentController::class, 'approvedCourse'])->name('lms.payments.approved');
    Route::resource('/payments', PaymentController::class)->names('lms.payments');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
