<?php

namespace App\Http\Services\Certificaciones;

use App\Models\User;
use App\Models\Predio;
use App\Models\Oficina;
use App\Models\Tramite;
use App\Models\Certificacion;
use PhpCfdi\Credentials\Credential;
use Illuminate\Support\Facades\Storage;

class CertificacionesService{

    public $predio;
    public $tramite;
    public $cadena;
    public $tipo_certificado;
    public $director;
    public $entidad;

    public function __construct(Predio $predio, Tramite $tramite, string $entidad)
    {

        $this->predio = $predio;
        $this->tramite = $tramite;
        $this->tipo_certificado = mb_strtoupper($this->tramite->servicio->nombre, 'utf-8');
        $this->entidad = $entidad;

        $this->predio->load('propietarios.persona');

        $this->director = User::with('efirma')->where('status', 'activo')
                                    ->whereHas('roles', function($q){
                                        $q->where('name', 'Director');
                                    })
                                    ->first();

    }

    public function generar(){

        $this->cadena = 'cuenta_predial: ' . $this->predio->cuentaPredial();

        $this->cadena = $this->cadena . '|' . 'clave_catastral: ' . $this->predio->claveCatastral();

        $this->cadena = $this->cadena . '|' . 'tramite: ' . $this->tramite->año . '-' . $this->tramite->folio . '-'. $this->tramite->usuario . '|' . 'recibo: ' . $this->tramite->folio_pago;

        $this->cadena = $this->cadena . '|' . 'solicitante: ' . $this->tramite->nombre_solicitante;

        if($this->predio->tipo_asentamiento) $this->cadena = $this->cadena . '|' . 'tipo_asentamiento: ' . $this->predio->tipo_asentamiento;
        if($this->predio->nombre_asentamiento) $this->cadena = $this->cadena . '|' . 'nombre_asentamiento: ' . $this->predio->nombre_asentamiento;
        if($this->predio->tipo_vialidad) $this->cadena = $this->cadena . '|' . 'tipo_vialidad: ' . $this->predio->tipo_vialidad;
        if($this->predio->nombre_vialidad) $this->cadena = $this->cadena . '|' . 'nombre_vialidad: ' . $this->predio->nombre_vialidad;
        if($this->predio->numero_interior) $this->cadena = $this->cadena . '|' . 'numero_interior: ' . $this->predio->numero_interior;
        if($this->predio->numero_exterior) $this->cadena = $this->cadena . '|' . 'numero_exterior: ' . $this->predio->numero_exterior;
        if($this->predio->numero_exterior_2) $this->cadena = $this->cadena . '|' . 'numero_exterior_2: ' . $this->predio->numero_exterior_2;
        if($this->predio->numero_adicional) $this->cadena = $this->cadena . '|' . 'numero_adicional: ' . $this->predio->numero_adicional;
        if($this->predio->numero_adicional_2) $this->cadena = $this->cadena . '|' . 'numero_adicional_2: ' . $this->predio->numero_adicional_2;
        if($this->predio->codigo_postal) $this->cadena = $this->cadena . '|' . 'codigo_postal: ' . $this->predio->codigo_postal;
        if($this->predio->nombre_edificio) $this->cadena = $this->cadena . '|' . 'nombre_edificio: ' . $this->predio->nombre_edificio;
        if($this->predio->clave_edificio) $this->cadena = $this->cadena . '|' . 'clave_edificio: ' . $this->predio->clave_edificio;
        if($this->predio->departamento_edificio) $this->cadena = $this->cadena . '|' . 'departamento_edificio: ' . $this->predio->departamento_edificio;
        if($this->predio->lote_fraccionador) $this->cadena = $this->cadena . '|' . 'lote_fraccionador: ' . $this->predio->lote_fraccionador;
        if($this->predio->manzana_fraccionador) $this->cadena = $this->cadena . '|' . 'manzana_fraccionador: ' . $this->predio->manzana_fraccionador;
        if($this->predio->etapa_fraccionador) $this->cadena = $this->cadena . '|' . 'etapa_fraccionador: ' . $this->predio->etapa_fraccionador;
        if($this->predio->ubicacion_en_manzana) $this->cadena = $this->cadena . '|' . 'ubicacion_en_manzana: ' . $this->predio->ubicacion_en_manzana;
        if($this->predio->nombre_predio) $this->cadena = $this->cadena . '|' . 'nombre_predio: ' . $this->predio->nombre_predio;
        if($this->predio->xutm) $this->cadena = $this->cadena . '|' . 'xutm: ' . $this->predio->xutm;
        if($this->predio->yutm) $this->cadena = $this->cadena . '|' . 'yutm: ' . $this->predio->yutm;
        if($this->predio->zutm) $this->cadena = $this->cadena . '|' . 'zutm: ' . $this->predio->zutm;
        if($this->predio->lat) $this->cadena = $this->cadena . '|' . 'lat: ' . $this->predio->lat;
        if($this->predio->lon) $this->cadena = $this->cadena . '|' . 'lon: ' . $this->predio->lon;
        if($this->predio->superficie_terreno > 0) $this->cadena = $this->cadena . '|' . 'superficie_terreno: ' . $this->predio->superficie_terreno;
        if($this->predio->superficie_notarial > 0) $this->cadena = $this->cadena . '|' . 'superficie_notarial: ' . $this->predio->superficie_notarial;
        if($this->predio->superficie_judicial > 0) $this->cadena = $this->cadena . '|' . 'superficie_judicial: ' . $this->predio->superficie_judicial;
        if($this->predio->superficie_construccion > 0) $this->cadena = $this->cadena . '|' . 'superficie_construccion: ' . $this->predio->superficie_construccion;
        if($this->predio->area_comun_terreno > 0) $this->cadena = $this->cadena . '|' . 'area_comun_terreno: ' . $this->predio->area_comun_terreno;
        if($this->predio->area_comun_construccion > 0) $this->cadena = $this->cadena . '|' . 'area_comun_construccion: ' . $this->predio->area_comun_construccion;
        if($this->predio->valor_catastral) $this->cadena = $this->cadena . '|' . 'valor_catastral: ' . $this->predio->valor_catastral;

        foreach ($this->predio->propietarios as $propietarios) {

            $this->cadena = $this->cadena . '|' . 'Nombre=' . $propietarios->persona->nombre . ' ' . $propietarios->persona->ap_paterno . ' ' . $propietarios->persona->ap_materno . ' ' . $propietarios->persona->razon_social . '%Tipo=' . $propietarios->persona->tipo . '%Porcentaje propiedad=' . $propietarios->porcentaje . '%Porcentaje nuda=' . $propietarios->porcentaje_nuda . '%Porcentaje usufructo=' . $propietarios->porcentaje_usufructo;

        }

        if($this->tramite->servicio_id == 6){

            foreach ($this->predio->colindancias as $colindancia) {

                $this->cadena = $this->cadena . '|' . 'Viento=' . $colindancia->viento . '%Longitud=' . $colindancia->longitud . '%Descripcion=' . $colindancia->descripcion;

            }

        }

        $fechaImpresion = now()->format('d-m-Y H:i:s');

        $this->cadena = $this->cadena . '|' . 'impreso_en: ' . $fechaImpresion;

        $this->cadena = $this->cadena . '|' . 'impreso_por: ' . $this->entidad;

        $fielDirector = Credential::openFiles(Storage::disk('efirma')->path($this->director->efirma->cer), Storage::disk('efirma')->path($this->director->efirma->key), $this->director->efirma->contraseña);

        $oficina = Oficina::where('oficina', 101)->first();

        $this->cadena = $this->cadena . '|' . 'oficina: ' . $oficina->nombre;

        $this->cadena = $this->cadena . '|' . 'suscrito: ' . $this->director->nombreCompleto();

        $this->cadena = $this->cadena . '|' . 'cargo: Director de catastro';

        $firmaDirector = $fielDirector->sign($this->cadena);

        $certificacion = Certificacion::create([
            'año' => now()->format('Y'),
            'folio' => (Certificacion::where('año', now()->format('Y'))->where('documento', $this->tipo_certificado)->max('folio') ?? 0) + 1,
            'documento' => $this->tipo_certificado,
            'cadena_originial' => $this->cadena,
            'cadena_encriptada' => base64_encode($firmaDirector),
            'estado' => 'activo',
            'oficina_id' => $oficina->id,
            'tramite_id' => $this->tramite->id,
            'predio_id' => $this->predio->id,
            'creado_por' => auth()->id(),
            'actualizado_por' => auth()->id(),
        ]);

        return $certificacion;

    }

}
