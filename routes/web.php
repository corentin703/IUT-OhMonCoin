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

Auth::routes();

Route::get('/advert/search/{string?}', 'AdvertController@search')->name('advert.search');
Route::get('/advert/follow', 'AdvertController@indexByFollow')->name('advert.index.follow');
Route::get('/advert/trashed', 'AdvertController@indexTrashed')->name('advert.index.trashed');
Route::put('/advert/{advert}/follow', 'AdvertController@follow')->name('advert.follow');
Route::post('/advert/{advert}/restore', 'AdvertController@restore')->name('advert.restore');
Route::resource('/advert', 'AdvertController')
    ->except(['create']);
Route::get('/advert/user/{user}', 'AdvertController@indexByUser')->name('advert.index.user');
Route::get('/advert/category/{category}', 'AdvertController@indexByCategory')->name('advert.index.category');
Route::get('/advert/category/{category?}/search/{string?}', 'AdvertController@searchByCategory')->name('advert.category.search');


// Pictures
Route::resource('/picture', 'PictureController')
    ->only(['store', 'destroy']);


// Users
Route::resource('/user', 'UserController');


// Redirections
Route::redirect('/', route('advert.index'))->name('home');


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



