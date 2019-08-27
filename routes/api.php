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
Route::group([
    'namespace'=>'Api',
],function (){
    //登录
    Route::post('/login','AuthorizationsController@login');
    //注册
    Route::post('/register','AuthorizationsController@register');
});
Route::group([
    'namespace'=>'Api',
    'middleware'=>'auth:api'
],function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
