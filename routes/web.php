<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\{ProjectController, TaskController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttachmentController;


Route::get('/', function () {
    return redirect()->route('login');
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

    // Daftar semua tugas / filter tugas
    Route::get('/tasks', [TaskController::class, 'index'])
    ->name('tasks.index');

    // Route toggle (Fitur 5 nanti)
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])
         ->name('tasks.toggle');

    Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy'])
     ->name('attachments.destroy');

     Route::get('/projects/{project}/pdf', [App\Http\Controllers\ProjectController::class, 'exportPdf'])->name('projects.pdf');
     Route::get('/attachments/{attachment}/download', [TaskController::class, 'downloadAttachment'])->name('attachments.download');
     Route::get('/attachments/{attachment}/preview', [App\Http\Controllers\TaskController::class, 'previewAttachment'])->name('attachments.preview');

     Route::get('/dashboard', [ProjectController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
});

require __DIR__.'/auth.php';
