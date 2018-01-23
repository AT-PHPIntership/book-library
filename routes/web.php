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
    Route::resource('categories', 'CategoryController');
});

//Api
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    Route::put('users/{id}/roles', 'UserController@updateRole')->middleware('TeamSA');
});
