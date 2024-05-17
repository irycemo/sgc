<?php

namespace App\Livewire\Cartografia;

use App\Models\Predio;
use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ConciliarManzanas extends Component
{

    public $region_catastral;
    public $municipio;
    public $zona_catastral;
    public $localidad;
    public $sector;
    public $manzana;
    public $nuevo_sector;
    public $nueva_manzana;
    public $predio_inicial;
    public $predio_final;

    public $flag = false;

    public Predio $predio;

    public function cambiarManzana(){

        $this->validate([
            'region_catastral' => 'required|numeric|min:1',
            'municipio' => 'required|numeric|min:1',
            'localidad' => 'required|numeric|min:1',
            'sector' => 'required|numeric|min:1',
            'zona_catastral' => 'required|numeric|min:1,|same:localidad',
            'manzana' => 'required|numeric|min:1',
            'nueva_manzana' => 'required|numeric|min:1',
            'nuevo_sector' => 'required|numeric|min:1',
            'predio_inicial' => 'required|numeric|min:1',
            'predio_final' => 'required|numeric|min:1',
        ]);

        $predios = Predio::where('region_catastral', $this->region_catastral)
                            ->where('municipio', $this->municipio)
                            ->where('zona_catastral', $this->zona_catastral)
                            ->where('localidad', $this->localidad)
                            ->where('sector', $this->sector)
                            ->where('manzana', $this->manzana)
                            ->whereBetween('predio', [$this->predio_inicial, $this->predio_final])
                            ->get();

        if($predios->count() == 0){

            $this->dispatch('mostrarMensaje', ['error', "No se encontraron predios con los datos ingresados."]);

            return;

        }

        try {

            DB::transaction(function () use($predios){

                foreach ($predios as $predio) {

                    $aux = Predio::where('region_catastral', $this->region_catastral)
                                    ->where('municipio', $this->municipio)
                                    ->where('zona_catastral', $this->zona_catastral)
                                    ->where('localidad', $this->localidad)
                                    ->where('sector', $this->sector)
                                    ->where('sector', $this->nuevo_sector)
                                    ->where('manzana', $this->nueva_manzana)
                                    ->where('predio', $predio->predio)
                                    ->where('edificio', $predio->edificio)
                                    ->where('departamento', $predio->departamento)
                                    ->first();

                    if($aux){

                        throw new Exception("El predio " .
                                                $aux->estado . '-' .
                                                $aux->region_catastral . '-' .
                                                $aux->municipio. '-' .
                                                $aux->zona_catastral. '-'.
                                                $aux->localidad . '-' .
                                                $aux->sector . '-' .
                                                $aux->manzana . '-' .
                                                $aux->predio .
                                                $aux->edificio .
                                                $aux->departamento . " ya existe."
                                            );
                    }

                    if($this->nueva_manzana == 0 && ($predio->predio != $predio->numero_registro)){

                        throw new Exception("El predio y el número de registro noson iguales en el predio: " .
                                                $aux->estado . '-' .
                                                $aux->region_catastral . '-' .
                                                $aux->municipio. '-' .
                                                $aux->zona_catastral. '-'.
                                                $aux->localidad . '-' .
                                                $aux->sector . '-' .
                                                $aux->manzana . '-' .
                                                $aux->predio .
                                                $aux->edificio .
                                                $aux->departamento
                                            );

                    }

                    $predio->update([
                        'sector' => $this->nuevo_sector,
                        'manzana' => $this->nueva_manzana,
                        'actualizado_por' => auth()->id()
                    ]);

                    $this->predio->audits()->latest()->first()->update(['tags' => 'Concilió sector / numero de manzana']);

                }

            });

            $this->dispatch('mostrarMensaje', ['success', "Se concilió con éxito."]);

        }catch (\Exception $th) {

            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);


        }catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);


        }


    }

    public function render()
    {
        return view('livewire.cartografia.conciliar-manzanas')->extends('layouts.admin');
    }
}
