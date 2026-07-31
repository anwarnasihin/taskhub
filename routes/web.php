<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\{ProjectController, TaskController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttachmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Project
    Route::resource('projects', ProjectController::class);

    // Nested resource -- task selalu di dalam project (Kecuali index & show)
    Route::resource('projects.tasks', TaskController::class)
         ->except(['index', 'show']);

    // Route toggle (Fitur 5 nanti)
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])
         ->name('tasks.toggle');

    Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy'])
     ->name('attachments.destroy');
});

require __DIR__.'/auth.php';
