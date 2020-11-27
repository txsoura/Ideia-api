<?php

use Illuminate\Support\Facades\Route;

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

# Version
Route::get('/v1', function () {
    return [
        'name' => config('app.name'),
        'version' => config('app.version'),
        'locale' => app()->getLocale(),
    ];
});

// 404 route
Route::fallback(function () {
    return response()->json(['message' => 'Page Not Found'], 404);
});

// Auth routes
Route::group(['prefix' => 'v1/auth', 'middleware' => 'api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('logout', 'Auth\LoginController@logout')->middleware('jwt.auth');
    Route::post('refresh', 'Auth\LoginController@refresh')->middleware('jwt.auth');
    Route::get('me', 'Auth\LoginController@me')->middleware('jwt.auth');
    Auth::routes(['verify' => true]);
});

Route::group(['prefix' => 'v1', 'middleware' => ['api', 'jwt.auth']], function () {
    // User
    Route::apiResource('users', 'UserController');
    Route::put('users/{user}/approve', 'UserController@approve');
    Route::put('users/{user}/block', 'UserController@block');
    // User Profile
    Route::apiResource('users/{user}/profile', 'ProfileController');
    Route::post('users/{user}/profile/upload', 'ProfileController@upload');

    //User Wallet
    Route::apiResource('users/{user}/wallets', 'WalletController');
    Route::put('users/{user}/wallets/{wallet}/in', 'WalletController@in');
    Route::put('users/{user}/wallets/{wallet}/out', 'WalletController@out');

    // Address
    Route::apiResource('Address', 'AddressController');
    Route::apiResource('cities', 'CityController');
    Route::apiResource('states', 'StateController');
    Route::apiResource('countries', 'CountryController');
});
