<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AcademicStaffController;

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

    // Task routes
    Route::resource('tasks', TaskController::class);

    // Comment routes
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Group routes
    Route::resource('groups', GroupController::class)->middleware(['auth']);
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');



    Route::prefix('academic-staff')->group(function () {
        Route::get('/dashboard', [AcademicStaffController::class, 'dashboard'])->name('academic-staff.dashboard');
        Route::get('/tasks', [AcademicStaffController::class, 'viewTasks'])->name('academic-staff.tasks.index');
        Route::get('/tasks/{id}', [AcademicStaffController::class, 'show'])->name('academic-staff.tasks.show');
        Route::get('/tasks/{id}/edit', [AcademicStaffController::class, 'edit'])->name('academic-staff.tasks.edit');
});
});



require __DIR__.'/auth.php';
