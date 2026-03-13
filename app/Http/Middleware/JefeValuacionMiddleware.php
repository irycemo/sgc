<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JefeValuacionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $jefe_departamento = User::with('efirma')->where('estado', 'activo')
                            ->whereHas('roles', function($q){
                                $q->where('name', 'Jefe de departamento');
                            })
                            ->where('area', 'Departamento de Valuación')
                            ->first();

        if(
            !$jefe_departamento->efirma ||
            !$jefe_departamento->efirma->cer ||
            !$jefe_departamento->efirma->key
        ){

            abort(403, message:"Es necesario actualizar la firma electrónica del jefe de departamento de valuación.");

        }

        return $next($request);

    }
}
