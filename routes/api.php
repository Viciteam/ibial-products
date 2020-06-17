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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group([
    'prefix' => 'products',
], function () {
    Route::post("add", 'PropertyController@create');
    Route::post("edit", 'PropertyController@edit');
    Route::post("delete/{id}", 'PropertyController@delete');
    
    Route::get("meta", 'PropertyController@meta');

    Route::get("/", 'PropertyController@all');
    Route::get("{id}", 'PropertyController@single');
});


Route::group([
    'prefix' => 'package',
], function () {
    Route::post("add", 'PackageController@create');

    Route::get("{product_id}", 'PackageController@info');
});


