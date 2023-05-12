<?php

namespace App\Http\Services\Tramites\Strategies;

use App\Http\Services\LineasDeCaptura\LineaCaptura;
use App\Models\Tramite;
use App\Http\Services\Tramites\TramitesStrategyInterface;

class Certificados implements TramitesStrategyInterface{

    public $tramite;

    public function __construct(Tramite $tramite)
    {
        $this->tramite = $tramite;
    }

    public function cambiarFlags():array
    {

        $flags = [
            'flag_tipo_de_tramite' => true,
            'flag_tipo_de_servicio' => true,
            'cantidad' => true,
            'importe_base' => false,
            'solicitante' => true,
            'predios' => true,
            'observaciones' => true,
            'adiciona' => true
        ];

        if($this->tramite->servicio->nombre == 'Certificado negativo catastral'){

            $flags['predios'] = false;

            return $flags;
        }

        return $flags;
    }

    public function validaciones():array
    {

        if($this->tramite->servicio->nombre == 'Certificado negativo catastral'){

            return [

                'predios' => 'nullable',

            ];

        }else

            return [

                'predios' => 'required',

            ];

    }

    public function crearTramite($predios):Tramite
    {

        $sap = (new LineaCaptura())->generarLineaDeCaptura($this->tramite);

        $this->tramite->estado = 'nuevo';
        $this->tramite->folio = $this->calcularFolio();
        $this->tramite->fecha_entrega = $this->calcularFechaEntrega();
        $this->tramite->orden_de_pago = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['NRO_ORD_PAGO'];
        $this->tramite->linea_de_captura = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['LINEA_CAPTURA'];
        $this->tramite->creado_por = auth()->user()->id;
        $this->tramite->save();

        if(count($predios) > 0){

            foreach($predios as $predio){

                $this->tramite->predios()->attach($predio['id']);

            }

        }

        return $this->tramite;

    }

    public function actualizarTramite($predios):Tramite
    {

        $this->tramite->fecha_entrega = $this->calcularFechaEntrega();
        $this->tramite->actualizado_por = auth()->user()->id;
        $this->tramite->save();

        $this->tramite->predios()->detach();

        if(count($predios) > 0){

            foreach($predios as $predio){

                $this->tramite->predios()->attach($predio['id']);

            }

        }

        return $this->tramite;

    }

    public function calcularFechaEntrega(){

        if($this->tramite->servicio->nombre == 'Certificado de historia catastral'){

            return now()->addDays(10)->toDateString();

        }else{

            if($this->tramite->tipo_servicio == 'ordinario'){

                return now()->addDays(4)->toDateString();

            }elseif($this->tramite->tipo_servicio == 'urgente'){

                return now()->addDays(1)->toDateString();

            }else{

                return now()->toDateString();

            }

        }

    }

    public function calcularFolio(){

        return Tramite::max('folio') + 1;

    }

}
