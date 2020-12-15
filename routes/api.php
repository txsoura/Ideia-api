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

// public routes
Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('events', 'EventController');
});

//private routes
Route::group(['prefix' => 'v1', 'middleware' => ['jwt.auth']], function () {
    Route::apiResource('events', 'EventController', [
        'except' => [
            'index',
            'show'
        ]
    ])->middleware('jwt.auth');
    Route::apiResource('tickets', 'TicketController');
    Route::apiResource('tags', 'TagController');
});
