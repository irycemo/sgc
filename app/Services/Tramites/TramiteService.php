<?php

namespace App\Services\Tramites;

use App\Exceptions\GeneralException;
use App\Models\Predio;
use App\Models\Tramite;
use App\Services\SAP\SapService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TramiteService{

    public $tramite;
    public $orden_de_pago;
    public $linea;

    public function __construct(Tramite $tramite)
    {

        $this->tramite = $tramite;

    }

    public function crear(array | null $predios = null):Tramite
    {

        $this->tramite->estado = 'nuevo';
        $this->tramite->año = now()->format('Y');
        $this->tramite->usuario = auth()->user()->clave;
        $this->tramite->creado_por = auth()->id();
        $this->tramite->folio = (Tramite::where('año', $this->tramite->año)->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1;

        $this->procesarLineaCaptura();

        $this->tramite->save();

        if($this->tramite->solicitante == 'Oficialia de partes'){

            $this->tramite->update([
                'estado' => 'pagado',
                'fecha_pago' => now(),
            ]);

        }

        if($predios && count($predios) > 0){

            foreach($predios as $predio){

                if(isset($predio['sector'])){

                    if(in_array($predio['sector'], [88, 99])) {

                        throw new GeneralException("El predio se encuentra en sector 88 0 99 es necesario conciliarlo, comuníquese al departamento de cartografía.");

                    }

                }elseif(isset($predio['id'])){

                    $predio = Predio::find($predio['id']);

                    if(in_array($predio->sector, [88, 99])) {

                        throw new GeneralException("El predio se encuentra en sector 88 0 99 es necesario conciliarlo.");

                    }

                }

                $this->tramite->predios()->attach($predio['id']);

            }

        }

        return $this->tramite;

    }

    public function calcularFechaEntrega()
    {

        if(in_array($this->tramite->servicio->clave_ingreso, ['DM35', 'DM32'])){

            $actual = now();

            return $actual->toDateString();

        }elseif($this->tramite->servicio->nombre == 'Certificado de historia catastral'){

            $actual = $this->tramite->fecha_pago;

            for ($i=0; $i < 9; $i++) {

                $actual->addDays(1);

                while($actual->isWeekend()){

                    $actual->addDay();

                }

            }

            return $actual->toDateString();

        }elseif($this->tramite->tipo_servicio == 'ordinario'){

            $actual = $this->tramite->fecha_pago;

            for ($i=0; $i < 2; $i++) {

                $actual->addDays(1);

                while($actual->isWeekend()){

                    $actual->addDay();

                }

            }

            return $actual->toDateString();

        }

    }

    public function procesarLineaCaptura():void
    {

        if($this->tramite->solicitante == 'Oficialia de partes' || $this->tramite->tipo_tramite == 'exento'){

            $this->tramite->estado = 'pagado';
            $this->tramite->fecha_vencimiento = now()->toDateString();

            return;

        }

        $array = (new SapService($this->tramite))->generarLineaDeCaptura();

        $this->tramite->orden_de_pago = $array['ES_OPAG']['NRO_ORD_PAGO'];
        $this->tramite->linea_de_captura = $array['ES_OPAG']['LINEA_CAPTURA'];
        $this->tramite->fecha_vencimiento = $this->convertirFecha($array['ES_OPAG']['FECHA_VENCIMIENTO']);

        /* $this->oxxo_cod = $array['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['TB_CONV_BANCARIOS'];

        $this->oxxo_conv = $array['SOAPBody']['ns0MT_ServGralLC_PI_Receiver']['TB_CONV_BANCARIOS'][1]['COD_CONVENIO']; */

    }

    public function convertirFecha($fecha):string
    {

        if(Str::length($fecha) == 10) return $fecha;

        return Str::substr($fecha, 0, 4) . '-' . Str::substr($fecha, 4, 2) . '-' . Str::substr($fecha, 6, 2);

    }

    public function procesarPago():void
    {

        $array = (new SapService($this->tramite))->validarLineaDeCaptura();

        $fecha = $this->convertirFecha($array['FEC_PAGO']);

        $documento = $array['DOC_PAGO'];

        $this->tramite->update([
            'estado' => 'pagado',
            'fecha_pago' => $this->convertirFecha($fecha),
            'documento_de_pago' => $documento,
        ]);

        if($this->tramite->usuario == 11){

            Cache::forget('estadisticas_tramites_en_linea_' . $this->tramite->usuario_tramites_linea_id);

        }

        $this->tramite->fecha_entrega = $this->calcularFechaEntrega();

        $this->tramite->save();

    }

}