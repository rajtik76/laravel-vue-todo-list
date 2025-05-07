<?php

use App\Http\Controllers\TodoController;
use App\Models\Todo;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard', [
            'todos' => Todo::where('user_id', auth()->id())->get(),
        ]);
    })->name('dashboard');

    Route::patch('todo/{todo}', [TodoController::class, 'toggle'])->name('todo.toggle');
    Route::delete('todo/{todo}', [TodoController::class, 'delete'])->name('todo.delete');
    Route::post('todo', [TodoController::class, 'create'])->name('todo.create');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
