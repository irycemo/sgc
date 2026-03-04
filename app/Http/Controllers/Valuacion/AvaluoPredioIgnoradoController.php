<?php

namespace App\Http\Controllers\Valuacion;

use App\Models\Avaluo;
use App\Http\Controllers\Controller;

class AvaluoPredioIgnoradoController extends Controller
{

    public function __invoke(Avaluo $avaluo)
    {

        if($avaluo?->asignado_a !== auth()->id()) abort(403, 'No tienes asginado este avalúo.');

        $id =  $avaluo->getKey() ? $avaluo->id : null;

        return view('valuacion.avaluo_predio_ignorado', compact('id'));

    }

}
