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

Route::resource('orders','OrdersController');
Route::post('/update', 'OrdersController@update')->name('update');
Route::post('/add', 'OrdersController@add')->name('add');
Route::get('/search', 'OrdersController@search')->name('search');



