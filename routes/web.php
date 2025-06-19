<?php

 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\PostDec;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\BieneController;
use App\Http\Controllers\ValoracioneController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AseguradoraController;
use App\Http\Controllers\BienesController;
use App\Http\Controllers\TipoBieneController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\CasosController;
use App\Http\Controllers\CausaController; 
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\SeguroController;
use App\Http\Controllers\RamoController;
use App\Http\Controllers\ObjetoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValoracionesController;
use App\Http\Controllers\CaracteristicasBienController;

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
Route::redirect('/', '/home');

Route::get('http://localhost/', function () {
    return view('http://localhost/casos');
});

Auth::routes();

Route::resource('usuarios', App\Http\Controllers\UserController::class)->middleware('auth');

route::post('update', [App\Http\Controllers\UserController::class, 'update'])->name('update');

Route::get('/home', [App\Http\Controllers\CasoController::class, 'index'])->name('home')->middleware('auth');

Route::POST('cerrarSeccion', [App\Http\Controllers\UserController::class, 'cerrarSeccion'])->name('cerrarSeccion')->middleware('auth');

Route::resource('casos', App\Http\Controllers\CasoController::class)->middleware('auth');
 
Route::resource('tipo_bienes', App\Http\Controllers\TipoBieneController::class)->middleware('auth');  
 
Route::resource('bienes', App\Http\Controllers\BieneController::class)->middleware('auth');  

Route::post('/bienes/{id_bien}/images', [BieneController::class, 'storeImages'])->name('images.store');
 
Route::post('bienes/{id_bien}/imagenes', [BieneController::class, 'storeImages'])->name('imagenes.store');

Route::delete('imagenes/{id}', [BieneController::class, 'destroyImage'])->name('imagenes.destroy'); 

Route::get('/configuracion', function () { return view('Configuracion');})->name('configuracion');
 
Route::resource('aseguradoras', AseguradoraController::class);

Route::resource('brokers', BrokerController::class);  

Route::resource('caracteristicas_bien', caracteristicasBienController::class);

Route::resource('causas', CausaController::class);  

Route::resource('provincias', ProvinciaController::class);

Route::resource('seguros', SeguroController::class);

Route::resource('ramos', RamoController::class);

Route::resource('objetos', ObjetoController::class); 

Route::post('/subir-pdf', [BieneController::class, 'subirPdf'])->name('subir-pdf');

Route::post('/valoraciones', [ValoracioneController::class, 'store'])->name('valoraciones.store');

Route::resource('valoraciones', ValoracioneController::class);
  
Route::get('/get-aseguradoras', [\App\Http\Controllers\CasoController::class, 'getAseguradoras'])->name('get.aseguradoras'); 

Route::get('/get-objetos', [\App\Http\Controllers\BieneController::class, 'getObjeto'])->name('get.objeto'); 

Route::get('/get-tipo-caracteristicas', [\App\Http\Controllers\BieneController::class, 'getCaracteristicas'])->name('get.tipo.caracteristicas')->middleware('auth');

Route::get('bienes/get-caracteristicas', [BieneController::class, 'getCaracteristicas'])->name('bienes.getCaracteristicas');