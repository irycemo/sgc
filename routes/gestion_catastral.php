<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\GestionCatastral\Captura\Captura;
use App\Livewire\GestionCatastral\ListaAvisos\ListaAvisos;
use App\Livewire\GestionCatastral\RevisionTraslados\Traslados;
use App\Livewire\GestionCatastral\RevisionTraslados\RevisarTraslado;

Route::group([], function(){

    Route::get('captura_padron', Captura::class)->middleware('permission:Captura al padron')->name('captura_padron');

    Route::get('revision_traslados', Traslados::class)->middleware('permission:Revisar traslados')->name('revision_traslados');

    Route::get('revisar_traslado/{traslado}', RevisarTraslado::class)->middleware('permission:Revisar traslados')->name('revisar_traslado');

    Route::get('lista_avisos', ListaAvisos::class)->middleware('permission:Lista traslados')->name('lista_avisos');

});
