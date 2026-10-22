<?php

namespace App\Traits\Api\Certificados;

use App\Jobs\Certificaciones\GenerarCertificadoRegistroJob;
use App\Models\Traslado;

trait GenerarCertificadosAutomaticosTrait
{

    public function generarCertificadosElectronicos($tramite){

        foreach ($tramite->predios as $predio) {

            $traslado = Traslado::where('estado', 'operado')->where('predio_id', $predio->id)->first();

            if($traslado){

                GenerarCertificadoRegistroJob::dispatch(
                    $tramite,
                    $predio,
                    auth()->user(),
                    null,
                    null
                );

            }

        }

    }

}
