<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificacion;

class VerificacionController extends Controller
{

    public function __invoke(Certificacion $certificacion)
    {

        $array = match($certificacion->documento){
            'CERTIFICADO DE HISTORIA CATASTRAL' => $this->certificadoHistoria($certificacion->cadena_originial),
            'NOTIFICACIÓN DE VALOR CATASTRAL' => $this->notificacionValorCatastral($certificacion->cadena_originial),
        };

        return view('verificacion.verificacion', compact('certificacion', 'array'));

    }

    private function certificadoHistoria($cadena){

        $array = explode('|', $cadena);

        return array_map(function($array){

            $aux =  explode(': ', $array);

            $historia = null;

            if($aux[0] === 'Historia'){

                foreach($aux as $item){

                    if($item === 'Historia') continue;

                    $historia = $historia . ' ' . $item;

                }

                return[$aux[0] => $historia];

            }

            return[$aux[0] => $aux[1]];

        }, $array);

    }

    private function notificacionValorCatastral($cadena){

        $array = explode('|', $cadena);

        return array_map(function($array){

            $aux =  explode(': ', $array);

            $aux2 = explode('%', $array);

            if(count($aux2) === 5){

                return $aux2;

            }

            return[$aux[0] => $aux[1]];

        }, $array);

    }

}
