<?php

namespace App\Http\Services\Tramites\Strategies;

use App\Models\Tramite;
use Illuminate\Support\Str;
use App\Http\Services\LineasDeCaptura\LineaCaptura;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Services\Tramites\TramitesStrategyInterface;

class Certificados implements TramitesStrategyInterface{

    public $certificados_historia = [
        'Certificado de historia catastral hasta 5 movimientos',
        'Certificado de historia catastral de 6 a 10 movimientos',
        'Certificado de historia catastral de 11 a 15 movimientos',
        'Certificado de historia catastral de mas de 15 movimientos'
    ];

    public function __construct(public Tramite $tramite){}

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
            'adiciona' => true,
            'angulo' => false,
            'avaluo_para' => false
        ];

        if($this->tramite->servicio->nombre == 'Certificado negativo catastral'){

            $flags['predios'] = false;

            return $flags;

        }elseif($this->tramite->servicio->nombre == 'Certificado de historia catastral'){

            $flags['adiciona'] = false;

            return $flags;

        }

        return $flags;
    }

    public function validaciones():array
    {

        if($this->tramite->servicio->nombre == 'Certificado negativo catastral'){

            return [

                'predios' => 'nullable',
                'modelo_editar.cantidad' => 'numeric|max:1'

            ];

        }elseif($this->tramite->servicio->nombre == 'Certificado de historia catastral'){

            return [

                'predios' => 'required|array|max:1',
                'modelo_editar.cantidad' => 'numeric|max:1'

            ];

        }elseif(in_array($this->tramite->servicio->nombre, $this->certificados_historia)){

            return [

                'predios' => 'nullable',
                'tramiteAdicionaSelected' => 'required',
                'modelo_editar.adiciona' => 'required'
            ];

        }else

            return [

                'predios' => 'required|array',

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
        $this->tramite->fecha_vencimiento = $this->convertirFechaVencimieto($sap['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['ES_OPAG']['FECHA_VENCIMIENTO']);
        $this->tramite->creado_por = auth()->user()->id;

        $this->parcialesUsados();

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

                return now()->addDays(4)->toDateString();

            }elseif($this->tramite->tipo_servicio == 'urgente'){

                return now()->addDays(1)->toDateString();

            }else{

                return now()->toDateString();

            }

        }

    }

    public function calcularFolio():int
    {

        return Tramite::max('folio') + 1;

    }

    public function parcialesUsados():void
    {

        if(in_array($this->tramite->servicio->nombre, $this->certificados_historia)){

            $tramite = Tramite::find($this->tramite->adiciona);

            if(!$tramite)
                throw new ModelNotFoundException("No se encontro el trámite origen para su actualización.");

            $tramite->update(['parcial_usados' => 1]);

        }

    }

}
