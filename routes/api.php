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

Route::middleware('auth:api')->get('/user/auth', function (Request $request) {
    return $request->user();
});


////Route::middleware('auth:api')->group(function ()
////{
//    Route::resource('/advert', 'API\AdvertController');
//    Route::resource('/category', 'API\CategoryController');
//    Route::resource('/message', 'API\MessageController');
//    Route::resource('/picture', 'API\PictureController');
////});
//
//Route::resource('/user', 'API\UserController');


