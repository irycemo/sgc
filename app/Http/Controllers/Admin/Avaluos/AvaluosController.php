<?php

namespace App\Http\Controllers\Admin\Avaluos;

use App\Models\PredioAvaluo;
use App\Http\Controllers\Controller;

class AvaluosController extends Controller
{

    public function __invoke(PredioAvaluo $predio){

        $predio->load('propietarios.persona', 'terrenosComun', 'construccionesComun', 'terrenos', 'construcciones', 'colindancias', 'audits.user:id,name', 'audits.tramite:id,año,folio,usuario');

        $avaluo = $predio->avaluo;

        $avaluo->load('audits.user:id,name', 'audits.tramite:id,año,folio,usuario');

        return view('admin.avaluos.show', compact('predio', 'avaluo'));

    }

}
