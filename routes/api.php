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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


/* fontend */
Route::resource('authenticate', 'Api\AuthenticateController', ['only' => ['index']]);
Route::post('authenticate', 'Api\AuthenticateController@authenticate');
Route::post('register', 'Api\RegisteruserController@create');
Route::get('/posts', 'Api\FrontPostController@index');
Route::get('/category', 'Api\FrontPostController@allcategory');
Route::get('/tags', 'Api\FrontPostController@alltags');
Route::get('/tags/{id}', 'Api\FrontPostController@GetTag');
Route::get('/cat/{id}', 'Api\FrontPostController@GetCategory');
Route::get('/search{name?}','Api\FrontPostController@SearchItem');


/* add posts */
Route::resource('/adds', 'Api\AddsController');
/* Route::get('/adds/create', 'Api\AddsController@create');
Route::post('/adds/store', 'Api\AddsController@store');
Route::get('/adds/edit/{id}', 'Api\AddsController@edit');
Route::post('/adds/update/{id}', 'Api\AddsController@update'); */


  
        


   





 