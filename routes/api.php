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
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

Route::post('/login', 'LoginController@login');
Route::post('/register', 'LoginController@register');

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/document', 'DocumentController@storeDocument');
    Route::post('/update-document', 'DocumentController@updateDocument');
    Route::get('/documents', 'DocumentController@getDocuments');
});
Route::get('/document/filter', 'DocumentFilterController@filter');
