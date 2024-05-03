<?php

namespace App\Http\Services\Traslados;

use App\Models\User;
use App\Models\Predio;
use App\Exceptions\TrasladoServiceException;

class TrasladoService{

    public function asignarTraslado(int $predioId):int
    {

        $oficina = Predio::find($predioId)->oficina;

        if($oficina === 101){

            $fiscales = User::withCount('trasladosAsignados')
                            ->where('status', 'activo')
                            ->whereHas('roles', function($q){
                                $q->where('name', 'Fiscal');
                            })
                            ->whereHas('oficina', function($q) use ($oficina){
                                $q->where('oficina', $oficina);
                            })
                            ->get();

            if(!$fiscales->count()){

                throw new TrasladoServiceException('No hay fiscales para asignar el traslado.');

            }else{

                return $fiscales->sortBy('traslados_asignados_count')->first()->id;

            }

        }else{

            $fiscales = User::withCount('trasladosAsignados')
                            ->where('status', 'activo')
                            ->whereHas('oficina', function($q) use ($oficina){
                                $q->where('oficina', $oficina);
                            })
                            ->get();

            if(!$fiscales->count()){

                throw new TrasladoServiceException('No hay fiscales para asignar el traslado.');

            }else{

                return $fiscales->sortBy('traslados_asignados_count')->first()->id;

            }

        }

    }

}
