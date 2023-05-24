<?php

namespace App\Http\Services\Tramites\Strategies;

use App\Models\Tramite;
use Illuminate\Support\Str;
use App\Http\Services\LineasDeCaptura\LineaCaptura;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Services\Tramites\TramitesStrategyInterface;

class PrediosIgnorados implements TramitesStrategyInterface{

    public function __construct(public Tramite $tramite){}

    public function cambiarFlags():array
    {

        $flags = [
            'flag_tipo_de_tramite' => true,
            'flag_tipo_de_servicio' => false,
            'cantidad' => false,
            'importe_base' => true,
            'solicitante' => true,
            'predios' => false,
            'observaciones' => true,
            'adiciona' => false,
            'angulo' => false
        ];

        if($this->tramite->servicio->nombre == "Solicitud de Predio Ignorado"){

            $flags['importe_base'] = false;

            return $flags;
        }

        return $flags;
    }

    public function validaciones():array
    {
        if($this->tramite->servicio->nombre != "Solicitud de Predio Ignorado")

            return [

                'importe_base' => 'required',
                'modelo_editar.solicitante' => 'required',

            ];

        else{

            return [

                'modelo_editar.solicitante' => 'required',

            ];
        }

    }

    public function crearTramite($predios):Tramite
    {

        $sap = (new LineaCaptura())->generarLineaDeCaptura($this->tramite);

        $this->observaciones();

        $this->complemento();

        $this->tramite->estado = 'nuevo';
        $this->tramite->folio = $this->calcularFolio();
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

    public function calcularFolio():int
    {

        return Tramite::max('folio') + 1;

    }

    public function observaciones():void
    {

        if($this->tramite->servicio->nombre == "Solicitud de Predio Ignorado"){

            $this->tramite->observaciones = "Sujeto a ......";
        }
    }

    public function complemento():void
    {

        if($this->tramite->tipo_tramite == 'complemento'){

            $tramiteAdiciona = Tramite::find($this->tramite->adiciona);

            if(!$tramiteAdiciona)
                throw new ModelNotFoundException("No se encontro el trámite al que adiciona.");

            $tramiteAdiciona->update([
                'tipo_servicio' => $this->tramite->tipo_servicio
            ]);

        }

    }

}
