<?php

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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', 'PostController@index');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
Route::get('/logout', function () {
    return view('auth.logout');
});

Route::get('/l1', function () {
    Auth::loginUsingId(1);
    return redirect('/');
});
Route::get('/l2', function () {
    Auth::loginUsingId(2);
    return redirect('/');
});

Route::get('/post', 'PostController@create')->middleware('auth')->name('new_post');
Route::post('/post', 'PostController@store')->middleware('auth');

Route::get('/u/{username}', 'UserController@index')->name('user_profile_page');
Route::get('/account/settings', 'UserController@settings')->name('account_settings');
Route::post('/account/settings', 'UserController@store');
//Route::post('/account/settings/update_publish_settings', '');

Route::get('/components', function () {
    return view('components');
});

Route::prefix('auth')
    ->middleware('guest')
    ->group(function() {
        Route::get('/{provider}', 'Auth\OAuthController@redirect')->name('oauth');
        Route::get('/{provider}/callback', 'Auth\OAuthController@callback');
    });

//Route::get('/home', 'HomeController@index')->name('home');
