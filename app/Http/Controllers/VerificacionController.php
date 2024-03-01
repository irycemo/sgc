<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificacion;

class VerificacionController extends Controller
{

    public function __invoke(Certificacion $certificacion)
    {

        $objeto = match($certificacion->documento){
            'CERTIFICADO DE HISTORIA CATASTRAL' => $this->certificadoHistoriaPartes($certificacion->cadena_originial),
            'NOTIFICACIÓN DE VALOR CATASTRAL' => $this->notificacionValorCatastralPartes($certificacion->cadena_originial),
            'CERTIFICADO DE REGISTRO CON COLINDANCIAS' => $this->certificadoRegistroPartes($certificacion->cadena_originial),
            'CERTIFICADO DE REGISTRO ELECTRÓNICO' => $this->certificadoRegistroPartes($certificacion->cadena_originial),
            'CERTIFICADO DE REGISTRO' => $this->certificadoRegistroPartes($certificacion->cadena_originial),
        };

        return view('verificacion.verificacion', compact('certificacion', 'objeto'));

    }

    private function certificadoHistoriaPartes($cadena){

        $object = (object)[];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $historia = null;

            if($aux[0] === 'historia'){

                foreach($aux as $item){

                    if($item === 'historia') continue;

                    $historia = $historia . ' ' . $item;

                }

                $object->{$aux[0]} = $historia;

                continue;

            }

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    private function notificacionValorCatastralPartes($cadena){

        $object = (object)[
            'avaluos' => collect(),
        ];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $aux2 = explode('%', $item);

            if(count($aux2) === 5){

                $avaluo = (object)[];

                $avaluo->folio = str_replace('folio_avaluo=' , '', $aux2[0]);

                $avaluo->cuenta_predial = str_replace('Cuenta predial=' , '', $aux2[1]);

                $avaluo->clave_catastral = str_replace('Clave catastral=' , '', $aux2[2]);

                $avaluo->propietario = str_replace('Propietario=' , '', $aux2[3]);

                $avaluo->valor_catastral = str_replace('Valor catastral=' , '', $aux2[4]);

                $object->avaluos->push($avaluo);

                continue;

            }

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

    private function certificadoRegistroPartes($cadena){

        $object = (object)[
            'propietarios' => collect(),
            'colindancias' => collect(),
        ];

        $array = explode('|', $cadena);

        foreach ($array as $item) {

            $aux =  explode(': ', $item);

            $aux2 = explode('%', $item);

            if(count($aux2) === 5){

                $propietario = (object)[];

                $propietario->nombre = str_replace('Nombre=' , '', $aux2[0]);

                $propietario->tipo = str_replace('Tipo=' , '', $aux2[1]);

                $propietario->porcentaje = str_replace('Porcentaje propiedad=' , '', $aux2[2]);

                $propietario->porcentaje_nuda = str_replace('Porcentaje nuda=' , '', $aux2[3]);

                $propietario->porcentaje_usufructo = str_replace('Porcentaje usufructo=' , '', $aux2[4]);

                $object->propietarios->push($propietario);

                continue;

            }

            if(count($aux2) === 3){

                $colindancia = (object)[];

                $colindancia->viento = str_replace('Viento=' , '', $aux2[0]);

                $colindancia->longitud = str_replace('Longitud=' , '', $aux2[1]);

                $colindancia->descripcion = str_replace('Descripcion=' , '', $aux2[2]);

                $object->colindancias->push($colindancia);

                continue;

            }

            $object->{$aux[0]} = $aux[1];

        }

        return $object;

    }

}
