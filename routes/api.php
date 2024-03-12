<?php

use App\Http\Controllers\Api\HolidayPlanController;
use App\Http\Controllers\Auth\Api\AuthController;
use App\Http\Controllers\Auth\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout',[ AuthController::class , 'logout']);

    Route::apiResource('holiday-plans', HolidayPlanController::class);
    Route::get('holiday-plans/pdf/{holiday_plan}', [ HolidayPlanController::class , 'pdf' ]);

});

Route::prefix('auth')->group(function(){
    Route::post('login',[ AuthController::class , 'login']);
    Route::post('register',[ RegisterController::class , 'register']);
});