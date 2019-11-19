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

//Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::get('/', 'HomeController@index')->name('dashboard');

//Route::get('/user', 'UserController@create')->name('user.create');
//Route::get('/user/{user}', 'UserController@edit')->name('user.edit');
Route::resource('/user', 'UserController');
Route::resource('/advert', 'AdvertController')
    ->except(['index', 'create']);


//Route::prefix('/api')->group(function ()
//{
//    Route::middleware('auth')->group(function ()
//    {
//        Route::resource('/advert', 'API\AdvertController');
//        Route::resource('/category', 'API\CategoryController');
//        Route::resource('/message', 'API\MessageController');
//        Route::resource('/picture', 'API\PictureController');
//    });
//
//    Route::resource('/user', 'API\UserController')
//        ->except(['create', 'edit']);
//});



