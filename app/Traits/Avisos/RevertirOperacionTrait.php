<?php

namespace App\Traits\Avisos;

use App\Exceptions\GeneralException;
use App\Models\Certificacion;
use App\Models\Colindancia;
use App\Models\Construccion;
use App\Models\ConstruccionesComun;
use App\Models\Persona;
use App\Models\Predio;
use App\Models\Propietario;
use App\Models\Terreno;
use App\Models\TerrenosComun;

trait RevertirOperacionTrait
{

    public function revertirOperacion(Predio $predio, Certificacion $certificacion):void
    {

        $cadena_original = json_decode($certificacion->cadena_original, true);

        $cadena_original = $cadena_original['predio'];

        $predio->update([
            'codigo_postal' => $cadena_original['codigo_postal'],
            'nombre_asentamiento' => $cadena_original['nombre_asentamiento'],
            'tipo_asentamiento' => $cadena_original['tipo_asentamiento'],
            'nombre_vialidad' => $cadena_original['nombre_vialidad'],
            'tipo_vialidad' => $cadena_original['tipo_vialidad'],
            'numero_exterior' => $cadena_original['numero_exterior'],
            'numero_exterior_2' => $cadena_original['numero_exterior_2'],
            'numero_interior' => $cadena_original['numero_interior'],
            'numero_adicional' => $cadena_original['numero_adicional'],
            'numero_adicional_2' => $cadena_original['numero_adicional_2'],
            'lote_fraccionador' => $cadena_original['lote_fraccionador'],
            'manzana_fraccionador' => $cadena_original['manzana_fraccionador'],
            'etapa_fraccionador' => $cadena_original['etapa_fraccionador'],
            'nombre_predio' => $cadena_original['nombre_predio'],
            'nombre_edificio' => $cadena_original['nombre_edificio'],
            'clave_edificio' => $cadena_original['clave_edificio'],
            'departamento_edificio' => $cadena_original['departamento_edificio'],
            'xutm' => $cadena_original['xutm'],
            'yutm' => $cadena_original['yutm'],
            'zutm' => $cadena_original['zutm'],
            'lon' => $cadena_original['lon'],
            'lat' => $cadena_original['lat'],
            'superficie_terreno' => $cadena_original['superficie_terreno'],
            'superficie_notarial' => $cadena_original['superficie_notarial'],
            'superficie_construccion' => $cadena_original['superficie_construccion'],
            'area_comun_terreno' => $cadena_original['area_comun_terreno'],
            'area_comun_construccion' => $cadena_original['area_comun_construccion'],
            'valor_total_terreno' => $cadena_original['valor_total_terreno'],
            'valor_total_construccion' => $cadena_original['valor_total_construccion'],
            'superficie_total_terreno' => $cadena_original['superficie_total_terreno'],
            'superficie_total_construccion' => $cadena_original['superficie_total_construccion'],
            'valor_catastral' => $cadena_original['valor_catastral'],
            'observaciones' => $cadena_original['observaciones'],
        ]);

        $propietarios = $cadena_original['propietarios'];

        $predio->propietarios()->delete();

        foreach ($propietarios as $propietario) {

            $this->registrarPropietario($propietario, $predio->id);

        }

        $colindancias = $cadena_original['colindancias'];

        $predio->colindancias()->delete();

        foreach ($colindancias as $colindancia) {

            $this->registrarColindancias($colindancia, $predio->id);

        }

        $terrenos = $cadena_original['terrenos'];

        $predio->terrenos()->delete();

        foreach ($terrenos as $terreno) {

            $this->registrarTerrenos($terreno, $predio->id);

        }

        $terrenosComun = $cadena_original['terrenosComun'];

        $predio->terrenosComun()->delete();

        foreach ($terrenosComun as $terrenoComun) {

            $this->registrarTerrenosComun($terrenoComun, $predio->id);

        }

        $construcciones = $cadena_original['construcciones'];

        $predio->construcciones()->delete();

        foreach ($construcciones as $construccion) {

            $this->registrarConstruccion($construccion, $predio->id);

        }

        $construccionesComun = $cadena_original['construccionesComun'];

        $predio->construccionesComun()->delete();

        foreach ($construccionesComun as $construccionComun) {

            $this->registrarConstruccionComun($construccionComun, $predio->id);

        }

    }

