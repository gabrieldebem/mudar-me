<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/travels', \App\Http\Controllers\TravelController::class)
    ->only(['index', 'show', 'update', 'store', 'destroy']);
Route::resource('/drivers', \App\Http\Controllers\DriverController::class)
    ->only(['index', 'show', 'update', 'store', 'destroy']);
Route::resource('/address', \App\Http\Controllers\AddressController::class)
    ->only(['index', 'show', 'update', 'store', 'destroy']);
