<?php

use App\Livewire\Admin\Umas;
use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Avaluos;
use App\Livewire\Admin\Efirmas;
use App\Livewire\Admin\Predios;
use App\Livewire\Admin\Oficinas;
use App\Livewire\Admin\Permisos;
use App\Livewire\Admin\Personas;
use App\Livewire\Admin\Tramites;
use App\Livewire\Admin\Usuarios;
use App\Livewire\Admin\Auditoria;
use App\Livewire\Admin\Servicios;
use App\Livewire\Admin\Categorias;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Certificaciones;
use App\Livewire\Admin\OldBD\Auditoria as AuditoriaOLD;
use App\Livewire\Admin\FactorIncrementos;
use App\Http\Controllers\DashboardController;
use App\Livewire\Admin\ValoresUnitariosRusticos;
use App\Livewire\Admin\ValoresUnitariosConstruccion;
use App\Http\Controllers\Admin\Avaluos\AvaluosController;
use App\Http\Controllers\Admin\Predios\PrediosController;
use App\Livewire\Admin\OldBD\Certificados;
use App\Livewire\Admin\OldBD\Traslados;

Route::group([], function(){

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('roles', Roles::class)->middleware('permission:Lista de roles')->name('roles');

    Route::get('permisos', Permisos::class)->middleware('permission:Lista de permisos')->name('permisos');

    Route::get('usuarios', Usuarios::class)->middleware('permission:Lista de usuarios')->name('usuarios');

    Route::get('efirmas_usuarios', Efirmas::class)->middleware('permission:Lista de efirmas')->name('efirmas');

    Route::get('auditoria', Auditoria::class)->middleware('permission:Auditoria')->name('auditoria');

    Route::get('servicios', Servicios::class)->middleware('permission:Lista de servicios')->name('servicios');

    Route::get('personas', Personas::class)->middleware('permission:Lista de personas')->name('personas');

    Route::get('categorias_servicios', Categorias::class)->middleware('permission:Lista de categorías')->name('categorias_servicios');

    Route::get('umas', Umas::class)->middleware('permission:Lista de umas')->name('umas');

    Route::get('tramties', Tramites::class)->middleware('permission:Lista de trámites')->name('tramites');

    Route::get('predios', Predios::class)->middleware('permission:Lista de predios')->name('predios');
    Route::get('predios/{predio}', PrediosController::class)->middleware('permission:Ver predio')->name('ver_predio');

    Route::get('certificaciones_admin', Certificaciones::class)->middleware('permission:Lista de certificaciones')->name('certificaciones');

    Route::get('avaluos_lista', Avaluos::class)->middleware('permission:Lista de avaluos')->name('avaluos_lista');
    Route::get('avaluo_ver/{predio}', AvaluosController::class)->middleware('permission:Ver predio avaluo')->name('ver_predio_avaluo');

    Route::get('oficinas', Oficinas::class)->middleware('permission:Lista de oficinas')->name('oficinas');

    Route::get('factor_incremento', FactorIncrementos::class)->middleware('permission:Lista de factor incremento')->name('factor_incremento');

    Route::get('valores_unitarios_construccion', ValoresUnitariosConstruccion::class)->middleware('permission:Lista de valores unitarios')->name('unitarios_construccion');

    Route::get('valores_unitarios_rusticos', ValoresUnitariosRusticos::class)->middleware('permission:Lista de valores unitarios')->name('unitarios_rusticos');

    Route::get('auditoria_old', AuditoriaOLD::class)->middleware('permission:Auditoria')->name('auditoria_old');

    Route::get('certificados_old', Certificados::class)->middleware('permission:Auditoria')->name('certificados_old');

    Route::get('traslados_old', Traslados::class)->middleware('permission:Auditoria')->name('traslados_old');

});