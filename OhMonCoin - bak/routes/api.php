<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/users', 'UserController');
Route::patch('/users/{user}/password', 'UserController@updatePassword')->name('api.user.updatePassword');

//Route::get('/users', 'UserController@fetch')->name('api.user.fetch');
//Route::put('/users', 'RegisterController@create')->name('api.user.create');
//Route::post('/users', 'UserController@update')->name('api.user.update');
//Route::delete('/users', 'UserController@delete')->name('api.user.delete');
//Route::post('/users/password', 'UserController@updatePassword')->name('api.user.updatePassword');




