<?php

namespace App\Services\Asignacion;

use App\Models\User;
use App\Models\Oficina;
use App\Models\Traslado;
use App\Exceptions\GeneralException;

class AsignacionTrasladosService{

    public function obtenerUsuariosTraslado($oficina_id, $predio_id):int
    {

        $traslado = Traslado::where('predio_id', $predio_id)->first();

        if($traslado) {

            if($traslado->asignadoA->estado == 'activo'){

                return $traslado->asignado_a;

            }

        }

        $oficina = Oficina::find($oficina_id);

        if($oficina->nombre != 'MORELIA'){

            $user =  User::inRandomOrder()
                            ->where('estado', 'activo')
                            ->where('oficina_id', $oficina_id)
                            ->first();

            if(!$user){

                throw new GeneralException('No se encontraron usuarios de ' . $oficina->nombre . ' para asignar el traslado.');

            }else{

                return $user->id;

            }

        }else{

            $users =  User::inRandomOrder()
                            ->where('estado', 'activo')
                            ->where('oficina_id', $oficina_id)
                            ->whereHas('roles', function($q){
                                $q->where('name', 'Fiscal');
                            })
                            ->withCount('traslados')
                            ->get();



            if(!$users->count()){

                throw new GeneralException('No se encontraron usuarios de ' . $oficina->nombre . ' para asignar el traslado.');

            }else{

                return $users->sortByDesc('traslados_count')->first()->id;

            }

        }

    }

}