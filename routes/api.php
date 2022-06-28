<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\PostCategoriesController;
use Illuminate\Support\Facades\Route;


/* POST CATEGORIES NO AUTH */
Route::get('posts/categories', [PostCategoriesController::class, 'getPostCategoryCollection']);
Route::get( 'posts/categories/{id}', [PostCategoriesController::class, 'getPostCategory'] );

/* BLOG POST NO AUTH */
Route::get('posts/{id}', [BlogPostController::class, 'getBlogPost']);
Route::get('posts', [BlogPostController::class, 'getBlogPostCollection']);

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
        Route::post('posts/categories', [PostCategoriesController::class, 'createPostCategory']);
        Route::delete('posts/categories/{id}', [PostCategoriesController::class, 'deletePostCategory']);
    }
);
