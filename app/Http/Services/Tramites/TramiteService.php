<?php

namespace App\Http\Services\Tramites;

use App\Models\Tramite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Exceptions\TramiteServiceException;
use App\Exceptions\ErrorAlGenerarLineaDeCaptura;
use App\Http\Services\LineasDeCaptura\LineaCaptura;

class TramiteService{

    public function __construct(public Tramite $tramite){}

    public function crearTramite($predios = null):Tramite
    {

        try {

            $this->tramite->estado = 'nuevo';
            $this->tramite->año = now()->format('Y');
            $this->tramite->usuario = auth()->user()->clave;
            $this->tramite->folio = (Tramite::where('año', $this->tramite->año)->where('usuario', $this->tramite->usuario)->max('folio') ?? 0) + 1;

            $sap = (new LineaCaptura($this->tramite))->generarLineaDeCaptura();

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

        } catch (ErrorAlGenerarLineaDeCaptura $th) {

            throw new TramiteServiceException($th->getMessage());

        } catch (\Throwable $th) {

            Log::error("Error al crear trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". Trámite: " . $this->tramite->año . '-' . $this->tramite->numero_control . '-' . $this->tramite->usuario . '. ' . $th);

            throw new TramiteServiceException("Error al crear trámite");
        }

    }

    public function actualizarTramite($predios = null):void
    {

        try {

            $this->tramite->actualizado_por = auth()->user()->id;
            $this->tramite->save();

            if(count($predios) > 0){

                $this->tramite->predios()->detach();

                foreach($predios as $predio){

                    $this->tramite->predios()->attach($predio['id']);

                }

            }

        }  catch (\Throwable $th) {

            Log::error("Error al actualizar trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". Trámite: " . $this->tramite->año . '-' . $this->tramite->numero_control . '-' . $this->tramite->usuario . '. ' . $th);

            throw new TramiteServiceException("Error al actualizar trámite");

        }

    }

    public function convertirFechaVencimieto($fecha):string
    {

        if(Str::length($fecha) == 10)
            return $fecha;

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
