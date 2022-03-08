<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\DashboardController;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); 
    Route::get('/linkstorage', function () {
        Artisan::call('storage:link');
    });
    
    // Rota para preencher a tabela de contábeis pela primeira vez:
    Route::get('/show-eduzz/{type}', [DataController::class, 'curlEduzz']);
    Route::get('/show-guru/{type}', [DataController::class, 'curlDigitalManagerGuru']);
    Route::get('/fill/{fonte}', [DataController::class, 'fillBdd']);

    Route::get('/exportar', [DashboardController::class, 'export']);
});

//Webhooks
Route::post('/guru-webhook-transacoes', [WebHookController::class, 'webhookDMGTransacoes']);
Route::post('/guru-webhook-assinaturas', [WebHookController::class, 'webhookDMGAssinaturas']);
Route::post('/eduzz-webhook', [WebHookController::class, 'webhookEduzz']);

require __DIR__.'/auth.php';
