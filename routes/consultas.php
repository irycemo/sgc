<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Consultas\Reportes\Reportes;
use App\Livewire\Consultas\Oficinas\VerOficina;
use App\Livewire\Consultas\ConsultaPadron\ConsultaPadron;

Route::group([], function(){

    Route::get('ver_oficina/{ofice_id?}', VerOficina::class)->middleware('permission:Ver oficina')->name('ver_oficina');

    Route::get('reportes', Reportes::class)->middleware('permission:Ver reportes')->name('reportes');

    Route::get('consulta_padron', ConsultaPadron::class)->middleware('permission:Consulta Padrón')->name('consulta_padron');

});