    private function registrarPropietario(array $propietario, int $predio_id):void
    {

        if(! isset($propietario['persona_id'])){

            $persona = Persona::where('nombre', $propietario['nombre'])
                                ->where('ap_paterno', $propietario['ap_paterno'])
                                ->where('ap_materno', $propietario['ap_materno'])
                                ->where('razon_social', $propietario['razon_social'])
                                ->first();

            if(! $persona){

                throw new GeneralException('No se encontro la persona al reveertir operación.');

            }

            $persona_id = $persona->id;

        }else{

            $persona_id = $propietario['persona_id'];

        }

        Propietario::create([
            'propietarioable_id' => $predio_id,
            'propietarioable_type' => 'App\Models\Predio',
            'persona_id' => $persona_id,
            'porcentaje_propiedad' => $propietario['porcentaje_propiedad'],
            'porcentaje_nuda' => $propietario['porcentaje_nuda'],
            'porcentaje_usufructo' => $propietario['porcentaje_usufructo'],
        ]);

    }

    private function registrarColindancias(array $colindancia, int $predio_id):void
    {

        Colindancia::create([
            'colindanciaable_id' => $predio_id,
            'colindanciaable_type' => 'App\Models\Predio',
            'viento' => $colindancia['viento'],
            'longitud' => $colindancia['longitud'],
            'descripcion' => $colindancia['descripcion'],
        ]);

    }

    private function registrarTerrenos(array $terreno, int $predio_id):void
    {

        Terreno::create([
            'terrenoable_id' => $predio_id,
            'terrenoable_type' => 'App\Models\Predio',
            'superficie' => $terreno['superficie'],
            'demerito' => $terreno['demerito'],
            'valor_demeritado' => $terreno['valor_demeritado'],
            'valor_unitario' => $terreno['valor_unitario'],
            'valor_terreno' => $terreno['valor_terreno'],
        ]);

    }

    private function registrarTerrenosComun(array $terrenoComun, int $predio_id):void
    {

        TerrenosComun::create([
            'terrenos_comunsable_id' => $predio_id,
            'terrenos_comunsable_type' => 'App\Models\Predio',
            'area_terreno_comun' => $terrenoComun['area_terreno_comun'],
            'indiviso_terreno' => $terrenoComun['indiviso_terreno'],
            'valor_unitario' => $terrenoComun['valor_unitario'],
            'superficie_proporcional' => $terrenoComun['superficie_proporcional'],
            'valor_terreno_comun' => $terrenoComun['valor_terreno_comun'],
        ]);

    }

    private function registrarConstruccion(array $construccion, int $predio_id):void
    {

        Construccion::create([
            'construccionable_id' => $predio_id,
            'construccionable_type' => 'App\Models\Predio',
            'referencia' => $construccion['referencia'],
            'superficie' => $construccion['superficie'],
            'valor_unitario' => $construccion['valor_unitario'],
            'valor_construccion' => $construccion['valor_construccion'],
            'tipo' => $construccion['tipo'] ?? 0,
            'uso' => $construccion['uso'] ?? 0,
            'estado' => $construccion['estado'] ?? 0,
            'calidad' => $construccion['calidad'] ?? 0,
            'niveles' => $construccion['niveles'] ?? 0,
        ]);

    }

    private function registrarConstruccionComun(array $construccionComun, int $predio_id):void
    {

        ConstruccionesComun::create([
            'construcciones_comunsable_id' => $predio_id,
            'construcciones_comunsable_type' => 'App\Models\Predio',
            'area_comun_construccion' => $construccionComun['area_comun_construccion'],
            'superficie_proporcional' => $construccionComun['superficie_proporcional'],
            'indiviso_construccion' => $construccionComun['indiviso_construccion'],
            'valor_clasificacion_construccion' => $construccionComun['valor_clasificacion_construccion'],
            'valor_construccion_comun' => $construccionComun['valor_construccion_comun'],
            'tipo' => $construccionComun['tipo'] ?? 0,
            'uso' => $construccionComun['uso'] ?? 0,
            'estado' => $construccionComun['estado'] ?? 0,
            'calidad' => $construccionComun['calidad'] ?? 0,
        ]);

    }

}
