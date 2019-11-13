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
    return view('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user', 'HomeController@userMenu')->name('user.space');

//   Route::get('/api/users', 'UserController@fetch')->name('api.user.fetch');
//   Route::put('/api/users', 'RegisterController@create')->name('api.user.create');
//  Route::post('/api/users', 'UserController@update')->name('api.user.update');
//Route::delete('/api/users', 'UserController@delete')->name('api.user.delete');
//  Route::post('/api/users/password', 'UserController@updatePassword')->name('api.user.updatePassword');
