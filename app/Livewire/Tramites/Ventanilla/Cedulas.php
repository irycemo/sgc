<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Exceptions\GeneralException;
use App\Services\Tramites\TramiteService;
use App\Traits\Tramties\Ventanilla\ComunTrait;
use App\Traits\Tramties\Ventanilla\PrediosTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Cedulas extends Component
{

    use ComunTrait;
    use PrediosTrait;

    protected function rules(){

        return [
            'modelo_editar.tipo_tramite' => 'required',
            'modelo_editar.servicio_id' => 'required',
            'modelo_editar.solicitante' => 'required',
            'modelo_editar.nombre_solicitante' => 'required',
            'modelo_editar.monto' => 'required',
            'modelo_editar.tipo_servicio' => 'required',
            'modelo_editar.usuario_tramites_linea_id' => 'nullable',
            'modelo_editar.cantidad' => 'required|numeric',
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
            'modelo_editar.numero_oficio' => Rule::requiredIf(
                                                                $this->modelo_editar->solicitante == 'Oficialia de partes' ||
                                                                $this->modelo_editar->solicitante == 'Escrituración social'
                                                            ),
            'predios' => ['nullable', Rule::requiredIf($this->servicio['nombre'] != 'Cédula de actualización regularización')]
        ];

    }

    public function crear(){

        $this->validate();

        try {

            DB::transaction(function () {

                $tramite = (new TramiteService($this->modelo_editar))->crear($this->predios);

                $this->js('window.open(\' '. route('tramites.orden', $tramite) . '\', \'_blank\');');

                $this->resetearTodo();

                $this->dispatch('reset');

                $this->dispatch('mostrarMensaje', ['success', "El trámite se creó con éxito."]);

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

            $this->cargaInicial($this->servicio);

        } catch (\Throwable $th) {

            Log::error("Error al crear trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

            $this->cargaInicial($this->servicio);

        }


    }

    public function mount(){

        $this->cargaInicial($this->servicio);

        $this->tramite_adiciona_año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.cedulas');
    }
}
