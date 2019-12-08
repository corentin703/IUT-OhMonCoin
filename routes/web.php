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

Route::post('/adverts/{advert}/follow', 'AdvertController@follow')->name('adverts.follow');
Route::resource('/adverts', 'AdvertController')
    ->except(['create']);

// Categories
Route::resource('/categories', 'CategoryController')
    ->except(['create']);

// Pictures
Route::resource('/pictures', 'PictureController')
    ->only(['store', 'destroy']);

// Messages
Route::post('/adverts/{advert}/message', 'MessageController@create')->name('advert.message.create');

// Users
Route::resource('/users', 'UserController');

// Roles
Route::get('/roles', 'RoleController@index')->name('roles.index');
Route::put('/roles/users/{user}', 'RoleController@changeRole')->name('role.user.update');

// Trashed
Route::post('/trashed/adverts/{advert}', 'AdvertController@restore')->name('trashed.adverts.restore');
Route::get('/trashed/adverts', 'AdvertController@indexTrashed')->name('trashed.adverts');

Route::post('/trashed/categories/{category}', 'CategoryController@restore')->name('trashed.categories.restore');
Route::get('/trashed/categories', 'CategoryController@indexTrashed')->name('trashed.categories');

// Redirections
Route::redirect('/', route('adverts.index'))->name('home');


