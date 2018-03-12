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

Route::get('/api-docs', function () {
    return view('api-docs');
});

Route::get('/api-doc-builders', function () {
    return view('api-doc-builders.index');
});

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
    Route::resource('qrcodes', 'QrcodeController', ['only' => [
        'index'
    ]]);
    //Export CSV
    Route::get('qrcodes/export', 'QrcodeController@exportCSV')->name('qrcodes.export');
    //Mail
    Route::post('mail/{borrowing}/send', 'SendMailController@sendMail')->name('sendMail');
    //Excel
    Route::post('books/import', 'BookController@import')->name('books.import');
    Route::get('404', function () {
        return view('backend.errors.404'); 
    });
});

//Api
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    Route::put('users/{id}/roles', 'UserController@updateRole')->middleware('TeamSA');
    Route::delete('books/{id}', 'BookController@destroy')->middleware('admin');
    Route::put('books/{id}/restore', 'BookController@restore')->middleware('admin');
    Route::delete('comments/{id}/destroy', 'CommentController@destroy');
});
