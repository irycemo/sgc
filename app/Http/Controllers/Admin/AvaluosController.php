<?php

namespace App\Http\Controllers\Admin;

use App\Models\PredioAvaluo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AvaluosController extends Controller
{

    public function show(PredioAvaluo $predio){

        $predio->load('propietarios.persona', 'condominioTerrenos', 'condominioConstrucciones', 'terrenos', 'construcciones', 'colindancias', 'audits.user');

        $avaluo = $predio->avaluo;

        $avaluo->load('audits.user');

        return view('admin.avaluos.show', compact('predio', 'avaluo'));

    }

}
