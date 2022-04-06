<?php

use App\Http\Controllers\UserController;

Route::get('/u/{username}', [UserController::class, 'show'])->name('profile_page');

Route::prefix('/account')
    ->group(function() {
        Route::get('/profile', [UserController::class, 'viewOwnProfile'])->middleware('auth')->name('my_profile_page');
        Route::get('/settings', [UserController::class, 'settings'])->middleware('auth')->name('account_settings');
        Route::post('/settings', [UserController::class, 'store']);
    });

Route::prefix('/user') // account alias
->group(function () {
    Route::redirect('/profile', '/account/profile');
    Route::redirect('/settings', '/account/settings');
});
