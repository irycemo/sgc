<?php

namespace App\Http\Controllers\Admin\Predios;

use App\Models\Predio;
use App\Http\Controllers\Controller;

class PrediosController extends Controller
{

    public function __invoke(Predio $predio){

        $predio->load(
            'propietarios.persona',
            'terrenosComun',
            'construccionesComun',
            'terrenos',
            'construcciones',
            'colindancias',
            'audits.user:id,name',
            'bloqueos.creadoPor',
            'bloqueos.actualizadoPor',
            'movimientos.creadoPor'
        );

        return view('admin.predios.show', compact('predio'));

    }

}
