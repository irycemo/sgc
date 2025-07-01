<?php

use App\Http\Middleware\DirectorMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\EstaActivoMiddleware;
use App\Http\Middleware\JefeValuacionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
        then: function(){

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/administrador.php'));

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/valuacion.php'));

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/gestion_catastral.php'));

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/anotaciones_tramites_administrativos.php'));

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/cartografia.php'));

            Route::middleware(['web', 'auth', 'esta.activo', 'director.activo'])->group(base_path('routes/certificaciones.php'));

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/tramites.php'));

            Route::middleware(['web', 'auth', 'esta.activo'])->group(base_path('routes/consultas.php'));

        },
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'esta.activo' => EstaActivoMiddleware::class,
            'role'=> RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'director.activo' => DirectorMiddleware::class,
            'jefevaluacion.activo' => JefeValuacionMiddleware::class
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
