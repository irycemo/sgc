<?php

use App\Livewire\Cartografia\AsignarClaveCatastral\AsignarClaveCatastral;
use Illuminate\Support\Facades\Route;
use App\Livewire\Cartografia\Conciliar\Conciliar;
use App\Livewire\Cartografia\Conciliar\ConciliarManzanas;
use App\Livewire\Cartografia\AsignarCoordenadas\AsignarCoordenadas;
use App\Livewire\Cartografia\AsignarCuentaPredial\AsignarCuentaPredial;
use App\Livewire\Cartografia\AsignarCuentaPredial\CuentasAsignadas;
use App\Livewire\Cartografia\CambioLocalidad\CambioLocalidad;
use App\Livewire\Cartografia\Conciliar\ConciliarAvaluosPeritosExternos;
use App\Livewire\Cartografia\ValidarCartografia\ValidarCartografia;

Route::group([], function(){

    Route::get('asignacion_cuenta', AsignarCuentaPredial::class)->middleware('permission:Asignación de cuentas')->name('asignacion_cuenta');

    Route::get('asignacion_clave_catastral', AsignarClaveCatastral::class)->middleware('permission:Asignación de claves')->name('asignacion_clave_catastral');

    Route::get('conciliar', Conciliar::class)->middleware('permission:Conciliar')->name('conciliar');

    Route::get('conciliar_manzanas', ConciliarManzanas::class)->middleware('permission:Conciliar manzanas')->name('conciliar_manzanas');

    Route::get('conciliar_avaluos_peritos_externos', ConciliarAvaluosPeritosExternos::class)->middleware('permission:Conciliar avalúos peritos externos')->name('conciliar_avaluos_peritos_externos');

    Route::get('asignar_coordenadas', AsignarCoordenadas::class)->middleware('permission:Asignar coordenadas')->name('asignar_coordenadas');

    Route::get('cuentas_asignadas', CuentasAsignadas::class)->middleware('permission:Lista de predios asignados')->name('cuentas_asignadas');

    Route::get('validar_cartografia', ValidarCartografia::class)->middleware('permission:Validar cartografia')->name('validar_cartografia');

    Route::get('cambio_localidad', CambioLocalidad::class)->middleware('permission:Cambio de localidad')->name('cambio_localidad');

});