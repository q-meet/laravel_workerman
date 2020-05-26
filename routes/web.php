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
    return view('welcome');
});

//首页聊天页
Route::get('index','IndexController@index');
//接口数据
Route::get('get-reord','IndexController@getReord');
//管理
Route::get('room','IndexController@room');

//登录注册
Route::match(['get', 'post'],'login','IndexController@login');
Route::match(['get', 'post'],'register','IndexController@register');