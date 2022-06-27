<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostCategoriesController;
use Illuminate\Support\Facades\Route;


/* POST CATEGORIES NO AUTH*/
Route::get('post/categories', [PostCategoriesController::class, 'getPostCategoryCollection']);
Route::get( 'post/categories/{id}', [PostCategoriesController::class, 'getPostCategory'] );

Route::group(
    ['prefix' => 'auth'],
    function ( $router ) {

        Route::post( 'login', [AuthController::class, 'login'] );

        Route::group(
            ['middleware' => 'auth:api'],
            function( $router ) {
                Route::post( 'logout', [AuthController::class, 'logout'] );
                Route::post( 'refresh', [AuthController::class, 'refresh'] );
                Route::post( 'me', [AuthController::class, 'me'] );
            }
        );
});

Route::group(
    ['middleware' => 'auth:api'],
    function($router) {
        /* POST CATEGORIES AUTH */
        Route::post('post/categories', [PostCategoriesController::class, 'createPostCategory']);
        Route::delete('post/categories/{id}', [PostCategoriesController::class, 'deletePostCategory']);
    }
);
