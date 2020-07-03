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

Route::get('/post', 'PostController@create')->name('new_post');
Route::post('/post', 'PostController@store');

Route::get('/u/{username}', 'UserController@index');

//Route::get('/home', 'HomeController@index')->name('home');
