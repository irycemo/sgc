<?php

namespace App\Http\Services\Tramites\Strategies;

use App\Models\Tramite;
use Illuminate\Support\Str;
use App\Http\Services\LineasDeCaptura\LineaCaptura;
use App\Http\Services\Tramites\TramitesStrategyInterface;

class LevantamientosTopograficos implements TramitesStrategyInterface{

    public function __construct(public Tramite $tramite){}

    public function cambiarFlags():array
    {

        $flags = [
            'flag_tipo_de_tramite' => true,
            'flag_tipo_de_servicio' => false,
            'cantidad' => true,
            'importe_base' => false,
            'solicitante' => true,
            'predios' => true,
            'observaciones' => true,
            'adiciona' => true,
            'angulo' => true
        ];

        return $flags;
    }

    public function validaciones():array
    {
        return [

                'modelo_editar.solicitante' => 'required',
                'predios' => 'required'
            ];

    }

    public function crearTramite($predios):Tramite
    {

        $sap = (new LineaCaptura())->generarLineaDeCaptura($this->tramite);

        $this->tramite->estado = 'nuevo';
        $this->tramite->monto = $this->calcularMonto();
        $this->tramite->folio = Tramite::max('folio') + 1;
        $this->tramite->fecha_entrega = $this->calcularFechaEntrega();
        $this->tramite->orden_de_pago = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['NRO_ORD_PAGO'];
        $this->tramite->linea_de_captura = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['LINEA_CAPTURA'];
        $this->tramite->fecha_vencimiento = $this->convertirFechaVencimieto($sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['FECHA_VENCIMIENTO']);
        $this->tramite->creado_por = auth()->user()->id;
        $this->tramite->save();


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

    public function convertirFechaVencimieto($fecha):string
    {

        return Str::substr($fecha, 0, 4) . '-' . Str::substr($fecha, 4, 2) . '-' . Str::substr($fecha, 6, 2);

    }

    public function calcularFechaEntrega():string
    {

        if($this->tramite->tipo_servicio == 'ordinario'){

            return now()->addDays(4)->toDateString();

        }elseif($this->tramite->tipo_servicio == 'urgente'){

            return now()->addDays(1)->toDateString();

        }else{

            return now()->toDateString();

        }

    }

    public function calcularMonto(){

        if(!$this->tramite->adiciona){

            return $this->tramite->monto / 2;

        }

        return $this->tramite->monto;

    }

}
