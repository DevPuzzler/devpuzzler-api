<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'auth'],
    function ($router) {

        Route::post( 'login', [AuthController::class, 'login'] );

        Route::group(
            ['middleware' => 'auth:api'],
            function( $router ) {
                Route::post('logout', [AuthController::class, 'logout']);
                Route::post('refresh', [AuthController::class, 'refresh']);
                Route::post('me', [AuthController::class, 'me']);
            }
        );

});
