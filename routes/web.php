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

//Login
Route::get('/login', 'Admin\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Admin\LoginController@login');
Route::post('/logout', 'Admin\LoginController@logout')->name('logout');

//Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::resource('users', 'UserController', ['except' => ['create', 'store']]);
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::resource('books', 'BookController');
    Route::resource('posts', 'PostController');
    Route::resource('borrowings', 'BorrowingController');
    Route::resource('categories', 'CategoryController');
    //Mail
    Route::post('mail/{borrowing}/send', 'SendMailController@sendMail')->name('sendMail');
    //Excel
    Route::post('books/import', 'BookController@import')->name('books.import');
});

//Api
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    Route::put('users/{id}/roles', 'UserController@updateRole')->middleware('TeamSA');
    Route::delete('comments/{id}/destroy', 'CommentController@destroy');
});
