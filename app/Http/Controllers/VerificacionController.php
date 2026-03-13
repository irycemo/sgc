<?php

namespace App\Http\Controllers;

use App\Models\Certificacion;
use Illuminate\Support\Facades\Storage;

class VerificacionController extends Controller
{

    public function __invoke(Certificacion $certificacion){

        if($certificacion->estado != 'activo'){

            return view('verificacion', compact('certificacion'));

        }

        if(app()->isProduction()){

            return redirect(Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_certificaciones') . $certificacion->archivo->url, now()->addMinutes(10)));


        }else{

            return redirect(Storage::disk('certificaciones')->url($certificacion->archivo->url));

        }

    }

}
