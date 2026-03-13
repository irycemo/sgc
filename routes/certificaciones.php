<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Certificaciones\CedulaActualizacion\CedulaActualizacion;
use App\Livewire\Certificaciones\CertificadoHistoria\CertificadoHistoria;
use App\Livewire\Certificaciones\CertificadoNegativo\CertificadoNegativo;
use App\Livewire\Certificaciones\CertificadoRegistro\CertificadoRegistro;
use App\Livewire\Certificaciones\Consulta\ConsultaCertificacion;
use App\Livewire\Certificaciones\Requerimientos\RequerimientosCertificaciones;

Route::group([], function(){

    Route::get('certificado_historia', CertificadoHistoria::class)->middleware('permission:Certificado de historia')->name('certificado_historia');

    Route::get('certificado_registro', CertificadoRegistro::class)->middleware('permission:Certificado de registro')->name('certificado_registro');

    Route::get('cedula_actualizacion', CedulaActualizacion::class)->middleware('permission:Cedula de actualización')->name('cedula_actualizacion');

    Route::get('certificado_negativo', CertificadoNegativo::class)->middleware('permission:Certificado negativo')->name('certificado_negativo');

    Route::get('consulta_certificacion', ConsultaCertificacion::class)->middleware('permission:Consulta certificación')->name('consulta_certificacion');

    Route::get('requerimientos_certificaciones', RequerimientosCertificaciones::class)->middleware('permission:Requerimientos')->name('requerimientos_certificaciones');

});