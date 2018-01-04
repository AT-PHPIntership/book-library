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


//Admin 
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
   Route::resource('users', 'UserController', ['except' => ['create', 'store']]);
});
