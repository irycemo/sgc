<?php

namespace App\Http\Services\Tramites\Strategies;

use App\Models\Tramite;
use Illuminate\Support\Str;
use App\Http\Services\LineasDeCaptura\LineaCaptura;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Services\Tramites\TramitesStrategyInterface;

class InspeccionesOculares implements TramitesStrategyInterface{

    public function __construct(public Tramite $tramite){}

    public function cambiarFlags():array
    {

        $flags = [
            'flag_tipo_de_tramite' => true,
            'flag_tipo_de_servicio' => false,
            'cantidad' => true,
            'importe_base' => false,
            'solicitante' => true,
            'predios' => false,
            'observaciones' => true,
            'adiciona' => true,
            'angulo' => false,
            'avaluo_para' => true
        ];

        return $flags;
    }

    public function validaciones():array
    {

        return [

            'modelo_editar.solicitante' => 'required',
            'modelo_editar.avaluo_para' => 'required',

        ];

    }

    public function crearTramite($predios):Tramite
    {

        $sap = (new LineaCaptura())->generarLineaDeCaptura($this->tramite);

        $this->observaciones();

        $this->calcularMonto();

        $this->tramite->estado = 'nuevo';
        $this->tramite->folio = $this->calcularFolio();
        $this->tramite->fecha_entrega = null;
        $this->tramite->orden_de_pago = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['NRO_ORD_PAGO'];
        $this->tramite->linea_de_captura = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['LINEA_CAPTURA'];
        $this->tramite->fecha_vencimiento = $this->convertirFechaVencimieto($sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['FECHA_VENCIMIENTO']);
        $this->tramite->creado_por = auth()->user()->id;
        $this->tramite->save();


        return $this->tramite;

    }

    public function convertirFechaVencimieto($fecha):string
    {

        return Str::substr($fecha, 0, 4) . '-' . Str::substr($fecha, 4, 2) . '-' . Str::substr($fecha, 6, 2);

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

    public function calcularMonto():void
    {

        $aux = $this->tramite->cantidad - 1;

        if($this->tramite->adiciona){

            $this->tramite->monto = $this->tramite->servicio->ordinario * $this->tramite->cantidad * 0.1;

            return;

        }

        if($this->tramite->cantidad > 1){

            $this->tramite->monto = $this->tramite->servicio->ordinario * $aux * 0.1 + $this->tramite->servicio->ordinario;

        }

    }

}
