<?php

namespace App\Traits\Tramties\Ventanilla;

use App\Models\Predio;

trait PrediosTrait
{

    public function buscarPredio(){

        $this->validate([
            'localidad' => 'required',
            'oficina' => 'required',
            'tipo' => 'required',
            'registro' => 'required'
        ]);

        if($this->modelo_editar->clave_ingreso == 'D726' && $this->tipo != 2){

            $this->dispatch('mostrarMensaje', ['warning', "El predio no es rustico."]);

            return;

        }

        if($this->modelo_editar->clave_ingreso == 'D727' && $this->tipo != 1){

            $this->dispatch('mostrarMensaje', ['warning', "El predio no es urbano."]);

            return;

        }

        $this->predio = Predio::with('propietarios.persona')
                                ->where('localidad', $this->localidad)
                                ->where('oficina', $this->oficina)
                                ->where('tipo_predio', $this->tipo)
                                ->where('numero_registro', $this->registro)
                                ->first();

        if(!$this->predio){

            $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial no esta registrada."]);

            return;

        }

        if($this->predio->status !== 'activo'){

            $this->dispatch('mostrarMensaje', ['warning', "El predio no esta activo."]);

            $this->predio = null;

            return;

        }

    }

    public function agregarPredio(){

        if(in_array($this->servicio['clave_ingreso'], ['D731', 'D150', 'D726', 'D727', 'DM30'])  && count($this->predios) == 1){

            $this->dispatch('mostrarMensaje', ['warning', "Solo es posible agregar 1 predio al servicio."]);

            return;

        }

        if($this->editar && count($this->predios) >= $this->modelo_editar->cantidad){

            $this->dispatch('mostrarMensaje', ['warning', "Solo es posible agregar " . $this->modelo_editar->cantidad . " predios."]);

            return;

        }

        $colection = collect($this->predios);

        if($colection->contains('id', $this->predio->id)){

            $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial ya esta agregada."]);

        }else{

            array_push($this->predios, $this->predio->toArray());

        }

        $this->predio = null;

        $this->modelo_editar->cantidad = count($this->predios);

        $this->updatedModeloEditarTipoServicio();

    }

    public function quitarPredio($id){

        $a = null;

        foreach ($this->predios as $k => $val) {

            if ($val['id'] == $id) {

                $a = $k;

            }

        }

        unset($this->predios[$a]);

        if(!$this->editar)
            $this->modelo_editar->cantidad = count($this->predios);

        $this->updatedModeloEditarTipoServicio();

    }

}
