<?php

use App\Http\Livewire\Admin\Umas;
use App\Http\Livewire\Ventanilla;
use App\Http\Livewire\Admin\Roles;
use App\Http\Livewire\Admin\Predios;
use App\Http\Livewire\Admin\Permisos;
use App\Http\Livewire\Admin\Tramites;
use App\Http\Livewire\Admin\Usuarios;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Auditoria;
use App\Http\Livewire\Admin\Servicios;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\SetPasswordController;
use App\Http\Livewire\Admin\CategoriasServicios;
use App\Http\Controllers\Admin\TramiteController;
use App\Http\Controllers\Valuacion\AvaluosController;
use App\Http\Controllers\Valuacion\ValuacionYDesgloseController;
use App\Http\Livewire\Admin\FactorIncremento;
use App\Http\Livewire\Admin\Oficinas;
use App\Http\Livewire\Admin\ValoresunitariosConstruccion;
use App\Http\Livewire\Admin\ValoresUnitariosRusticos;
use App\Http\Livewire\Valuacion\AsignacionCuentaPredial;
use App\Http\Livewire\Valuacion\Impresion;
use App\Models\Avaluo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::group(['middleware' => ['auth', 'esta.activo']], function(){

    /* Administración */
    Route::get('roles', Roles::class)->middleware('permission:Lista de roles')->name('roles');

    Route::get('permisos', Permisos::class)->middleware('permission:Lista de permisos')->name('permisos');

    Route::get('usuarios', Usuarios::class)->middleware('permission:Lista de usuarios')->name('usuarios');

    Route::get('auditoria', Auditoria::class)->middleware('permission:Auditoria')->name('auditoria');

    Route::get('servicios', Servicios::class)->middleware('permission:Lista de servicios')->name('servicios');

    Route::get('categorias_servicios', CategoriasServicios::class)->middleware('permission:Lista de categorías')->name('categorias_servicios');

    Route::get('umas', Umas::class)->middleware('permission:Lista de umas')->name('umas');

    Route::get('tramties', Tramites::class)->middleware('permission:Lista de trámites')->name('tramites');

    Route::get('predios', Predios::class)->middleware('permission:Lista de predios')->name('predios');

    Route::get('oficinas', Oficinas::class)->middleware('permission:Lista de oficinas')->name('oficinas');

    Route::get('factor_incremento', FactorIncremento::class)->middleware('permission:Lista de factor incremento')->name('factor_incremento');

    Route::get('valores_unitarios_construccion', ValoresunitariosConstruccion::class)->middleware('permission:Lista de valores unitarios')->name('unitarios_construccion');

    Route::get('valores_unitarios_rusticos', ValoresUnitariosRusticos::class)->middleware('permission:Lista de valores unitarios')->name('unitarios_rusticos');

    /* Valuación */
    Route::get('valuacion', ValuacionYDesgloseController::class)->middleware('permission:Valuación y desglose')->name('valuacion_y_desglose');

    Route::get('asignacion_cuenta', AsignacionCuentaPredial::class)->middleware('permission:Asignacion de cuenta')->name('asignacion_cuenta');

    Route::get('impresion_avaluos', Impresion::class)->middleware('permission:Impresión de avaluos')->name('impresion_avaluos');
    Route::get('test/{id}', [AvaluosController::class, 'test']);

    /* Ventanilla */
    Route::get('ventanilla', Ventanilla::class)->middleware('permission:Ventanilla')->name('ventanilla');
    Route::get('tramites/{tramite}', [TramiteController::class, 'orden'])->name('tramites.orden');

});

Route::get('setpassword/{email}', [SetPasswordController::class, 'create'])->name('setpassword');
Route::post('setpassword', [SetPasswordController::class, 'store'])->name('setpassword.store');

Route::get('manual', ManualController::class)->name('manual');
