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

Auth::routes();
Route::group(['namespace'=>'Admin', 'prefix'=>'admin'], function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::get('/', function () {
        return view('home');
    });
});
Route::post('/login', 'Admin\LoginController@login');
Route::post('/logout', 'Admin\LoginController@showLoginForm')->name('admin.login');
