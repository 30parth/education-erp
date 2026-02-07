<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::livewire('/login', 'auth.login')->name('login');

    // Error Page Routes
    Route::view('/page-not-found', 'errors.404')->name('page.not.found');
    Route::view('/access-denied', 'errors.403')->name('access.denied');
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

            Route::get('/student/export', [\App\Http\Controllers\Admin\StudentController::class, 'export'])->name('student.export');
            Route::livewire('/student', 'admin.student.student-list')->name('student.list');

            Route::livewire('/teacher', 'admin.teacher.teacher-list')->name('teacher.list');

            Route::livewire('/division', 'admin.division.division-list')->name('division.list');

            Route::prefix('timetable')->name('timetable.')->group(function () {
                Route::livewire('/', 'admin.time-table.time-tabel-list')->name('list');
                Route::livewire('/create', 'admin.time-table.time-tabel-form')->name('create');
            });
        });
    });

    // Teacher Routes
    Route::middleware('role:teacher')->group(function () {
        Route::prefix('teacher')->name('teacher.')->group(function () {

            Route::livewire('/', 'teacher.dashboard')->name('dashboard');

            Route::livewire('/student', 'admin.student.student-list')->name('student.list');

            Route::livewire('/timetable', 'teacher.timetable.timetable-view')->name('timetable.view');

            Route::livewire('/attendance', 'teacher.attendance.attendance-create')->name('attendance.create');
        });
    });

    // Student Routes
    Route::middleware('role:student')->group(function () {

        Route::prefix('student')->name('student.')->group(function () {
            Route::livewire('/', 'student.dashboard')->name('dashboard');

            Route::livewire('/timetable', 'student.timetable.timetable-view')->name('timetable.view');
        });
    });
});
