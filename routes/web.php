<?php

use App\Events\chatWhatsAppEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\PostDec;
use App\Http\Controllers\WebhookController;

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

Route::get('http://avapp.digital:88/cf/public/', function () {
    return view('http://avapp.digital:88/cf/public/home');
});

Auth::routes();


Route::resource('usuarios', App\Http\Controllers\UserController::class)->middleware('auth');

route::post('update', [App\Http\Controllers\UserController::class, 'update'])->name('update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::POST('cerrarSeccion', [App\Http\Controllers\UserController::class, 'cerrarSeccion'])->name('cerrarSeccion')->middleware('auth');

 Route::resource('contratos', App\Http\Controllers\ContratoController::class)->middleware('auth');

 Route::get('generarDocumentosPDF', [App\Http\Controllers\ContratoController::class, 'generarDocumentosPDF'])->name('generarDocumentosPDF')->middleware('auth');

 Route::get('gpdf', [App\Http\Controllers\ContratoController::class, 'gpdf'])->name('gpdf')->middleware('auth');

 Route::get('cargueDoc', [App\Http\Controllers\ContratoController::class, 'cargueDoc'])->name('cargueDoc')->middleware('auth');
 
 Route::post('registroCuota', [App\Http\Controllers\ContratoController::class, 'registroCuota'])->name('registroCuota')->middleware('auth');

 Route::get('tablaCuotas', [App\Http\Controllers\ContratoController::class, 'tablaCuotas'])->name('tablaCuotas')->middleware('auth');

 Route::get('btnMostrarPDF', [App\Http\Controllers\ContratoController::class, 'btnMostrarPDF'])->name('btnMostrarPDF')->middleware('auth');

 Route::post('uploadFile', [App\Http\Controllers\ContratoController::class, 'uploadFile'])->name('uploadFile')->middleware('auth');

 Route::get('btnEnviarCuota', [App\Http\Controllers\ContratoController::class, 'btnEnviarCuota'])->name('btnEnviarCuota')->middleware('auth');

 Route::get('bandeja', [App\Http\Controllers\CuotaController::class, 'bandeja'])->name('bandeja')->middleware('auth')->middleware('check.route.access');

 Route::resource('cuotas', App\Http\Controllers\CuotaController::class)->middleware('auth');

 Route::get('verDocJuridica', [App\Http\Controllers\CuotaController::class, 'verDocJuridica'])->name('verDocJuridica')->middleware('auth');

 Route::get('cambioEstadoFile', [App\Http\Controllers\CuotaController::class, 'cambioEstadoFile'])->name('cambioEstadoFile')->middleware('auth');

 Route::get('cambioEstadoCuenta', [App\Http\Controllers\CuotaController::class, 'cambioEstadoCuenta'])->name('cambioEstadoCuenta')->middleware('auth');

 Route::get('nextCuenta', [App\Http\Controllers\ContratoController::class, 'nextCuenta'])->name('nextCuenta')->middleware('auth');

 Route::get('enviarAdmin', [App\Http\Controllers\ContratoController::class, 'enviarAdmin'])->name('enviarAdmin')->middleware('auth');

 Route::get('contratos_vigentes', [App\Http\Controllers\ContratoController::class, 'contratos_vigentes'])->name('contratos_vigentes')->middleware('auth')->middleware('check.route.access');

 Route::resource('base-datos', App\Http\Controllers\BaseDatoController::class)->middleware('auth');

 Route::get('misdatos', [App\Http\Controllers\BaseDatoController::class, 'misdatos'])->name('misdatos')->middleware('auth');

 Route::get('readPdf', [App\Http\Controllers\ContratoController::class, 'readPdf'])->name('readPdf');

 Route::get('generarZipSap', [App\Http\Controllers\ContratoController::class, 'generarZipSap'])->name('generarZipSap')->middleware('auth');

 Route::get('validarDocumento', [App\Http\Controllers\ContratoController::class, 'validarDocumento'])->name('validarDocumento')->middleware('auth');
 

 Route::get('notificacion', [App\Http\Controllers\ContratoController::class, 'notificacion'])->name('notificacion');

 Route::get('asignarUser', [App\Http\Controllers\ContratoController::class, 'asignarUser'])->name('asignarUser')->middleware('auth');