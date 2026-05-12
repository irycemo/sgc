<?php

use App\Http\Controllers\Valuacion\AvaluoPredioIgnoradoController;
use App\Http\Controllers\Valuacion\Valuacion;
use App\Livewire\Valuacion\FichaTecnicaJob;
use App\Livewire\Valuacion\Impresion\Impresion;
use App\Livewire\Valuacion\MisAvaluos;
use App\Livewire\Valuacion\Notificacion;
use Illuminate\Support\Facades\Route;

Route::group([], function(){

    Route::get('avaluo_predio_ignorado/{avaluo?}', AvaluoPredioIgnoradoController::class)->middleware('permission:Avaluo de predio ignorado')->name('avaluo_predio_ignorado');

    Route::get('valuacion/{avaluo?}', Valuacion::class)->middleware('permission:Valuación y desglose')->name('valuacion_y_desglose');

    Route::get('ficha_tecnica', FichaTecnicaJob::class)->middleware('permission:Ficha técnica')->name('ficha_tecnica');

    Route::get('ficha_tecnica_jobs', FichaTecnicaJob::class)->middleware('permission:Ficha técnica jobs')->name('ficha_tecnica_jobs');

    Route::get('impresion_avaluos', Impresion::class)->middleware(['permission:Impresión de avaluos', 'director.activo', 'jefevaluacion.activo'])->name('impresion_avaluos');

    Route::get('notificacion_avaluos', Notificacion::class)->middleware('permission:Notificación de avaluos')->name('notificacion_avaluos');

    Route::get('notificacion_avaluos', Notificacion::class)->middleware('permission:Notificación de avaluos')->name('notificacion_avaluos');

    Route::get('mis_avaluos', MisAvaluos::class)->middleware('permission:Ver mis avaluos')->name('mis_avaluos');

});