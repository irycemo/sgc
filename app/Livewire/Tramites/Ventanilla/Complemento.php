<?php

namespace App\Livewire\Tramites\Ventanilla;

use App\Exceptions\GeneralException;
use App\Models\Servicio;
use App\Models\Tramite;
use App\Services\Tramites\TramiteService;
use App\Traits\Tramties\Ventanilla\ComunTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Complemento extends Component
{

    use ComunTrait;

    public $show_servicios_historia = false;
    public $servicio_historia_seleccionado;
    public $servicios_historia;

    protected function rules(){

        return [
            'modelo_editar.tipo_tramite' => 'required',
            'modelo_editar.servicio_id' => 'required',
            'modelo_editar.solicitante' => 'required',
            'modelo_editar.nombre_solicitante' => 'required',
            'modelo_editar.monto' => 'required|gt:0',
            'modelo_editar.tipo_servicio' => 'required',
            'modelo_editar.cantidad' => 'required|numeric',
            'modelo_editar.ligado_a' => 'required_if:adicionaTramite,true',
            'modelo_editar.observaciones' => 'required',
            'modelo_editar.usuario_tramites_linea_id' => 'nullable',
            'modelo_editar.numero_oficio' => Rule::requiredIf(
                                                                $this->modelo_editar->solicitante == 'Oficialia de partes' ||
                                                                $this->modelo_editar->solicitante == 'Escrituración social'
                                                            ),
        ];

    }

    public function updatedModeloEditarCantidad(){

        if($this->tramiteAdicionado?->servicio->categoria->nombre == 'Inspecciones Oculares'){

            $this->modelo_editar->monto = $this->tramiteAdicionado?->servicio->ordinario * 0.2 * $this->modelo_editar->cantidad;

            $this->modelo_editar->observaciones = 'TRÁMITE CON COBRO DEL 20% POR INSPECCIÓN, EN CANTIDADES MAYORES A 1';

        }elseif($this->tramiteAdicionado?->servicio->categoria->nombre == 'Desglose de predios y valuación'){

            $this->modelo_editar->monto = $this->tramiteAdicionado?->servicio->ordinario * $this->modelo_editar->cantidad;

        }

    }

    public function updatedServicioHistoriaSeleccionado(){

        $servicios_historia = $this->servicios_historia->where('id', $this->servicio_historia_seleccionado)->first();

        $this->modelo_editar->monto = $servicios_historia->ordinario - $this->tramiteAdicionado->monto;

    }

    public function buscarTramiteAdiciona(){

        $this->show_servicios_historia = false;

        $this->validate([
            'tramite_adiciona_año' => 'required',
            'tramite_adiciona_folio' => 'required',
            'tramite_adiciona_usuario' => 'required',
        ]);

        $this->tramiteAdicionado = Tramite::where('año', $this->tramite_adiciona_año)
                                        ->where('folio', $this->tramite_adiciona_folio)
                                        ->where('usuario', $this->tramite_adiciona_usuario)
                                        ->first();

        if(!$this->tramiteAdicionado){

            $this->dispatch('mostrarMensaje', ['warning', "No se encontro el trámite."]);

            $this->modelo_editar->ligado_a = null;

            return;

        }

        if($this->tramiteAdicionado->estado != 'pagado'){

            $this->dispatch('mostrarMensaje', ['warning', "El trámite no esta pagado."]);

            $this->modelo_editar->ligado_a = null;

            $this->reset(['tramiteAdicionado']);

            return;

        }

        $this->modelo_editar->ligado_a = $this->tramiteAdicionado->id;

        $this->modelo_editar->solicitante = $this->tramiteAdicionado->solicitante;

        $this->modelo_editar->nombre_solicitante = $this->tramiteAdicionado->nombre_solicitante;

        if(in_array($this->tramiteAdicionado?->servicio->clave_ingreso, ['DM31'])){

            $this->modelo_editar->monto = $this->tramiteAdicionado->monto;

        }elseif(in_array($this->tramiteAdicionado?->servicio->clave_ingreso, ['D924', 'D925', 'D926'])){

            $this->show_servicios_historia = true;

        }

    }

    public function crear(){

        $this->validate();

        try {

            DB::transaction(function () {

                if(in_array($this->tramiteAdicionado?->servicio->clave_ingreso, ['D924', 'D925', 'D926'])){

                    $this->tramiteAdicionado->update([
                        'servicio_id' => $this->servicio_historia_seleccionado,
                        'estado' => 'nuevo',
                        'linea_de_captura' => null,
                        'orden_de_pago' => null,
                        'fecha_pago' => null,
                    ]);

                }

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

            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);

            $this->cargaInicial($this->servicio);

        }


    }

    public function mount(){

        $this->cargaInicial($this->servicio);

        $this->tramite_adiciona_año = now()->format('Y');

        $this->servicios_historia = Servicio::whereIn('clave_ingreso', ['D927', 'D925', 'D926'])->get();

    }

    public function render()
    {
        return view('livewire.tramites.ventanilla.complemento');
    }

}
