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

Route::prefix('admin')->group(function () {
	Route::get('/', function () {
		return view('backend.layouts.main');
	});
});
//Login
Auth::routes();
Route::get('/login', 'Admin\LoginController@showLoginForm')->name('login');

//Admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
	Route::resource('users', 'UserController', ['except' => ['create', 'store']]);
	Route::resource('books', 'BookController');
	Route::get('users/changeRole/{id}', 'UserController@changeRole');
});
