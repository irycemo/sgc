<?php

namespace App\Http\Controllers\Valuacion;

use App\Models\Avaluo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AvaluoPredioIgnoradoController extends Controller
{

    public function __invoke(Avaluo $avaluo)
    {

        $id =  $avaluo->getKey() ? $avaluo->id : null;

        return view('valuacion.avaluo_predio_ignorado', compact('id'));

    }

}
