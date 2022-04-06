<?php

use App\Http\Controllers\Manage\ManagementPanelController;
use App\Http\Controllers\PostController;

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

Route::get('/', [PostController::class, 'index']);

require __DIR__ . '/web/oauth.php';
require __DIR__ . '/web/user.php';
require __DIR__ . '/web/post.php';
require __DIR__ . '/web/manager.php';

//Route::view('/components', 'components');

// Terms
Route::view('/terms', 'terms');
Route::redirect('/tos', '/terms');
Route::redirect('/terms-of-service', '/terms');
Route::redirect('/agreement', '/terms');
