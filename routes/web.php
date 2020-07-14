<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// List of Posts
Route::get('/', 'PostController@index');

// Auth
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
Route::get('/logout', 'UserController@logout');

// Post
Route::get('/post', 'PostController@create')->middleware('auth')->name('new_post');
Route::post('/post', 'PostController@store')->middleware('auth');
Route::post('/post/destroy', 'PostController@destroy')->middleware('auth');
Route::post('/post/report', 'PostController@report');

// Search
Route::get('/search', 'PostController@search')->name('search');

// Account
Route::get('/account/profile', 'UserController@viewOwnProfile')
    ->middleware('auth')
    ->name('my_profile_page');
Route::redirect('/user/profile', '/account/profile');

Route::get('/u/{username}', 'UserController@index')->name('profile_page');
Route::get('/account/settings', 'UserController@settings')->middleware('auth')->name('account_settings');
Route::post('/account/settings', 'UserController@store');
Route::redirect('/user/settings', '/account/settings');

// Development
Route::get('/components', function () {
    return view('components');
});

// OAuth
Route::prefix('oauth')
    ->group(function() {
        Route::get('/{provider}', 'Auth\OAuthController@redirect')->name('oauth');
        Route::get('/{provider}/callback', 'Auth\OAuthController@callback')->name('oauth_callback');
    });
