<?php

use App\Facades\HolidayPlanGeneratePdfFacade;
use App\Models\HolidayPlan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->to('https://documenter.getpostman.com/view/10594710/2sA2xk1roM');
});
Route::get('/test-pdf', function () {
    return view('pdf.holiday-plan',[ 'data' => HolidayPlan::first() ]);
});
