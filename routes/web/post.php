<?php

use App\Http\Controllers\PostController;

Route::prefix('/post')
    ->middleware('auth')
    ->group(function() {
        Route::get( '/', [PostController::class, 'create'])->name('new_post');
        Route::post('/', [PostController::class, 'store']);
        Route::post('/destroy', [PostController::class, 'destroy']);
        Route::post('/report', [PostController::class, 'report']);
    });

// Search
Route::get('/search', [PostController::class, 'search'])->name('search');
