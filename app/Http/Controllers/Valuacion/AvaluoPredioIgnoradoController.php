<?php

namespace App\Http\Controllers\Valuacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AvaluoPredioIgnoradoController extends Controller
{
    public function __invoke()
    {
        return view('valuacion.avaluo_predio_ignorado');
    }
}
