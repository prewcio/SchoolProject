<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('checkLogged', 'App\Http\Controllers\Api\LogRegController@checkLogged');
Route::post('loginCheck', 'App\Http\Controllers\Api\LogRegController@checkLogin');
Route::post('registerCheck', 'App\Http\Controllers\Api\LogRegController@registerCheck');
Route::post('logout', 'App\Http\Controllers\Api\LogRegController@logout');
Route::get('/{exerciseLang}/getWords', 'App\Http\Controllers\Api\ExerTestController@GetExercises');
