<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\GestionCatastral\Captura\Captura;

Route::group([], function(){

    Route::get('captura_padron', Captura::class)->middleware('permission:Captura al padron')->name('captura_padron');

});
