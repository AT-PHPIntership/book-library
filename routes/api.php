<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
    Route::get('categories', 'CategoryController@index');
    Route::get('books/top-review', 'BookController@getTopReview');
    Route::get('books/top-borrow', 'BookController@topBorrow');
    Route::get('books', 'BookController@index');
	Route::get('users/{id}', 'UserController@show');
});
