<?php
use Illuminate\Routing\middleware;

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

//Api
Route::group(['namespace' => 'Api'], function () {
    Route::post('login', 'LoginController@login');    
    Route::group(['middleware' => 'apiLogin'], function () {
        Route::resource('posts', 'PostController');
        Route::get('users/{id}', 'UserController@show');
        Route::get('users/{user}/posts', 'PostController@getListPostOfUser');
    });
    Route::get('categories', 'CategoryController@index');
    Route::get('books', 'BookController@index');
    Route::get('books/top-review', 'BookController@getTopReview');
    Route::get('books/top-borrow', 'BookController@topBorrow');
    Route::get('books/{id}/reviews', 'BookController@getReviewsOfBook');
    Route::get('books/{id}', 'BookController@show');
    Route::get('posts/{id}/comments', 'PostController@getCommentsOfPost');
    Route::get('comments/{id}/child-comments', 'CommentController@getChildComments');
});
