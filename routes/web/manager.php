<?php

use App\Http\Controllers\Manage\ManagementPanelController;

Route::prefix('manager')
    ->group(function() {
        Route::get('/', [ManagementPanelController::class, 'index']);
//        Route::get('/callback', 'Auth\OAuthController@callback');
    })
;
