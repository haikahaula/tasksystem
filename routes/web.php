<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AcademicStaffController;
use App\Http\Controllers\AcademicHeadController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Academic Staff routes
    Route::prefix('academic-staff')->group(function () {
        Route::get('/dashboard', [AcademicStaffController::class, 'dashboard'])->name('academic-staff.dashboard');

        // Tasks
        Route::get('/tasks', [AcademicStaffController::class, 'viewTasks'])->name('academic-staff.tasks.index');
        Route::get('/tasks/{task}', [AcademicStaffController::class, 'show'])->name('academic-staff.tasks.show');
        Route::get('/tasks/{task}/edit', [AcademicStaffController::class, 'edit'])->name('academic-staff.tasks.edit');
        Route::put('/tasks/{task}', [AcademicStaffController::class, 'update'])->name('academic-staff.tasks.update');

        // Groups
        Route::get('/groups', [AcademicStaffController::class, 'viewGroups'])->name('academic-staff.groups.index');
        Route::get('/groups/{id}', [AcademicStaffController::class, 'showGroup'])->name('academic-staff.groups.show');

        //comments
        Route::resource('comments', CommentController::class)->only(['store', 'edit', 'update', 'destroy']);

    });

    //Academic Head routes
    Route::prefix('academic-head')->name('academic-head.')->middleware(['auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [AcademicHeadController::class, 'dashboard'])->name('dashboard');

        // Tasks
        Route::get('/tasks', [AcademicHeadController::class, 'viewTasks'])->name('tasks.index');
        Route::get('/tasks/create', [AcademicHeadController::class, 'createTask'])->name('tasks.create');
        Route::post('/tasks', [AcademicHeadController::class, 'storeTask'])->name('tasks.store');
        Route::get('/tasks/{task}', [AcademicHeadController::class, 'show'])->name('tasks.show');
        Route::get('/tasks/{task}/edit', [AcademicHeadController::class, 'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}', [AcademicHeadController::class, 'updateTask'])->name('tasks.update');
        Route::delete('/tasks/{task}', [AcademicHeadController::class, 'destroy'])->name('tasks.destroy');

        // Groups
        Route::get('/groups', [AcademicHeadController::class, 'viewGroups'])->name('groups.index');
        Route::get('/groups/create', [AcademicHeadController::class, 'createGroup'])->name('groups.create');
        Route::post('/groups', [AcademicHeadController::class, 'storeGroup'])->name('groups.store');
        Route::get('/groups/{id}', [AcademicHeadController::class, 'showGroup'])->name('groups.show');
        Route::get('/groups/{id}/edit', [AcademicHeadController::class, 'editGroup'])->name('groups.edit');
        Route::put('/groups/{id}', [AcademicHeadController::class, 'updateGroup'])->name('groups.update');
        Route::delete('/groups/{id}', [AcademicHeadController::class, 'destroyGroup'])->name('groups.destroy');

        // Comments (use resource routes for full CRUD)
        Route::resource('comments', CommentController::class)->only([
            'store', 'edit', 'update', 'destroy'
        ]);
    });
});
require __DIR__.'/auth.php';
