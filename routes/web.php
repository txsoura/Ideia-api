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

Route::get('/', function () {
    return view('welcome');
});

// Social auth
Route::group(['prefix' => 'auth'], function () {
    Route::get('{provider}', 'Auth\LoginController@redirectToProvider');
    Route::get('{provider}/callback', 'Auth\LoginController@handleProviderCallback');
});
