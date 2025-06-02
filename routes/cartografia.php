<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Cartografia\Conciliar\Conciliar;
use App\Livewire\Cartografia\Conciliar\ConciliarManzanas;
use App\Livewire\Cartografia\AsignarCoordenadas\AsignarCoordenadas;
use App\Livewire\Cartografia\AsignarCuentaPredial\AsignarCuentaPredial;

Route::group([], function(){

    Route::get('asignacion_cuenta', AsignarCuentaPredial::class)->middleware('permission:Asignación de cuentas')->name('asignacion_cuenta');

    Route::get('conciliar', Conciliar::class)->middleware('permission:Conciliar')->name('conciliar');

    Route::get('conciliar_manzanas', ConciliarManzanas::class)->middleware('permission:Conciliar manzanas')->name('conciliar_manzanas');

    Route::get('asignar_coordenadas', AsignarCoordenadas::class)->middleware('permission:Asignar coordenadas')->name('asignar_coordenadas');

});