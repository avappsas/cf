<?php

use App\Events\chatWhatsAppEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\PostDec;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\BaseDatoController;
use App\Http\Controllers\ContratoController;  
use App\Http\Controllers\AdministrativoController;
use App\Http\Controllers\ConfiguracionController;  
use App\Http\Middleware\Mixapp;
use App\Services\WhatsAppService;
use App\Models\User;
use App\Notifications\EstadoNotificacion;

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
 
 Route::get('https://cuentafacil.co/', function () { return view('http://cuentafacil.co/home');});

 Auth::routes();

 Route::get('/version', function () { return app()->version(); });

 Route::resource('usuarios', App\Http\Controllers\UserController::class)->middleware('auth');

 Route::resource('users', App\Http\Controllers\UserController::class)->middleware('auth');

 Route::post('update', [App\Http\Controllers\UserController::class, 'update'])->name('update');

 Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

 Route::POST('cerrarSeccion', [App\Http\Controllers\UserController::class, 'cerrarSeccion'])->name('cerrarSeccion')->middleware('auth');

 Route::get('contratos/create2', [App\Http\Controllers\ContratoController::class, 'create2'])->name('contratos.create2')->middleware('auth');
 
 Route::post('/contratos/{id}/otrosi', [App\Http\Controllers\ContratoController::class, 'otrosi'])->name('contratos.otrosi')->middleware('auth');

 Route::get('contratos/export', [App\Http\Controllers\ContratoController::class,'export'])->name('contratos.export')->middleware('auth');
 
 Route::get('/interventores-por-oficina/{oficina}', [ContratoController::class, 'interventoresPorOficina']);
 
 Route::resource('contratos', App\Http\Controllers\ContratoController::class) ->middleware('auth');

 Route::get('/configurar', [ConfiguracionController::class, 'index'])->name('configurar')->middleware('auth');
 
 Route::get('allcontratos', [App\Http\Controllers\ContratoController::class, 'allcontratos']) ->name('contratos.all') ->middleware('auth');
  
 Route::get('generarDocumentosPDF', [App\Http\Controllers\ContratoController::class, 'generarDocumentosPDF'])->name('generarDocumentosPDF')->middleware('auth');

 Route::get('/contratos/{numContrato}/descargar-documentos', [App\Http\Controllers\ContratacionController::class, 'generarDocumentosZip']);
 
 Route::get('/ver-invitacion/{id}', [App\Http\Controllers\ContratacionController::class, 'verInvitacion']);

 Route::get('/ficha/{id}', [App\Http\Controllers\ContratacionController::class, 'ficha']);

 Route::get('/DocEquivalente/{id}', [App\Http\Controllers\ContratacionController::class, 'DocEquivalente']);

 Route::post('/contratos/actualizarCDP', [App\Http\Controllers\InboxController::class, 'actualizarCDP']);

 Route::post('/contratos/actualizarRPC', [App\Http\Controllers\InboxController::class, 'actualizarRPC']);

 Route::get('/contratos/notificacion/{numContrato}', [App\Http\Controllers\ContratacionController::class, 'descargarNotificacionPDF'])->name('contratos.notificacion');

 Route::get('gpdf', [App\Http\Controllers\ContratoController::class, 'gpdf'])->name('gpdf')->middleware('auth');

 Route::get('cargueDoc', [App\Http\Controllers\ContratoController::class, 'cargueDoc'])->name('cargueDoc')->middleware('auth');

 Route::get('cargueContrato', [App\Http\Controllers\ContratoController::class, 'cargueContrato'])->name('cargueContrato')->middleware('auth');

