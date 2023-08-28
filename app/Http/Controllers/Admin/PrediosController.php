<?php

namespace App\Http\Controllers\Admin;

use App\Models\Predio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrediosController extends Controller
{

    public function show(Predio $predio){

        $predio->load('propietarios.persona', 'condominioTerrenos', 'condominioConstrucciones', 'terrenos', 'construcciones', 'colindancias', 'movimientos');

        return view('admin.predios.show', compact('predio'));

    }
}
