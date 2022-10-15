<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'App\Http\Controllers\usersController@index')->name('index');
Route::post('/get_domain_suggest', 'App\Http\Controllers\usersController@get_domain_suggest')->name('get_domain_suggest');


Route::post('/add', 'App\Http\Controllers\usersController@store')->name('user.store');