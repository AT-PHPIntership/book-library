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

Route::get('/', function () {
    return view('welcome');
});

//Login
Auth::routes();
Route::get('/login', 'Admin\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Admin\LoginController@login');
Route::post('/logout', 'Admin\LoginController@logout')->name('logout');
//Admin 
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
   Route::resource('users', 'UserController', ['except' => ['create', 'store']]);
   Route::resource('/', 'HomeController');   
});

