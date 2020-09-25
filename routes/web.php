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
Auth::routes([ 'register' => false, 'reset' => false, 'verify' => false]);
Route::get('/logout', 'UserController@logout');

// Post
Route::prefix('/post')
    ->middleware('auth')
    ->group(function() {
        Route::get( '/', 'PostController@create')->name('new_post');
        Route::post('/', 'PostController@store');
        Route::post('/destroy', 'PostController@destroy');
    });

Route::prefix('/post')
    ->group(function() {
        Route::post('/report', 'PostController@report');
    });

// Search
Route::get('/search', 'PostController@search')->name('search');


// Account Settings / Profile Page
Route::get('/u/{username}', 'UserController@index')->name('profile_page');

Route::prefix('/account')
    ->group(function() {
        Route::get('/profile', 'UserController@viewOwnProfile')->middleware('auth')->name('my_profile_page');
        Route::get('/settings', 'UserController@settings')->middleware('auth')->name('account_settings');
        Route::post('/settings', 'UserController@store');
    });

Route::prefix('/user') // account alias
    ->group(function () {
        Route::redirect('/profile', '/account/profile');
        Route::redirect('/settings', '/account/settings');
    });

//Route::view('/components', 'components');

// OAuth
Route::prefix('oauth')
    ->group(function() {
        Route::get('/{provider}', 'Auth\OAuthController@redirect')->name('oauth');
        Route::get('/{provider}/callback', 'Auth\OAuthController@callback')->name('oauth_callback');
    })
;

// OAuth
Route::prefix('oauth_connect')
    ->group(function() {
        Route::get('/{provider}', 'Auth\OAuthController@redirect')->name('oauth_connect');
        Route::get('/{provider}/callback', 'Auth\OAuthController@callback')->name('oauth_connect_callback');
    })
;

// Terms
Route::view('/terms', 'terms');
Route::redirect('/tos', '/terms');
Route::redirect('/terms-of-service', '/terms');
Route::redirect('/agreement', '/terms');

// Management Panel
Route::prefix('management-panel')
    ->group(function() {
        Route::get('/', 'Manage\ManagementPanelController@index');
//        Route::get('/callback', 'Auth\OAuthController@callback');
    })
;
