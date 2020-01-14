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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');
Route::resource('tools', 'ToolController');
Route::resource('orders', 'OrderController');
Route::resource('categories', 'CategoryController');
Route::resource('category_tool', 'Category_toolController');
Route::resource('drivers', 'DriverController');
