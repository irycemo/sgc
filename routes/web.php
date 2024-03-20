<?php

use App\Livewire\Admin\Umas;
use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Efirmas;
use App\Livewire\Admin\Oficinas;
use App\Livewire\Admin\Permisos;
use App\Livewire\Admin\Tramites;
use App\Livewire\Admin\Usuarios;
use App\Livewire\Admin\Auditoria;
use App\Livewire\Admin\Servicios;
use App\Livewire\Consultas\Oficina;
use Illuminate\Support\Facades\Route;
use App\Livewire\Valuacion\MisAvaluos;
use App\Livewire\Admin\Avaluos\Avaluos;
use App\Livewire\Admin\Certificaciones;
use App\Livewire\Admin\FactorIncremento;
use App\Livewire\Valuacion\FichaTecnica;
use App\Livewire\Valuacion\Notificacion;
use App\Http\Controllers\ManualController;
use App\Livewire\GestionCatastral\Captura;
use App\Livewire\Admin\CategoriasServicios;
use App\Livewire\Valuacion\ImpresionAvaluo;
use App\Http\Controllers\DashboardController;
use App\Livewire\Admin\Predios\PrediosPadron;
use App\Http\Controllers\SetPasswordController;
use App\Http\Controllers\VerificacionController;
use App\Livewire\Admin\Predios\PrediosAsignados;
use App\Livewire\Admin\ValoresUnitariosRusticos;
use App\Http\Controllers\Admin\AvaluosController;
use App\Http\Controllers\Admin\PrediosController;
use App\Http\Controllers\Admin\TramiteController;
use App\Livewire\Valuacion\AsignacionCuentaPredial;
use App\Livewire\Admin\ValoresunitariosConstruccion;
use App\Livewire\Certificaciones\CedulaActualizacion;
use App\Livewire\Certificaciones\CertificadoHistoria;
use App\Livewire\Certificaciones\CertificadoRegistro;
use App\Http\Controllers\Valuacion\AvaluosController as Val;
use App\Livewire\Ventanilla\Ventanilla as VentanillaVentanilla;
use App\Http\Controllers\Valuacion\ValuacionYDesgloseController;
use App\Http\Controllers\Valuacion\AvaluoPredioIgnoradoController;
use App\Livewire\Certificaciones\CertificadoNegativo;
use App\Livewire\TramitesAdministrativos\PrediosIgnorados;
use App\Livewire\TramitesAdministrativos\VariacionesCatastrales;

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

