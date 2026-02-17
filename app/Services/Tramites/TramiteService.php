<?php

namespace App\Services\Tramites;

use App\Models\Tramite;
use Illuminate\Support\Str;
use App\Services\SAP\SapService;
use Illuminate\Support\Facades\Cache;

class TramiteService{

    public $tramite;
    public $fecha_vencimiento;
    public $orden_de_pago;
    public $linea;

    public function __construct(Tramite $tramite)
    {

        $this->tramite = $tramite;

    }

    public function crear(array | null $predios = null):Tramite
    {

        $this->tramite->estado = 'nuevo';
        $this->tramite->fecha_entrega = $this->calcularFechaEntrega();
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

            $actual = now();

            for ($i=0; $i < 10; $i++) {

                $actual->addDays(1);

                while($actual->isWeekend()){

                    $actual->addDay();

                }

            }

            return $actual->toDateString();

        }elseif($this->tramite->tipo_servicio == 'ordinario'){

            $actual = now();

            for ($i=0; $i < 1; $i++) {

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
            $this->tramite->limite_de_pago = now()->toDateString();

            return;

        }

        $array = (new SapService($this->tramite))->generarLineaDeCaptura();

        $this->tramite->orden_de_pago = $array['ES_OPAG']['NRO_ORD_PAGO'];
        $this->tramite->linea_de_captura = $array['ES_OPAG']['LINEA_CAPTURA'];
        $this->tramite->limite_de_pago = $this->convertirFecha($array['ES_OPAG']['FECHA_VENCIMIENTO']);

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
            'fecha_entrega' => $this->calcularFechaEntrega()
        ]);

        if($this->tramite->usuario == 11){

            Cache::forget('estadisticas_tramites_en_linea_' . $this->tramite->usuario_tramites_linea_id);

        }

    }

}