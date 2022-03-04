<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function(Request $request){
        return $request->user();
    });
    Route::get('/day-data/{plain}/{date}', [DashboardController::class, 'getDayData']);
    Route::get('/month-data/{plain}/{date}/{type?}', [DashboardController::class, 'getMonthData']);
    Route::get('/year-data/{plain?}/{date}', [DashboardController::class, 'getYearData']);
    Route::get('/monthly-recurring/{date}', [DashboardController::class, 'getMonthlyRecurring']);
    Route::get('/churn/{date_start}/', [DashboardController::class, 'getChurn']);
    Route::get('/ltv/{plain}/{date_start}/{date_end}', [DashboardController::class, 'getLtv']);
    Route::get('/trial-to-active/{plain}/{date_start}/{date_end}', [DashboardController::class, 'getTta']);
    Route::get('/calculum/{date_start}/{date_end}', [DashboardController::class, 'getCalc']);
    Route::get('/data-status/{plain}/{date_start}/{date_end}', [DashboardController::class, 'getStatusData']);
    Route::get('/data-payment-methods/{plain}/{date_start}/{date_end}', [DashboardController::class, 'getPaymentMethodsData']);
});