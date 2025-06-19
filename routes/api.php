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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
//como crear una api en laravel}

Route::get('/casos', [App\Http\Controllers\CasoController::class, 'apiCasos']); 
Route::get('/casos/{id}', [App\Http\Controllers\CasoController::class, 'apiCasos']); 

Route::post('/apiRecibir', [App\Http\Controllers\CasoController::class, 'apiRecibir']); 

//ENVIO DE DATOS A APP 
Route::get('/apiDetalleCaso/{id_caso}', [App\Http\Controllers\ApiEnvioController::class, 'apiDetalleCaso']); 
Route::get('/apibienes/{id_caso}', [App\Http\Controllers\ApiEnvioController::class, 'apibienes']); 
Route::get('/apiobjeto/{id_caso}', [App\Http\Controllers\ApiEnvioController::class, 'apiobjeto']); 
Route::get('/apiobjetotipo/{id_objeto}', [App\Http\Controllers\ApiEnvioController::class, 'apiobjetotipo']); 
Route::get('/apicampostipobien/{id_tipo_bien}', [App\Http\Controllers\ApiEnvioController::class, 'apicampostipobien']); 