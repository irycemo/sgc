<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SAP\AcreditarPagoController;
use App\Http\Controllers\Api\V1\Tramites\CrearTramiteController;
use App\Http\Controllers\Api\V1\Predios\ConsultarPredioController;
use App\Http\Controllers\Api\V1\Tramites\ConsultarTramitesController;
use App\Http\Controllers\Api\V1\Traslados\IngresarTrasladoController;
use App\Http\Controllers\Api\V1\Traslados\ConsultarRechazosController;
use App\Http\Controllers\Api\V1\Traslados\InactivarTrasladoController;
use App\Http\Controllers\Api\V1\Servicios\ConsultarServiciosController;
use App\Http\Controllers\Api\V1\Tramites\ConsultarTramiteAvisoController;
use App\Http\Controllers\Api\V1\Requerimientos\CrearRequerimientoController;
use App\Http\Controllers\Api\V1\Propietarios\ConsultarPropietariosController;
use App\Http\Controllers\Api\V1\Tramites\ConsultarCertificadoAvisoController;
use App\Http\Controllers\Api\V1\Certificaciones\ConsultarCertificadosController;
use App\Http\Controllers\Api\V1\Certificaciones\GenerarCertificadoPdfController;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('consulta_cuenta_predial', [ConsultarPredioController::class, 'consultarCuentaPredial']);

    Route::post('consultar_propietarios', [ConsultarPropietariosController::class, 'consultarPropietariosCertificado']);

    Route::post('consultar_tramite_aviso', [ConsultarTramiteAvisoController::class, 'consultarTramiteAviso']);

    Route::post('consultar_certificado_aviso', [ConsultarCertificadoAvisoController::class, 'consultarCertificadoAviso']);

    Route::post('consultar_rechazos', [ConsultarRechazosController::class, 'consultarRechazos']);

    Route::post('consultar_tramites', [ConsultarTramitesController::class, 'consultarTramites']);

    Route::post('consultar_servicios', [ConsultarServiciosController::class, 'consultarServicios']);

    Route::post('consultar_certificados', [ConsultarCertificadosController::class, 'consultarCertificados']);

    Route::post('ingresar_aviso_aclaratorio', [IngresarTrasladoController::class, 'ingresarAvisoAclaratorio']);

    Route::post('ingresar_revision_aviso', [IngresarTrasladoController::class, 'ingresarRevisionAviso']);

    Route::post('inactivar_traslado', [InactivarTrasladoController::class, 'inactivarTraslado']);

    Route::post('crear_tramite', [CrearTramiteController::class, 'crearTramite']);

    Route::post('crear_requerimiento', [CrearRequerimientoController::class, 'crearRequerimiento']);

    Route::post('generar_certificado_pdf', [GenerarCertificadoPdfController::class, 'generarPdf']);

    Route::post('acreditar_pago', [AcreditarPagoController::class, 'acreditarPago']);

});