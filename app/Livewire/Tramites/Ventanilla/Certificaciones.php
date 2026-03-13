<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Models\Tramite;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\Tramites\TramiteService;
use App\Traits\Tramties\Ventanilla\ComunTrait;
use App\Traits\Tramties\Ventanilla\PrediosTrait;

class Certificaciones extends Component
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
            'modelo_editar.cantidad' => 'required|numeric',
            'modelo_editar.ligado_a' => ['nullable', Rule::requiredIf(in_array($this->servicio['clave_ingreso'], ['D924', 'D925', 'D926', 'D927']))],
            'modelo_editar.observaciones' => Rule::requiredIf($this->modelo_editar->tipo_tramite === "exento"),
            'modelo_editar.numero_oficio' => Rule::requiredIf(
                                                                $this->modelo_editar->solicitante == 'Oficialia de partes' ||
                                                                $this->modelo_editar->solicitante == 'Escrituración social'
                                                            ),
            'predios' => ['nullable', Rule::requiredIf(
                                                            in_array($this->servicio['clave_ingreso'], ['DM30', 'DM32', 'DM31'])

                                                            ||

                                                            ($this->servicio['clave_ingreso'] == 'D923' && $this->servicio['nombre'] != 'Certificado negativo catastral')
                                                    )]
        ];

    }

    public function buscarTramiteAdiciona(){

        $this->validate([
            'tramite_adiciona_año' => 'required',
            'tramite_adiciona_folio' => 'required',
            'tramite_adiciona_usuario' => 'required',
        ]);

        $this->tramiteAdicionado = Tramite::where('año', $this->tramite_adiciona_año)
                                        ->where('folio', $this->tramite_adiciona_folio)
                                        ->where('usuario', $this->tramite_adiciona_usuario)
                                        ->whereHas('servicio', function($q){
                                            $q->where('clave_ingreso', 'DM30');
                                        })
                                        ->first();

        if(!$this->tramiteAdicionado){

            $this->dispatch('mostrarMensaje', ['warning', "No se encontro el trámite."]);

            $this->modelo_editar->ligado_a = null;

            return;

        }

        if(!$this->tramiteAdicionado->fecha_pago){

            $this->dispatch('mostrarMensaje', ['warning', "El trámite a adicionar no esta pagado."]);

            $this->modelo_editar->ligado_a = null;

            return;

        }

        if($this->tramiteAdicionado->ligado_a){

            $this->dispatch('mostrarMensaje', ['warning', "El trámite a adicionar ya esta ligado a otro trámite."]);

            $this->modelo_editar->ligado_a = null;

            return;

        }

        $this->dispatch('mostrarMensaje', ['success', "El trámite a adicionar es valido."]);

        $this->modelo_editar->ligado_a = $this->tramiteAdicionado->id;

    }

    public function crear(){

        $this->validate();

        try {

            DB::transaction(function () {

                $tramite = (new TramiteService($this->modelo_editar))->crear($this->predios);

                /* Ligar predio del anticipo de historia */
                if($this->modelo_editar->ligado_a){

                    $this->tramiteAdicionado?->update(['ligado_a' => $tramite->id]);

                    $tramite->predios()->attach($this->tramiteAdicionado->predios()->first()->id);

                }

                $this->js('window.open(\' '. route('tramites.orden', $tramite) . '\', \'_blank\');');

                $this->resetearTodo();

                $this->dispatch('reset');

                $this->dispatch('mostrarMensaje', ['success', "El trámite se creó con éxito."]);

            });

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['error', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al crear trámite por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }


    }

    public function mount(){

        $this->cargaInicial($this->servicio);

        $this->tramite_adiciona_año = now()->format('Y');

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.certificaciones');
    }

}
