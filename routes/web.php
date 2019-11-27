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


// Adverts
Route::resource('/advert', 'AdvertController')
    ->except(['create']);
Route::get('/advert/user/{user}', 'AdvertController@indexByUser')->name('advert.indexByUser');
Route::get('/advert/category/{category}', 'AdvertController@indexByCategory')->name('advert.indexByCategory');
Route::get('/advert/follow/{advert}', 'AdvertController@follow')->name('advert.follow'); // TODO: AJAX avec post (transfert de données, on cherche pas à en obtenir de nouvelles donc pas get)


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