Route::group(['middleware' => ['auth', 'esta.activo']], function(){

    /* Administración */
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('roles', Roles::class)->middleware('permission:Lista de roles')->name('roles');

    Route::get('permisos', Permisos::class)->middleware('permission:Lista de permisos')->name('permisos');

    Route::get('usuarios', Usuarios::class)->middleware('permission:Lista de usuarios')->name('usuarios');

    Route::get('efirmas', Efirmas::class)->middleware('permission:Lista de efirmas')->name('efirmas');

    Route::get('auditoria', Auditoria::class)->middleware('permission:Auditoria')->name('auditoria');

    Route::get('servicios', Servicios::class)->middleware('permission:Lista de servicios')->name('servicios');

    Route::get('categorias_servicios', CategoriasServicios::class)->middleware('permission:Lista de categorías')->name('categorias_servicios');

    Route::get('umas', Umas::class)->middleware('permission:Lista de umas')->name('umas');

    Route::get('tramties', Tramites::class)->middleware('permission:Lista de trámites')->name('tramites');

    Route::get('predios', PrediosPadron::class)->middleware('permission:Lista de predios')->name('predios');
    Route::get('predios/{predio}', [PrediosController::class, 'show'])->middleware('permission:Ver predio')->name('ver_predio');

    Route::get('certificaciones', Certificaciones::class)->middleware('permission:Lista de certificaciones')->name('certificaciones');

    Route::get('avaluos_lista', Avaluos::class)->middleware('permission:Lista de avaluos')->name('avaluos_lista');

    Route::get('avaluos/{predio}', [AvaluosController::class, 'show'])->middleware('permission:Ver predio avaluo')->name('ver_predio_avaluo');

    Route::get('predios_asignado', PrediosAsignados::class)->middleware('permission:Lista de predios asignados')->name('predios_asignado');

    Route::get('oficinas', Oficinas::class)->middleware('permission:Lista de oficinas')->name('oficinas');

    Route::get('factor_incremento', FactorIncremento::class)->middleware('permission:Lista de factor incremento')->name('factor_incremento');

    Route::get('valores_unitarios_construccion', ValoresunitariosConstruccion::class)->middleware('permission:Lista de valores unitarios')->name('unitarios_construccion');

    Route::get('valores_unitarios_rusticos', ValoresUnitariosRusticos::class)->middleware('permission:Lista de valores unitarios')->name('unitarios_rusticos');

    /* Valuación */
    Route::get('valuacion/{avaluo?}', ValuacionYDesgloseController::class)->middleware('permission:Valuación y desglose')->name('valuacion_y_desglose');

    Route::get('asignacion_cuenta', AsignacionCuentaPredial::class)->middleware('permission:Asignación de cuentas')->name('asignacion_cuenta');

    Route::get('impresion_avaluos', ImpresionAvaluo::class)->middleware('permission:Impresión de avaluos')->name('impresion_avaluos');

    Route::get('notificacion_avaluos', Notificacion::class)->middleware('permission:Notificación de avaluos')->name('notificacion_avaluos');

    Route::get('ficha_tecnica', FichaTecnica::class)->middleware('permission:Ficha técnica')->name('ficha_tecnica');

    Route::get('avaluo_predio_ignorado/{avaluo?}', AvaluoPredioIgnoradoController::class)->middleware('permission:Avaluos de predio ignorado')->name('avaluo_predio_ignorado');

    Route::get('mis_avaluos', MisAvaluos::class)->middleware('permission:Ver mis avaluos')->name('mis_avaluos');

    /* Gestión catastral */
    Route::get('captura_padron', Captura::class)->middleware('permission:Captura al padron')->name('captura_padron');

    /* Tramites Administrativos */
    Route::get('variaciones_catastrales', VariacionesCatastrales::class)->middleware('permission:Variaciones catastrales')->name('variaciones_catastrales');

    Route::get('predios_ignorados', PrediosIgnorados::class)->middleware('permission:Predios ignorados')->name('predios_ignorados');

    /* Certificaciones */
    Route::get('certificado_historia', CertificadoHistoria::class)->middleware('permission:Certificado de historia')->name('certificado_historia');

    Route::get('certificado_registro', CertificadoRegistro::class)->middleware('permission:Certificado de registro')->name('certificado_registro');

    Route::get('cedula_actualizacion', CedulaActualizacion::class)->middleware('permission:Cedula de actualización')->name('cedula_actualizacion');

    Route::get('certificado_negativo', CertificadoNegativo::class)->middleware('permission:Certificado negativo')->name('certificado_negativo');

    /* Consultas */
    Route::get('ver_oficina/{ofice_id?}', Oficina::class)->middleware('permission:Ver oficina')->name('ver_oficina');

    /* Ventanilla */
    Route::get('tramites/{tramite}', [TramiteController::class, 'orden'])->name('tramites.orden');

    Route::get('ventanilla', VentanillaVentanilla::class)->middleware('permission:Ventanilla')->name('ventanilla');

});

Route::get('verificacion/{certificacion}', VerificacionController::class)->name('verificacion');

Route::get('setpassword/{email}', [SetPasswordController::class, 'create'])->name('setpassword');
Route::post('setpassword', [SetPasswordController::class, 'store'])->name('setpassword.store');

Route::get('manual', ManualController::class)->name('manual');


Route::get('teste/{id}', [Val::class, 'teste'])->name('teste');
