<?php

namespace App\Http\Controllers\Admin;

use App\Models\Predio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrediosController extends Controller
{

    public function show(Predio $predio){

        $predio->load(
            'propietarios.persona',
            'condominioTerrenos',
            'condominioConstrucciones',
            'terrenos',
            'construcciones',
            'colindancias',
            'audits.user',
            'bloqueos.creadoPor',
            'bloqueos.actualizadoPor',
            'movimientos.creadoPor'
        );

        return view('admin.predios.show', compact('predio'));

    }

}
