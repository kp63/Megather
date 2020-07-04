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

Auth::routes();
Route::get('/logout', function () {
    return view('auth.logout');
});

Route::get('/post', 'PostController@create')->middleware('auth')->name('new_post');
Route::post('/post', 'PostController@store')->middleware('auth');

Route::get('/u/{username}', 'UserController@index');

Route::prefix('auth')
    ->middleware('guest')
    ->group(function() {
        $accepted_providers = [
            'google',
            'discord'
        ];
        foreach ($accepted_providers as $provider) {
            Route::get('/{provider}', 'Auth\OAuthController@socialOAuth')
                ->where('provider',$provider)
                ->name('socialOAuth');
            Route::get('/{provider}/callback', 'Auth\OAuthController@handleProviderCallback')
                ->where('provider',$provider)
                ->name('oauthCallback');
        }
    });

//Route::get('/home', 'HomeController@index')->name('home');
