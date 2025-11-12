<?php

namespace App\Livewire\GestionCatastral\RevisionTraslados;

use App\Models\Persona;
use Livewire\Component;
use App\Models\Traslado;
use Illuminate\Support\Str;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Storage;
use App\Traits\Personas\BuscarPersonaTrait;
use App\Services\Predio\ArchivoPredioService;
use App\Services\SistemaTramitesLinea\SistemaTramitesLineaService;
use App\Services\SistemaPeritosExternos\SistemaPeritosExternosService;

class RevisarTraslado extends Component
{

    use BuscarPersonaTrait;

    public Traslado $traslado;

    public $aviso;
    public $avaluo;

    public $rechazos;
    public $rechazo;
    public $observaciones;
    public $modalRechazar = false;
    public $modalAutorizar = false;
    public $modalOperar = false;

    public $transmitentes = [];

    public function seleccionarMotivo($key){

        $this->rechazo['key'] = $key;
        $this->rechazo['value'] = $this->rechazos[$key];

    }

    public function updatedTransmitentes($value, $index){

        $i = explode('.', $index);

        if($this->transmitentes[$i[0]][$i[1]] == ''){

            $this->transmitentes[$i[0]][$i[1]] = 0;

        }

    }

    public function rechazarTraslado(){

        $this->validate(['observaciones' => 'required']);

        try {

            DB::transaction(function () {

                $observacion = "<p>" . $this->rechazo['key'] . "</p><p>Observaciones:</p><p>" . $this->observaciones . "</p>";

                (new SistemaTramitesLineaService())->rechazarAviso($this->traslado->aviso_stl, $observacion);

                $this->traslado->update(['estado' => 'rechazado', 'actualizado_por' => auth()->id()]);

                $this->traslado->audits()->latest()->first()->update(['tags' => 'Rechazó traslado']);

                $this->traslado->rechazos()->create([
                    'observaciones' => $observacion,
                    'creado_por' => auth()->id()
                ]);

            });

            return redirect()->route('revision_traslados');

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al rechazar aviso en Sistema de Trámties en línea por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function autorizarTraslado(){

        $this->validate(['observaciones' => 'nullable']);

        try {

            (new SistemaTramitesLineaService())->autorizarAviso($this->traslado->aviso_stl, $this->observaciones);

            $this->traslado->update([
                'valor_isai' => $this->aviso['valor_isai'],
                'estado' => 'autorizado',
                'actualizado_por' => auth()->id()
            ]);

            $this->traslado->audits()->latest()->first()->update(['tags' => 'Autorizó traslado']);

            return redirect()->route('revision_traslados');

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['error', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al autorizar aviso en Sistema de Trámties en línea por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function operarTraslado(){

        try {

            /* $this->revisarPagoIsai(); */

            if($this->traslado->tipo == 'revision'){

                $this->revisarProcentajes();

            }

            DB::transaction(function () {

                $this->actualizarPredio();

                (new SistemaTramitesLineaService())->operarAviso($this->traslado->aviso_stl);

                if($this->traslado->tipo == 'revision'){

                    (new SistemaPeritosExternosService())->operarAvaluo($this->traslado->avaluo_spe);

                    $this->anexarFotosAlPredio();

                }

                $this->traslado->update(['estado' => 'operado', 'actualizado_por' => auth()->id()]);

                $this->traslado->audits()->latest()->first()->update(['tags' => 'Operó traslado']);

                $this->procesarTramtie();

                $this->anexarArchivoAlPredio();

            });

            return redirect()->route('revision_traslados');

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al operar traslado: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function procesarTramtie(){

        $this->traslado->tramite->predios()->updateExistingPivot($this->traslado->predio_id, ['estado' => 'O']);

        $usados = $this->traslado->tramite->predios()->wherePivot('estado', 'O')->count();

        $this->traslado->tramite->update(['usados' => $usados]);

        $this->traslado->tramite->audits()->latest()->first()->update(['tags' => 'Operó traslado ' . $this->traslado->predio->cuentaPredial()]);

        if($this->traslado->tramite->cantidad === $usados){

            $this->traslado->tramite->update(['estado' => 'concluido']);

            $this->traslado->tramite->audits()->latest()->first()->update(['tags' => 'Finalizó trámite']);

        }

    }

    public function anexarArchivoAlPredio(){

        $pdfContent = file_get_contents($this->aviso['archivo']);

        $nombre_temp = Str::random(40) . '.pdf';

        Storage::put('livewire-tmp/'. $nombre_temp, $pdfContent);

        (new ArchivoPredioService($this->traslado->predio, null))->guardarConUrl('livewire-tmp/'. $nombre_temp);

    }

    public function anexarFotosAlPredio(){

        $urls = [
            'croquis' => $this->avaluo['croquis'],
            'fachada' => $this->avaluo['fachada'],
            'foto2' => $this->avaluo['foto2'],
            'foto3' => $this->avaluo['foto3'],
            'foto4' => $this->avaluo['foto4'],
            'microlocalizacion' => $this->avaluo['microlocalizacion'],
            'poligonoImagen' => $this->avaluo['poligonoImagen']];

        (new ArchivoPredioService($this->traslado->predio, null))->anexarFotosAlPredio($urls);

    }

    public function actualizarPredio(){

        $this->traslado->predio->colindancias()->delete();

        foreach($this->aviso['predio']['colindancias'] as $colindancia){

            $this->traslado->predio->colindancias()->create([
                'viento' => $colindancia['viento'],
                'longitud' => $colindancia['longitud'],
                'descripcion' => $colindancia['descripcion'],
            ]);

        }

        if($this->traslado->tipo == 'revision'){

            $this->traslado->predio->update([
                'codigo_postal' => $this->aviso['predio']['codigo_postal'] ?? null,
                'nombre_asentamiento' => $this->aviso['predio']['nombre_asentamiento']  ?? null,
                'tipo_asentamiento' => $this->aviso['predio']['tipo_asentamiento']  ?? null,
                'nombre_vialidad' => $this->aviso['predio']['nombre_vialidad']  ?? null,
                'tipo_vialidad' => $this->aviso['predio']['tipo_vialidad']  ?? null,
                'numero_exterior' => $this->aviso['predio']['numero_exterior']  ?? null,
                'numero_exterior_2' => $this->aviso['predio']['numero_exterior_2']  ?? null,
                'numero_interior' => $this->aviso['predio']['numero_interior']  ?? null,
                'numero_adicional' => $this->aviso['predio']['numero_adicional']  ?? null,
                'numero_adicional_2' => $this->aviso['predio']['numero_adicional_2']  ?? null,
                'numero_interior' => $this->aviso['predio']['numero_interior']  ?? null,
                'lote_fraccionador' => $this->aviso['predio']['lote_fraccionador']  ?? null,
                'manzana_fraccionador' => $this->aviso['predio']['manzana_fraccionador']  ?? null,
                'etapa_fraccionador' => $this->aviso['predio']['etapa_fraccionador']  ?? null,
                'nombre_predio' => $this->aviso['predio']['nombre_predio']  ?? null,
                'nombre_edificio' => $this->aviso['predio']['nombre_edificio']  ?? null,
                'clave_edificio' => $this->aviso['predio']['clave_edificio']  ?? null,
                'departamento_edificio' => $this->aviso['predio']['departamento_edificio']  ?? null,
                'xutm' => $this->aviso['predio']['xutm']  ?? null,
                'yutm' => $this->aviso['predio']['yutm']  ?? null,
                'zutm' => $this->aviso['predio']['zutm']  ?? null,
                'lon' => $this->aviso['predio']['lon']  ?? null,
                'lat' => $this->aviso['predio']['lat']  ?? null,
                'uso_1' => $this->avaluo['predio']['uso_1']  ?? null,
                'uso_2' => $this->avaluo['predio']['uso_2']  ?? null,
                'uso_3' => $this->avaluo['predio']['uso_3']  ?? null,
                'superficie_terreno' => $this->avaluo['predio']['superficie_terreno']  ?? null,
                'superficie_construccion' => $this->avaluo['predio']['superficie_construccion']  ?? null,
                'area_comun_terreno' => $this->avaluo['predio']['area_comun_terreno']  ?? null,
                'area_comun_construccion' => $this->avaluo['predio']['area_comun_construccion']  ?? null,
                'valor_total_terreno' => $this->avaluo['predio']['valor_total_terreno']  ?? null,
                'valor_total_construccion' => $this->avaluo['predio']['valor_total_construccion']  ?? null,
                'superficie_total_terreno' => $this->avaluo['predio']['superficie_total_terreno']  ?? null,
                'superficie_total_construccion' => $this->avaluo['predio']['superficie_total_construccion']  ?? null,
                'valor_catastral' => $this->aviso['predio']['valor_catastral']  ?? null,
            ]);

            $this->traslado->predio->audits()->latest()->first()->update(['tags' => 'Actualizó mediante revision de aviso', 'tramite_id' => $this->traslado->tramite_aviso]);

            $this->traslado->predio->terrenos()->delete();

            foreach($this->avaluo['terrenos'] as $terreno){

                $this->traslado->predio->terrenos()->create([
                    'superficie' => $terreno['superficie'],
                    'demerito' => $terreno['demerito'],
                    'valor_demeritado' => $terreno['valor_demeritado'],
                    'valor_unitario' => $terreno['valor_unitario'],
                    'valor_terreno' => $terreno['valor_terreno'],
                ]);

            }

            $this->traslado->predio->construcciones()->delete();

            foreach($this->avaluo['construcciones'] as $construccion){

                $this->traslado->predio->construcciones()->create([
                    'referencia' => $construccion['referencia'],
                    'tipo' => $construccion['tipo'],
                    'uso' => $construccion['uso'],
                    'estado' => $construccion['estado'],
                    'calidad' => $construccion['calidad'],
                    'niveles' => $construccion['niveles'],
                    'superficie' => $construccion['superficie'],
                    'valor_unitario' => $construccion['valor_unitario'],
                    'valor_construccion' => $construccion['valor_construccion'] ?? 0,
                ]);

            }

            $this->traslado->predio->terrenosComun()->delete();

            foreach($this->avaluo['terrenos_comun'] as $terrenoComun){

                $this->traslado->predio->terrenosComun()->create([
                    'area_terreno_comun' => $terrenoComun['area_terreno_comun'],
                    'indiviso_terreno' => $terrenoComun['indiviso_terreno'],
                    'valor_unitario' => $terrenoComun['valor_unitario'],
                    'valor_terreno_comun' => $terrenoComun['valor_terreno_comun'],
                    'superficie_proporcional' => $terrenoComun['superficie_proporcional'],
                ]);

            }

            $this->traslado->predio->construccionesComun()->delete();

            foreach($this->avaluo['construcciones_comun'] as $construccionComun){

                $this->traslado->predio->construccionesComun()->create([
                    'area_comun_construccion' => $construccionComun['area_comun_construccion'],
                    'indiviso_construccion' => $construccionComun['indiviso_construccion'],
                    'valor_clasificacion_construccion' => $construccionComun['valor_clasificacion_construccion'],
                    'valor_construccion_comun' => $construccionComun['valor_construccion_comun'],
                    'superficie_proporcional' => $construccionComun['superficie_proporcional'],
                ]);

            }

            foreach($this->transmitentes as $propietario){

                if($propietario['porcentaje_propiedad'] == 0 && $propietario['porcentaje_nuda'] == 0 && $propietario['porcentaje_usufructo'] == 0){

                    $this->traslado->predio->propietarios()->whereHas('persona', function($q) use($propietario){
                                                            $q->where('nombre', $propietario['nombre'])
                                                                ->where('ap_paterno', $propietario['ap_paterno'])
                                                                ->where('ap_materno', $propietario['ap_materno'])
                                                                ->where('razon_social', $propietario['razon_social']);
                                                            })
                                                            ->delete();


                }else{

                     $aux = $this->traslado->predio->propietarios()->whereHas('persona', function($q) use($propietario){
                                                                                        $q->where('nombre', $propietario['nombre'])
                                                                                            ->where('ap_paterno', $propietario['ap_paterno'])
                                                                                            ->where('ap_materno', $propietario['ap_materno'])
                                                                                            ->where('razon_social', $propietario['razon_social']);
                                                                                        })
                                                                                        ->first();

                    $aux->update([
                        'porcentaje_propiedad' => $propietario['porcentaje_propiedad'],
                        'porcentaje_nuda' => $propietario['porcentaje_nuda'],
                        'porcentaje_usufructo' => $propietario['porcentaje_usufructo'],
                    ]);

                }

            }

            foreach($this->aviso['predio']['adquirientes'] as $adquiriente){

                $persona = $this->buscarPersona($adquiriente['persona']['rfc'], $adquiriente['persona']['curp'], $adquiriente['persona']['tipo'], $adquiriente['persona']['nombre'], $adquiriente['persona']['ap_materno'], $adquiriente['persona']['ap_paterno'], $adquiriente['persona']['razon_social']);

                /* Persona::query()
                            ->where(function($q) use($adquiriente){
                                $q->when(isset($adquiriente['nombre']), fn($q) => $q->where('nombre',$adquiriente['nombre']))
                                    ->when(isset($adquiriente['ap_paterno']), fn($q) => $q->where('ap_paterno', $adquiriente['ap_paterno']))
                                    ->when(isset($adquiriente['ap_materno']), fn($q) => $q->where('ap_materno', $adquiriente['ap_materno']));
                            })
                            ->when(isset($adquiriente['razon_social']), fn($q) => $q->orWhere('razon_social', $adquiriente['razon_social']))
                            ->when(isset($adquiriente['rfc']), fn($q) => $q->orWhere('rfc', $adquiriente['rfc']))
                            ->when(isset($adquiriente['curp']), fn($q) => $q->orWhere('curp', $adquiriente['curp']))
                            ->when(isset($adquiriente['correo']), fn($q) => $q->orWhere('correo', $adquiriente['correo']))
                            ->first(); */

                if(!$persona){

                    $persona = Persona::create([
                        'tipo' =>  $adquiriente['persona']['tipo'],
                        'nombre' => $adquiriente['persona']['nombre'] ?? null,
                        'ap_paterno' => $adquiriente['persona']['ap_paterno'] ?? null,
                        'ap_materno' => $adquiriente['persona']['ap_materno'] ?? null,
                        'razon_social' => $adquiriente['persona']['razon_social'] ?? null,
                        'rfc' => $adquiriente['persona']['rfc'],
                        'curp' => $adquiriente['persona']['curp'],
                        'fecha_nacimiento' => $adquiriente['persona']['fecha_nacimiento'],
                        'nacionalidad' => $adquiriente['persona']['nacionalidad'],
                        'estado_civil' => $adquiriente['persona']['estado_civil'],
                        'calle' => $adquiriente['persona']['calle'],
                        'numero_exterior' => $adquiriente['persona']['numero_exterior'],
                        'numero_interior' => $adquiriente['persona']['numero_interior'],
                        'colonia' => $adquiriente['persona']['colonia'],
                        'cp' => $adquiriente['persona']['cp'],
                        'entidad' => $adquiriente['persona']['entidad'],
                        'municipio' => $adquiriente['persona']['municipio'],
                        'ciudad' => $adquiriente['persona']['ciudad'],
                    ]);

                }

                $this->traslado->predio->propietarios()->create([
                    'persona_id' => $persona->id,
                    'tipo' => 'PROPIETARIO',
                    'porcentaje_propiedad' => $adquiriente['porcentaje_propiedad'],
                    'porcentaje_nuda' => $adquiriente['porcentaje_nuda'],
                    'porcentaje_usufructo' => $adquiriente['porcentaje_usufructo'],
                    'creado_por' => auth()->id()
                ]);

            }

        }else{

            $this->traslado->predio->update([
                'codigo_postal' => $this->aviso['predio']['codigo_postal'] ?? null,
                'nombre_asentamiento' => $this->aviso['predio']['nombre_asentamiento']  ?? null,
                'tipo_asentamiento' => $this->aviso['predio']['tipo_asentamiento']  ?? null,
                'nombre_vialidad' => $this->aviso['predio']['nombre_vialidad']  ?? null,
                'tipo_vialidad' => $this->aviso['predio']['tipo_vialidad']  ?? null,
                'numero_exterior' => $this->aviso['predio']['numero_exterior']  ?? null,
                'numero_exterior_2' => $this->aviso['predio']['numero_exterior_2']  ?? null,
                'numero_interior' => $this->aviso['predio']['numero_interior']  ?? null,
                'numero_adicional' => $this->aviso['predio']['numero_adicional']  ?? null,
                'numero_adicional_2' => $this->aviso['predio']['numero_adicional_2']  ?? null,
                'numero_interior' => $this->aviso['predio']['numero_interior']  ?? null,
                'lote_fraccionador' => $this->aviso['predio']['lote_fraccionador']  ?? null,
                'manzana_fraccionador' => $this->aviso['predio']['manzana_fraccionador']  ?? null,
                'etapa_fraccionador' => $this->aviso['predio']['etapa_fraccionador']  ?? null,
                'nombre_predio' => $this->aviso['predio']['nombre_predio']  ?? null,
                'nombre_edificio' => $this->aviso['predio']['nombre_edificio']  ?? null,
                'clave_edificio' => $this->aviso['predio']['clave_edificio']  ?? null,
                'departamento_edificio' => $this->aviso['predio']['departamento_edificio']  ?? null,
                'xutm' => $this->aviso['predio']['xutm']  ?? null,
                'yutm' => $this->aviso['predio']['yutm']  ?? null,
                'zutm' => $this->aviso['predio']['zutm']  ?? null,
                'lon' => $this->aviso['predio']['lon']  ?? null,
                'lat' => $this->aviso['predio']['lat']  ?? null,
                'uso_1' => $this->avaluo['predio']['uso_1']  ?? null,
                'uso_2' => $this->avaluo['predio']['uso_2']  ?? null,
                'uso_3' => $this->avaluo['predio']['uso_3']  ?? null,
                'superficie_terreno' => $this->aviso['predio']['superficie_terreno']  ?? null,
                'superficie_construccion' => $this->aviso['predio']['superficie_construccion']  ?? null,
                'area_comun_terreno' => $this->aviso['predio']['area_comun_terreno']  ?? null,
                'area_comun_construccion' => $this->aviso['predio']['area_comun_construccion']  ?? null,
                'valor_total_terreno' => $this->aviso['predio']['valor_total_terreno']  ?? null,
                'valor_total_construccion' => $this->aviso['predio']['valor_total_construccion']  ?? null,
                'superficie_total_terreno' => $this->aviso['predio']['superficie_total_terreno']  ?? null,
                'superficie_total_construccion' => $this->aviso['predio']['superficie_total_construccion']  ?? null,
                'valor_catastral' => $this->aviso['predio']['valor_catastral']  ?? null,
            ]);

            $this->traslado->predio->audits()->latest()->first()->update(['tags' => 'Actualizó mediante aviso aclaratorio', 'tramite_id' => $this->traslado->tramite_aviso]);

        }

        $this->traslado->predio->movimientos()->create([
            'nombre' => $this->aviso['acto'],
            'fecha' => now()->toDateString(),
            'descripcion' => 'Se actualiza predio mediante aviso: ' . $this->aviso['año'] . '-' . $this->aviso['folio'] . '-' . $this->aviso['usuario'],
            'creado_por' => auth()->id()
        ]);

    }

    public function revisarProcentajes(){

        $pn_adquirientes = 0;

        $pn_transmitentes = 0;

        $pu_adquirientes = 0;

        $pu_transmitentes = 0;

        $pp_adquirientes = 0;

        $pp_transmitentes = 0;

        $pu = 0;

        $pp = 0;

        $pn = 0;

        foreach($this->aviso['predio']['adquirientes'] as $adquiriente){

            $pn_adquirientes = $pn_adquirientes + $adquiriente['porcentaje_nuda'];

            $pu_adquirientes = $pu_adquirientes + $adquiriente['porcentaje_usufructo'];

            $pp_adquirientes = $pp_adquirientes + $adquiriente['porcentaje_propiedad'];

        }

        foreach($this->aviso['predio']['transmitentes'] as $transmitente){

            $pn_transmitentes = $pn_transmitentes + $transmitente['porcentaje_nuda'];

            $pu_transmitentes = $pu_transmitentes + $transmitente['porcentaje_usufructo'];

            $pp_transmitentes = $pp_transmitentes + $transmitente['porcentaje_propiedad'];

        }

        foreach($this->transmitentes as $transmitente){

            $pn = $pn + $transmitente['porcentaje_nuda'];

            $pu = $pu + $transmitente['porcentaje_usufructo'];

            $pp = $pp + $transmitente['porcentaje_propiedad'];

        }

        $sumaPP = $pp_adquirientes + $pp;

        if($sumaPP == 0){

            $sumaPN = $pn_adquirientes + $pn;

            if(round($sumaPN, 2) > round($pn_transmitentes + $pp_transmitentes,2)){

                throw new GeneralException("La suma de los porcentajes de propiedad debe ser " . $pp_transmitentes . '%.');

            }

            $sumaPU = $pu_adquirientes + $pu;

            if(round($sumaPU, 2) != round($pu_transmitentes + $pp_transmitentes, 2)){

                throw new GeneralException("La suma de los porcentajes de usufructo debe ser " . $pu_transmitentes + $pp_transmitentes . '%.');

            }

        }else{

            if($sumaPP == 100){

                if(($pn_adquirientes + $pn) != 0){

                    throw new GeneralException("La suma de los porcentajes de nuda debe ser 0.");

                }

                if(($pu_adquirientes + $pu) != 0){

                    throw new GeneralException("La suma de los porcentajes de usufructo debe ser 0.");

                }


            }else{

                if($pn + $pp + $pn_adquirientes + $pp_adquirientes > ($pn_transmitentes + $pp_transmitentes) ){

                    throw new GeneralException("La suma de los porcentajes de nuda no es correcta.");

                }

                if($pu + $pp + $pu_adquirientes + $pp_adquirientes > ($pu_transmitentes + $pp_transmitentes)){

                    throw new GeneralException("La suma de los porcentajes de usufructo no es correcta.");

                }

            }

        }

    }

    public function revisarPagoIsai(){

        if($this->traslado->valor_isai > 0 && !$this->traslado->pago_isai){

            throw new GeneralException('No se tiene registro del pago de ISAI.');

        }

    }

    public function imprimirAviso(Traslado $traslado){

        try {

            $data = (new SistemaTramitesLineaService())->generarAvisoPdf($traslado->aviso_stl);

            $pdf = base64_decode($data['data']['pdf']);

            /* $this->js('window.open(\' '. $pdf . '\', \'_blank\');'); */

            return response()->streamDownload(
                fn () => print($pdf),
                'aviso.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf del aviso en consulta de predios por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function imprimirAvaluo(Traslado $traslado){

        try {

            $data = (new SistemaPeritosExternosService())->generarAvaluoPdf($traslado->avaluo_spe);

            $pdf = base64_decode($data['data']['pdf']);

            return response()->streamDownload(
                fn () => print($pdf),
                'avaluo.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al generar pdf del avalúo en consulta de predios por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            $this->dispatch('mostrarMensaje', ['error', 'Hubo un error.']);

        }

    }

    public function mount(){

        $this->traslado->predio->load('propietarios.persona');

        $this->rechazos = Constantes::RECHAZOS_AVISOS;

        try {

            $this->aviso = (new SistemaTramitesLineaService())->consultarAviso($this->traslado->aviso_stl);

            if($this->traslado->tipo != 'aclaratorio'){

                $this->avaluo = (new SistemaPeritosExternosService())->consultarAvaluo($this->traslado->avaluo_spe);

            }

            foreach ($this->aviso['predio']['transmitentes'] as $transmitente) {

                $this->transmitentes[] = [
                    'nombre' => $transmitente['persona']['nombre'] ?? null,
                    'ap_paterno' => $transmitente['persona']['ap_paterno'] ?? null,
                    'ap_materno' => $transmitente['persona']['ap_materno'] ?? null,
                    'razon_social' => $transmitente['persona']['razon_social'] ?? null,
                    'porcentaje_propiedad' => $transmitente['porcentaje_propiedad'],
                    'porcentaje_nuda' => $transmitente['porcentaje_nuda'],
                    'porcentaje_usufructo' => $transmitente['porcentaje_usufructo'],
                ];

            }

        } catch (GeneralException $ex) {

            abort(403, message:$ex->getMessage());

        } catch (\Throwable $th) {

            Log::error("Error al consultar sistemas externos en revisión de aviso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            abort(403, message:"Error al conectar con los sistemas externos");

        }

    }

    public function render()
    {
        return view('livewire.gestion-catastral.revision-traslados.revisar-traslado')->extends('layouts.admin');
    }
}
