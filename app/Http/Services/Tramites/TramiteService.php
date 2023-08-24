<?php

namespace App\Http\Services\Tramites;

use App\Models\Tramite;
use Illuminate\Support\Str;
use App\Http\Services\LineasDeCaptura\LineaCaptura;

class TramiteService{

    public function __construct(public Tramite $tramite){}

    public function crearTramite($predios = null):Tramite
    {

        $sap = (new LineaCaptura())->generarLineaDeCaptura($this->tramite);

        $this->tramite->estado = 'nuevo';
        $this->tramite->folio = Tramite::max('folio') + 1;
        $this->tramite->fecha_entrega = $this->calcularFechaEntrega();
        $this->tramite->orden_de_pago = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['NRO_ORD_PAGO'];
        $this->tramite->linea_de_captura = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['LINEA_CAPTURA'];
        $this->tramite->fecha_vencimiento = $this->convertirFechaVencimieto($sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['FECHA_VENCIMIENTO']);
        $this->tramite->creado_por = auth()->user()->id;

        $this->tramite->save();

        if($predios && count($predios) > 0){

            foreach($predios as $predio){

                $this->tramite->predios()->attach($predio['id']);

            }

        }

        return $this->tramite;

    }

    public function actualizarTramite($predios = null):Tramite
    {

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

    public function convertirFechaVencimieto($fecha):string
    {

        return Str::substr($fecha, 0, 4) . '-' . Str::substr($fecha, 4, 2) . '-' . Str::substr($fecha, 6, 2);

    }

    public function calcularFechaEntrega():?string
    {

        if($this->tramite->servicio->nombre == 'Certificado de historia catastral'){

            return now()->addDays(10)->toDateString();

        }elseif($this->tramite->servicio->nombre == 'Certificado de historia catastral'){

            return null;

        }else{

            if($this->tramite->tipo_servicio == 'ordinario'){

                $actual = now();

                for ($i=0; $i < 5; $i++) {

                    $actual->addDays(1);

                    while($actual->isWeekend()){

                        $actual->addDay();

                    }

                }

                return $actual->toDateString();

            }elseif($this->tramite->tipo_servicio == 'urgente'){

                $actual = now()->addDays(1);

                while($actual->isWeekend()){

                    $actual->addDay();

                }

                return $actual->toDateString();

            }else{

                return now()->toDateString();

            }

        }

    }

}
