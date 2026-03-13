<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DirectorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $director = User::with('efirma')->where('estado', 'activo')
                            ->whereHas('roles', function($q){
                                $q->where('name', 'Director');
                            })
                            ->first();

        if(
            !$director->efirma ||
            !$director->efirma->cer ||
            !$director->efirma->key ||
            !$director->efirma->imagen
        ){

            abort(403, message:"Es necesario actualizar la firma electrónica del director.");

        }

        return $next($request);

    }
}
