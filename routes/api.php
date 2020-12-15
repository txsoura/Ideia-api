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

Route::group(['prefix' => 'v1', 'middleware' => ['api', 'jwt.auth']], function () {
    // User
    Route::apiResource('users', 'UserController');


});
