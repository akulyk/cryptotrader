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

Route::get('/','HomeController@actionIndex')->name('home');
Route::get('/currency/{currency?}','HomeController@actionCurrency')
    ->name('currency');

Route::get('/yobit/info','Yobit@getInfo');
Route::get('/yobit/info','Yobit@getPairs');
Route::get('/yobit/depth/{pair}','Yobit@getDepth');
Route::get('/btctradeua/depth/{pair}','BtcTradeUa@getDepth');
Route::get('/kuna/depth/{pair}','Kuna@getDepth');
Route::get('/exmo/depth/{pair}','Exmo@getDepth');
