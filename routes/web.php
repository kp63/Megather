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
Route::post('/post/destroy', 'PostController@destroy')->middleware('auth');

Route::get('/account/profile', function () {
    return redirect()->route('profile_page', [
        'username' => Auth::user()->{'username'}
    ]);
})  ->middleware('auth')
    ->name('my_profile_page');

Route::get('/user/profile', function () { return redirect()->route('my_profile_page'); });
Route::get('/user/settings', function () { return redirect()->route('account_settings'); });

Route::get('/u/{username}', 'UserController@index')->name('profile_page');
Route::get('/account/settings', 'UserController@settings')->middleware('auth')->name('account_settings');
Route::post('/account/settings', 'UserController@store');
//Route::post('/account/settings/update_publish_settings', '');

Route::get('/search', 'SearchController@index');

Route::get('/components', function () {
    return view('components');
});

Route::prefix('oauth')
    ->group(function() {
        Route::get('/{provider}', 'Auth\OAuthController@redirect')->name('oauth');
        Route::get('/{provider}/callback', 'Auth\OAuthController@callback')->name('oauth_callback');
    });
