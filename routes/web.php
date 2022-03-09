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
Route::get('/all_events', 'Auth\RegisterController@all_events')->name('all_events');
Route::get('/average_counts', 'Auth\RegisterController@average_counts')->name('average_counts');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/create_event', 'HomeController@create_event')->name('create_event');
Route::post('/add_events', 'HomeController@add_events')->name('add_events');
Route::post('/invite', 'HomeController@invite')->name('invite');