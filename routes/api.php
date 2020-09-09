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
    Route::post("edit", 'PackageController@edit');

    Route::get("{product_id}", 'PackageController@info');
});


Route::group([
    'prefix' => 'transaction',
], function () {
    Route::post("/", 'TransactionController@purchase');
    Route::post("/cart", 'TransactionController@addcart');

    Route::post("/gate/method", 'TransactionController@gate');
    Route::post("/gate/transact", 'TransactionController@gatetransact');

    Route::get("/cart", 'TransactionController@getcart');
});

Route::group([
    'prefix' => 'log',
], function () {
    Route::post("/", 'LogController@insert');
    Route::get("/", 'LogController@get'); 
});

Route::group([
    'prefix' => 'log',
], function () {
    Route::post("/", 'LogController@insert');
    Route::get("/", 'LogController@get'); 
});

Route::group([
    'prefix' => 'suggested',
], function () {
    Route::get("/", 'LogController@suggested'); 
});

Route::group([
    'prefix' => 'checkout',
], function () {
    Route::post("/", 'TransactionController@checkout'); 
});

Route::group([
    'prefix' => 'company',
], function () {
    Route::post("add", 'CompanyController@insert'); 
});

Route::group([
    'prefix' => 'teams',
], function () {
    Route::post("add", 'CompanyController@addTeam'); 
    Route::post("invite", 'CompanyController@invite'); 
    Route::post("uninvite", 'CompanyController@uninvite'); 

    Route::get("members", 'CompanyController@members'); 
});

Route::group([
    'prefix' => 'kb',
], function () {
    Route::post("insert", 'KnowledgeBaseController@insert'); 
    Route::post("edit", 'KnowledgeBaseController@edit'); 
    Route::post("deactive", 'KnowledgeBaseController@deactive'); 
});

Route::group([
    'prefix' => 'manage',
], function () {
    Route::post("/", 'CompanyController@manage'); 
});

Route::group([
    'prefix' => 'hashtags',
], function () {
    Route::get("suggest", 'CompanyController@suggest');
});
