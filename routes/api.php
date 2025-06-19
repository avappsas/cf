<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordToPdfController;
use App\Http\Controllers\DocumentConverterController;
use App\Http\Controllers\ContratacionController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sendWS', [App\Http\Controllers\MsmWhatsAppController::class, 'sendWS'])->middleware('auth:api');
//como crear una api en laravel

Route::post('/convert', [WordToPdfController::class, 'convert']);

Route::middleware(['api'])->group(function () {
    Route::post('/convert-to-pdf', [DocumentConverterController::class, 'convertToPdf']);
});

Route::post('getCertificado', [App\Http\Controllers\ContratoController::class, 'getCertificado'])->name('getCertificado');

 
Route::post('contratacion/apigoogle', [ContratacionController::class, 'apigoogle']);
Route::post('contratacion/apigoogleMultiple', [ContratacionController::class, 'apigoogleMultiple']);
Route::get('contratacion/contrato-json', [App\Http\Controllers\ContratacionController::class, 'contratoJson'])->name('api.contrato-json');
