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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/vehicle-service/vehicle/find/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'find']);
    Route::get('/vehicle-service/vehicle/get', [\App\Http\Controllers\Api\VehicleController::class, 'get']);
    Route::post('/vehicle-service/vehicle/create', [\App\Http\Controllers\Api\VehicleController::class, 'create']);
    Route::get('/vehicle-service/vehicle/update/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'update']);

    Route::get('/vehicle-service/brand/find/{id}', [\App\Http\Controllers\Api\VehicleBrandController::class, 'find']);
    Route::get('/vehicle-service/brand/get', [\App\Http\Controllers\Api\VehicleBrandController::class, 'get']);

    Route::get('/vehicle-service/model/find/{id}', [\App\Http\Controllers\Api\VehicleModelController::class, 'find']);
    Route::get('/vehicle-service/model/get', [\App\Http\Controllers\Api\VehicleModelController::class, 'get']);
});
