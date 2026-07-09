<?php

namespace App\Traits\Api\Certificados;

use App\Http\Controllers\Certificaciones\CertificadoRegistroController;
use App\Models\Traslado;

trait GenerarCertificadosAutomaticosTrait
{

    public function generarCertificadosElectronicos($tramite){

        foreach ($tramite->predios as $predio) {

            $traslado = Traslado::where('estado', 'operado')->where('predio_id', $predio->id)->first();

            if($traslado){

                $tipo_certificado = mb_strtoupper($tramite->servicio->nombre, 'utf-8');

                (new CertificadoRegistroController())->certificado($tramite, $predio, $tipo_certificado, auth()->user(), null);

                $tramite->predios()->updateExistingPivot($predio->id, ['estado' => 'I']);

                $usados = $tramite->predios()->wherePivot('estado', 'I')->count();

                $tramite->update(['usados' => $usados]);

                $tramite->refresh();

                if($tramite->cantidad === $usados){

                    $tramite->update(['estado' => 'concluido']);

                }

            }

        }

    }

}
