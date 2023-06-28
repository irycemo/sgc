<?php

namespace App\Http\Controllers\Valuacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValuacionYDesgloseController extends Controller
{
    public function __invoke()
    {
        return view('valuacion.valuacion_y_desglose');
    }
}
