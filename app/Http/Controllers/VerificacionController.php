<?php

namespace App\Http\Controllers;

use App\Models\Avaluo;
use App\Models\Certificacion;
use Illuminate\Support\Facades\Storage;

class VerificacionController extends Controller
{

    public function certificacion(Certificacion $certificacion){

        if($certificacion->estado != 'activo'){

            return view('verificacion.certificacion', compact('certificacion'));

        }

        if(app()->isProduction()){

            return redirect(Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_certificaciones') . $certificacion->archivo->url, now()->addMinutes(10)));


        }else{

            return redirect(Storage::disk('certificaciones')->url($certificacion->archivo->url));

        }

    }

    public function avaluo(Avaluo $avaluo){

        $avaluo->predioAvaluo->load('propietarios.persona');

        return view('verificacion.avaluo', [
            'avaluo' => $avaluo,
            'predio' => $avaluo->predioAvaluo
        ]);

    }

}