Route::get('documentosContrato', [App\Http\Controllers\ContratacionController::class, 'documentosContrato'])->name('documentosContrato')->middleware('auth');
 
 Route::post('registroCuota', [App\Http\Controllers\ContratoController::class, 'registroCuota'])->name('registroCuota')->middleware('auth');

 Route::get('tablaCuotas', [App\Http\Controllers\ContratoController::class, 'tablaCuotas'])->name('tablaCuotas')->middleware('auth');

 Route::get('btnMostrarPDF', [App\Http\Controllers\ContratoController::class, 'btnMostrarPDF'])->name('btnMostrarPDF')->middleware('auth');

 Route::post('uploadFile', [App\Http\Controllers\ContratoController::class, 'uploadFile'])->name('uploadFile')->middleware('auth');
  Route::post('uploadHV', [App\Http\Controllers\ContratoController::class, 'uploadHV'])->name('uploadHV')->middleware('auth');
   Route::post('uploadFile3', [App\Http\Controllers\ContratoController::class, 'uploadFile3'])->name('uploadFile3')->middleware('auth');

 Route::get('btnEnviarCuota', [App\Http\Controllers\ContratoController::class, 'btnEnviarCuota'])->name('btnEnviarCuota')->middleware('auth');

 Route::get('bandeja', [App\Http\Controllers\CuotaController::class, 'bandeja'])->name('bandeja')->middleware('auth')->middleware('check.route.access');

 Route::get('bandejacontrato', [App\Http\Controllers\ContratacionController::class, 'bandejacontrato'])->name('bandejacontrato')->middleware('auth');

 Route::resource('cuotas', App\Http\Controllers\CuotaController::class)->middleware('auth');

 Route::get('verDocJuridica', [App\Http\Controllers\CuotaController::class, 'verDocJuridica'])->name('verDocJuridica')->middleware('auth');

 Route::get('verDoccontratos', [App\Http\Controllers\ContratacionController::class, 'verDoccontratos'])->name('verDoccontratos')->middleware('auth');

 Route::get('verDocBuzon', [App\Http\Controllers\InboxController::class, 'verDocBuzon'])->name('verDocBuzon')->middleware('auth');

 Route::get('verDocBuzonver', [App\Http\Controllers\InboxController::class, 'verDocBuzonver'])->name('verDocBuzonver')->middleware('auth');

 Route::post('solicitud-cdp', [App\Http\Controllers\ContratacionController::class, 'solicitudCDP']) ->name('solicitudCDP');

 Route::get('cambioEstadoFile', [App\Http\Controllers\CuotaController::class, 'cambioEstadoFile'])->name('cambioEstadoFile')->middleware('auth');

 Route::get('cambioEstadoCuenta', [App\Http\Controllers\CuotaController::class, 'cambioEstadoCuenta'])->name('cambioEstadoCuenta')->middleware('auth');

 Route::get('cambioEstadoBuzon', [App\Http\Controllers\InboxController::class, 'cambioEstadoBuzon'])->name('cambioEstadoBuzon')->middleware('auth');

 Route::get('cambioEstadoContrato', [App\Http\Controllers\InboxController::class, 'cambioEstadoContrato'])->name('cambioEstadoContrato')->middleware('auth');

 Route::get('nextCuenta', [App\Http\Controllers\ContratoController::class, 'nextCuenta'])->name('nextCuenta')->middleware('auth');

 Route::get('enviarAdmin', [App\Http\Controllers\ContratoController::class, 'enviarAdmin'])->name('enviarAdmin')->middleware('auth');

 Route::get('contratos_vigentes', [App\Http\Controllers\ContratoController::class, 'contratos_vigentes'])->name('contratos_vigentes')->middleware('auth')->middleware('check.route.access');

 Route::get('misdatos', [BaseDatoController::class, 'misdatosRedirect'])->name('misdatos')->middleware('auth'); 

 Route::resource('base-datos', App\Http\Controllers\BaseDatoController::class)->middleware('auth');
 
 Route::get('readPdf', [App\Http\Controllers\ContratoController::class, 'readPdf'])->name('readPdf');

 Route::get('generarZipSap', [App\Http\Controllers\ContratoController::class, 'generarZipSap'])->name('generarZipSap')->middleware('auth');

 Route::get('validarDocumento', [App\Http\Controllers\ContratoController::class, 'validarDocumento'])->name('validarDocumento')->middleware('auth');
 
 Route::get('notificacion', [App\Http\Controllers\ContratoController::class, 'notificacion'])->name('notificacion');

 Route::get('asignarUser', [App\Http\Controllers\ContratoController::class, 'asignarUser'])->name('asignarUser')->middleware('auth');

 Route::get('/vercontratos/{documento}', [App\Http\Controllers\ContratoController::class, 'vercontratos'])->name('contratos.ver')->middleware('auth');

 Route::resource('fecha_cuenta', App\Http\Controllers\FechaCuentumController::class) ->names([ 'index' => 'fecha_cuenta' ]) ->middleware('auth');

 Route::get('/ver-firma/{id}', [BaseDatoController::class, 'verFirma'])->middleware('auth');
 
 Route::get('generar-zip/{numContrato}/{idGrupo}/{idCuota}', [App\Http\Controllers\gernarPdf::class, 'generarZip']);

 Route::resource('Entrada', App\Http\Controllers\AdministrativoController::class) ->names([ 'index' => 'Entrada' ]) ->middleware('auth');

 Route::patch('/updateEntrada/{id}/update', [AdministrativoController::class, 'updateEntrada'])->name('updateEntrada');

 Route::get('/vale-entrada/{id}', [AdministrativoController::class, 'mostrarValeEntrada'])->name('vale.entrada.mostrar');

 Route::resource('Inbox', App\Http\Controllers\InboxController::class) ->names([ 'index' => 'inbox' ]) ->middleware('auth');

 Route::post('/actualizar_radicado_sap', [App\Http\Controllers\CuotaController::class, 'actualizar_radicado_sap']); 

 Route::get('/base-datos/edit/por-documento/{cedula}', function ($cedula) { $registro = \App\Models\BaseDato::where('Documento', $cedula)->firstOrFail(); return redirect()->route('base-datos.edit', $registro->id);})->name('base-datos.edit.documento');
 
Route::get('/contratos/descargar-zip/{idContrato}/{idCuota}/{tipo}', [App\Http\Controllers\ContratacionController::class, 'descargarZip'])->name('descargar.zip.documentos') ->middleware('auth');

Route::post('/actualizarEntrada', [App\Http\Controllers\AdministrativoController::class, 'actualizarEntrada'])->middleware('auth'); 

Route::post('/aprobarLoteCuotas', [App\Http\Controllers\AdministrativoController::class, 'aprobarLoteCuotas'])->middleware('auth');

Route::get('/contratos/{id}/historial-documentos', [App\Http\Controllers\ContratoController::class, 'historialDocumentos']); 

Route::get('/bitacora/contrato/{id}', [App\Http\Controllers\InboxController::class, 'ver_bitacora']);
 
Route::get('/firmar-pdf/{documento}/{pdf_id}', [App\Http\Controllers\PDFController::class, 'mostrarVista'])->name('pdf.vista.firmar');

Route::post('/firmar-pdf', [App\Http\Controllers\PDFController::class, 'firmar'])->name('pdf.firmar');

Route::post('/firmar-pdf-embed', [App\Http\Controllers\PDFController::class, 'firmarDesdeEmbed']); 

Route::get('/firmar-viewer', function () {
    $firma = DB::table('Base_Datos')->where('Documento', auth()->user()->usuario)->value('firma');
    return view('viewer-firma-pdfjs', ['firma' => $firma]);
});
Route::post('/contratos/{id}/recordatorio', [ContratoController::class, 'reenviarRecordatorio'])
     ->name('contratos.recordatorio');
     