<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\UserController;

Route::view('/login', 'auth.login')->name('login');

Route::prefix('oauth')
    ->group(function() {
        Route::get('/{provider}', [OAuthController::class, 'redirect'])->name('oauth');
        Route::get('/{provider}/callback', [OAuthController::class, 'callback'])->name('oauth_callback');
    })
;

Route::prefix('oauth_connect')
    ->group(function() {
        Route::get('/{provider}', [OAuthController::class, 'redirect'])->name('oauth_connect');
        Route::get('/{provider}/callback', [OAuthController::class, 'callback'])->name('oauth_connect_callback');
    })
;

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
Route::view('/logout', 'auth.logout')->middleware('auth');
