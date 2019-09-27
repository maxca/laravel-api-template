<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index','SimpleController@index');
Route::get('/shops','SimpleController@shop');
Route::get('/createShop','SimpleController@createShop');
Route::get('/find/{id}','SimpleController@findShop');
Route::get('/user','SimpleController@createUser');
Route::get('/authen','SimpleController@authen');
