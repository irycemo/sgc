<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Oficina;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OficinaResource;

class ConsultaOficinaController extends Controller
{

    public function __invoke(){

        return OficinaResource::collection(Oficina::all());

    }

}
