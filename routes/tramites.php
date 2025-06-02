<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Tramites\Ventanilla\Ventanilla;
use App\Http\Controllers\Tramites\OrdenController;
use App\Livewire\Tramites\TramitesLinea\TramitesLinea;
use App\Livewire\Tramites\ReactivarTramite\ReactivarTramite;

Route::group([], function(){

    Route::get('ventanilla', Ventanilla::class)->middleware('permission:Ventanilla')->name('ventanilla');

    Route::get('tramites/{tramite}', OrdenController::class)->name('tramites.orden');

    Route::get('reactivar_tramites', ReactivarTramite::class)->middleware('permission:Reactivar trámites')->name('reactivar_tramites');

    Route::get('tramites_linea', TramitesLinea::class)->middleware('permission:Trámites en línea')->name('tramites_linea');

});