<?php

namespace App\Http\Services\Tramites\Strategies;

use App\Models\Tramite;
use App\Models\Servicio;
use Illuminate\Support\Str;
use App\Http\Services\LineasDeCaptura\LineaCaptura;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Services\Tramites\TramitesStrategyInterface;

class CopiasDocumentos implements TramitesStrategyInterface{

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
            'angulo' => false,
            'avaluo_para' => false
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

        if($this->tramite->adiciona){

            $this->tramite->estado = 'nuevo';
            $this->tramite->folio = $this->calcularFolio();
            $this->tramite->fecha_entrega = $this->calcularFechaEntrega();
            $this->tramite->orden_de_pago = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['NRO_ORD_PAGO'];
            $this->tramite->linea_de_captura = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['LINEA_CAPTURA'];
            $this->tramite->fecha_vencimiento = $this->convertirFechaVencimieto($sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['FECHA_VENCIMIENTO']);
            $this->tramite->creado_por = auth()->user()->id;
            $this->tramite->save();

        }else{

            $consulta = $this->crearTramiteConsulta();

            $this->tramite->adiciona = $consulta->id;
            $this->tramite->monto = $this->tramite->monto + $consulta->monto;
            $this->tramite->estado = 'nuevo';
            $this->tramite->folio = $this->calcularFolio();
            $this->tramite->fecha_entrega = $this->calcularFechaEntrega();
            $this->tramite->orden_de_pago = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['NRO_ORD_PAGO'];
            $this->tramite->linea_de_captura = $sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['LINEA_CAPTURA'];
            $this->tramite->fecha_vencimiento = $this->convertirFechaVencimieto($sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['FECHA_VENCIMIENTO']);
            $this->tramite->creado_por = auth()->user()->id;
            $this->tramite->save();

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

    public function crearTramiteConsulta():Tramite
    {

        $servicio = Servicio::where('nombre', 'Consulta del acervo catastral')->first();

        if(!$servicio)
            throw new ModelNotFoundException('No se encontro el servicio Consulta del acervo catastral');

        $consulta = Tramite::make();
        $consulta->folio = $this->calcularFolio();
        $consulta->servicio_id = $servicio->id;
        $consulta->estado = 'nuevo';
        $consulta->monto = $servicio->ordinario;
        $consulta->tipo_tramite = $this->tramite->tipo_tramite;
        $consulta->tipo_servicio = $this->tramite->tipo_servicio;
        $consulta->fecha_entrega = $this->tramite->fecha_entrega;
        $consulta->solicitante = $this->tramite->solicitante;
        $consulta->orden_de_pago = $this->tramite->orden_de_pago;
        $consulta->linea_de_captura = $this->tramite->linea_de_captura;
        $consulta->creado_por = $this->tramite->creado_por;

        $consulta->save();

        return $consulta;
    }

}
