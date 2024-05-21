<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SapControllerApi;
use App\Http\Controllers\Api\V1\CertificacionesApiControlller;
use App\Http\Controllers\Api\V1\TramitesApiController;
use App\Http\Controllers\Api\V1\ConsultaPredioController;
use App\Http\Controllers\Api\V1\ConsultarCodigosPostales;
use App\Http\Controllers\Api\V1\ConsultaOficinaController;
use App\Http\Controllers\Api\V1\ConsultarServiciosController;
use App\Http\Controllers\Api\V1\PropietariosApiController;
use App\Http\Controllers\Api\V1\TrasladosApiController;

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

    Route::post('consulta_cuenta_predial', [ConsultaPredioController::class, 'consultarCuentaPredial']);

    Route::post('consulta_predio', [ConsultaPredioController::class, 'consultarPredio']);

    Route::get('oficinas', ConsultaOficinaController::class);

    Route::get('codigos_postales', ConsultarCodigosPostales::class);

    Route::get('consultar_tramite', [TramitesApiController::class, 'consultarTramite']);

    Route::get('consultar_tramites', [TramitesApiController::class, 'consultarTramites']);

    Route::get('consultar_certificados', [TramitesApiController::class, 'consultarCertificados']);

    Route::post('craer_tramite', [TramitesApiController::class, 'crearTramtie']);

    Route::post('acreditar_tramite', [TramitesApiController::class, 'acreditarTramite']);

    Route::get('consultar_servicios', [ConsultarServiciosController::class, 'consultarServicios']);

    Route::get('consultar_propietarios', [PropietariosApiController::class, 'consultarPropietarios']);

    Route::post('generar_certificado', [CertificacionesApiControlller::class, 'generarCertificado']);

    Route::get('consultar_certificado', [CertificacionesApiControlller::class, 'consultarCertificado']);

    Route::post('ingresar_traslado', [TrasladosApiController::class, 'ingresarTraslado']);

});

Route::post('acredita_pago', SapControllerApi::class);
