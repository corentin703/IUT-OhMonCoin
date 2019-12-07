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

Route::get('/adverts/trashed', 'AdvertController@indexTrashed')->name('adverts.index.trashed');
Route::post('/adverts/{advert}/follow', 'AdvertController@follow')->name('adverts.follow');
Route::post('/adverts/{advert}/restore', 'AdvertController@restore')->name('adverts.restore');
Route::resource('/adverts', 'AdvertController')
    ->except(['create']);
Route::get('/categories/{category}', 'CategoryController@show')->name('categories.show');


// Pictures
Route::resource('/pictures', 'PictureController')
    ->only(['store', 'destroy']);

// Messages
Route::post('/adverts/{advert}/message', 'MessageController@create')->name('advert.message.create');


// Users
//Route::get('/users/{user}/adverts/followed', 'UserController@fetchAdvertsFollowed')->name('users.adverts.followed');
Route::get('/users/{user}/adverts', 'UserController@fetchAdverts')->name('users.adverts');
Route::resource('/users', 'UserController');

// Redirections
Route::redirect('/', route('adverts.index'))->name('home');


