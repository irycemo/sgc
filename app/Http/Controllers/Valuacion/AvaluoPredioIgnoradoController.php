<?php

namespace App\Http\Controllers\Valuacion;

use App\Models\Avaluo;
use App\Http\Controllers\Controller;

class AvaluoPredioIgnoradoController extends Controller
{
    public function __invoke(Avaluo $avaluo)
    {

        if($avaluo->getKey())
            $this->authorize('view', $avaluo);

        $id = $avaluo->id;

        return view('valuacion.avaluo_predio_ignorado', compact('id'));
    }
}
