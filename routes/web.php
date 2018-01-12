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
Auth::routes();
Route::get('/login', 'Admin\LoginController@showLoginForm')->name('login');

//Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::resource('users', 'UserController', ['except' => ['create', 'store']]);
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::resource('books', 'BookController');
});

