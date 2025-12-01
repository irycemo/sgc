<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SAP\AcreditarPagoController;
use App\Http\Controllers\Api\V1\Tramites\CrearTramiteController;
use App\Http\Controllers\Api\V1\Predios\ConsultarPredioController;
use App\Http\Controllers\Api\V1\Tramites\ConsultarTramitesController;
use App\Http\Controllers\Api\V1\Traslados\IngresarTrasladoController;
use App\Http\Controllers\Api\V1\Traslados\ConsultarRechazosController;
use App\Http\Controllers\Api\V1\Traslados\InactivarTrasladoController;
use App\Http\Controllers\Api\V1\Traslados\RegistrarPagoIsaiController;
use App\Http\Controllers\Api\V1\Servicios\ConsultarServiciosController;
use App\Http\Controllers\Api\V1\Tramites\ConsultarTramiteAvisoController;
use App\Http\Controllers\Api\V1\Requerimientos\CrearRequerimientoController;
use App\Http\Controllers\Api\V1\Propietarios\ConsultarPropietariosController;
use App\Http\Controllers\Api\V1\Tramites\ConsultarCertificadoAvisoController;
use App\Http\Controllers\Api\V1\Certificaciones\ConsultarCertificadosController;
use App\Http\Controllers\Api\V1\Certificaciones\GenerarCertificadoPdfController;
use App\Http\Controllers\Api\V1\Oficinas\OficinasController;

Route::middleware('auth:sanctum')->group(function () {

    Route::post('consultar_predio', [ConsultarPredioController::class, 'consultarPredio']);

    Route::post('consulta_cuenta_predial', [ConsultarPredioController::class, 'consultarCuentaPredial']);

    Route::post('consultar_propietarios', [ConsultarPropietariosController::class, 'consultarPropietariosCertificado']);

    Route::post('consultar_propietarios_predio_id', [ConsultarPropietariosController::class, 'consultarPropietariosPredioId']);

    Route::post('consultar_tramite_id', [ConsultarTramitesController::class, 'consultarTramiteId']);

    Route::post('consultar_tramite_aviso', [ConsultarTramiteAvisoController::class, 'consultarTramiteAvisoRevision']);

    Route::post('consultar_tramite_aviso_aclaratorio', [ConsultarTramiteAvisoController::class, 'consultarTramiteAvisoAclaratorio']);

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

    Route::post('responder_requerimiento', [CrearRequerimientoController::class, 'responderRequerimiento']);

    Route::post('crear_requerimiento_oficina', [CrearRequerimientoController::class, 'crearRequerimientoOficina']);

    Route::post('consultar_requerimiento', [CrearRequerimientoController::class, 'consultarRequerimiento']);

    Route::post('consultar_requerimientos_oficina', [CrearRequerimientoController::class, 'consultarRequerimientosOficina']);

    Route::post('generar_certificado_pdf', [GenerarCertificadoPdfController::class, 'generarPdf']);

    Route::post('acreditar_pago', [AcreditarPagoController::class, 'acreditarPago']);

    Route::post('registrar_pago_isai', [RegistrarPagoIsaiController::class, 'registrarPagoIsai']);

    Route::post('consultar_estadisticas', [ConsultarTramitesController::class, 'consultarEstadisticas']);

    Route::post('consultar_oficinas', [OficinasController::class, 'consultarOficinas']);

});