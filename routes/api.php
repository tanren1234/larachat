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
Route::post('checkToken','Api\AuthorizationsController@checkToken');

Route::group([
    'namespace'=>'Api',
],function (){
    //登录
    Route::post('login','AuthorizationsController@login');
    //注册
    Route::post('register','AuthorizationsController@register');

});
Route::group([
    'namespace'=>'Api',
    'middleware'=>'auth:api'
],function (){
    Route::get('user/{id?}', 'UserController@show')->name('api.user.show');
    // 消息
    Route::get('message/{conversation_id}', 'MessageController@index')->name('api.message.index');
    Route::post('message/{user}/{conversation_id?}', 'MessageController@store')->name('api.message.store');
    Route::post('message_group/{group_id}', 'MessageController@storeGroupMessage')->name('api.message.storeGroupMessage');

    // 会话
    Route::resource('conversation','ConversationController');
    //上传文件
    Route::post('upload', 'UserController@upload')->name('api.upload');
});
