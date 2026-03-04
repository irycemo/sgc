<?php

namespace App\Http\Controllers\Valuacion;

use App\Models\Avaluo;
use App\Http\Controllers\Controller;

class Valuacion extends Controller
{

    public function __invoke(Avaluo $avaluo)
    {

        if($avaluo->asignado_a !== auth()->id()) abort(403, 'No tienes asginado este avalúo.');

        $id =  $avaluo->getKey() ? $avaluo->id : null;

        return view('valuacion.valuacion', compact('id'));

    }

}
