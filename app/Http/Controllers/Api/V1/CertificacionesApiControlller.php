<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tramite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TramiteRequest;

class CertificacionesApiControlller extends Controller
{

    public function consultarCertificacion(TramiteRequest $request){

        $validated = $request->validated();

        $tramite = Tramite::where('año', $validated['año'])
                                ->where('folio', $validated['folio'])
                                ->where('usuario', 11)
                                ->where('usuario_tramites_linea_id', $validated['entidad'])
                                ->first();

        $certificacion = Certificacion


    }

}
