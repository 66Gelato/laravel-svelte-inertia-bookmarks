<?php

use App\Http\Controllers\BookmarkController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth'])->group(function () { // verified
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('bookmarks', [BookmarkController::class, 'index'])
        ->name('bookmarks.index');
    Route::post('bookmarks', [BookmarkController::class, 'store'])
        ->name('bookmarks.store');
});

require __DIR__.'/settings.php';
