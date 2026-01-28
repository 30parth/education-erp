<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::livewire('/login', 'auth.login')->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::livewire('/change-password', 'auth.change-password')->name('change-password');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::livewire('/', 'admin.dashboard')->name('dashboard');

            Route::livewire('/semester', 'admin.semester.semester-list')->name('semester.list');

            Route::livewire('/subject', 'admin.subject.subject-list')->name('subject.list');
        });
    });

    // Teacher Routes
    Route::middleware('role:teacher')->group(function () {
        Route::livewire('/teacher', 'teacher.dashboard')->name('teacher.dashboard');
    });

    // Student Routes
    Route::middleware('role:student')->group(function () {
        Route::livewire('/student', 'student.dashboard')->name('student.dashboard');
    });
});
