<?php

namespace App\Traits\Certificaciones;

use App\Models\Predio;

trait PredioTrait
{

    public function predio(Predio $predio):object
    {

        $terrenos = collect();

        $predio->load('terrenos');

        foreach ($predio->terrenos as $terreno) {

            $item = (object)[];

            $item->superficie = $terreno->superficie;
            $item->demerito = $terreno->demerito;
            $item->valor_demeritado = $terreno->valor_demeritado;
            $item->valor_unitario = $terreno->valor_unitario;
            $item->valor_terreno = $terreno->valor_terreno;

            $terrenos->push($item);

        }

        $terrenosComun = collect();

        $predio->load('terrenosComun');

        foreach ($predio->terrenosComun as $terrenoComun) {

            $item = (object)[];

            $item->area_terreno_comun = $terrenoComun->area_terreno_comun;
            $item->indiviso_terreno = $terrenoComun->indiviso_terreno;
            $item->valor_unitario = $terrenoComun->valor_unitario;
            $item->superficie_proporcional = $terrenoComun->superficie_proporcional;
            $item->valor_terreno_comun = $terrenoComun->valor_terreno_comun;

            $terrenosComun->push($item);

        }

        $construcciones = collect();

        $predio->load('construcciones');

        foreach ($predio->construcciones as $construccion) {

            $item = (object)[];

            $item->referencia = $construccion->referencia;
            $item->superficie = $construccion->superficie;
            $item->valor_unitario = $construccion->valor_unitario;
            $item->valor_construccion = $construccion->valor_construccion;

            $construcciones->push($item);

        }

        $construccionesComun = collect();

        $predio->load('construccionesComun');

        foreach ($predio->construccionesComun as $construccionComun) {

            $item = (object)[];

            $item->area_comun_construccion = $construccionComun->area_comun_construccion;
            $item->superficie_proporcional = $construccionComun->superficie_proporcional;
            $item->indiviso_construccion = $construccionComun->indiviso_construccion;
            $item->valor_clasificacion_construccion = $construccionComun->valor_clasificacion_construccion;
            $item->valor_construccion_comun = $construccionComun->valor_construccion_comun;

            $construccionesComun->push($item);

        }

        $colindancias = collect();

        $predio->load('colindancias');

        foreach ($predio->colindancias as $colindancia) {

            $item = (object)[];

            $item->viento = $colindancia->viento;
            $item->longitud = $colindancia->longitud;
            $item->descripcion = $colindancia->descripcion;

            $colindancias->push($item);

        }

        $propietarios = collect();

        $predio->load('propietarios.persona');

        foreach ($predio->propietarios as $propietario) {

            $item = (object)[];

            $item->nombre = $propietario->persona->nombre;
            $item->ap_paterno = $propietario->persona->ap_paterno;
            $item->ap_materno = $propietario->persona->ap_materno;
            $item->multiple_nombre = $propietario->persona->multiple_nombre;
            $item->razon_social = $propietario->persona->razon_social;
            $item->porcentaje_propiedad = $propietario->porcentaje_propiedad;
            $item->porcentaje_nuda = $propietario->porcentaje_nuda;
            $item->porcentaje_usufructo = $propietario->porcentaje_usufructo;

            $propietarios->push($item);

        }

        $object = (object)[];

        $object->cuenta_predial = $predio->cuentaPredial();
        $object->clave_catastral = $predio->claveCatastral();
        $object->id = $predio->id;
        $object->status = $predio->status;
        $object->curt = $predio->curt;
        $object->superficie_construccion = $predio->superficie_construccion;
        $object->area_comun_terreno = $predio->area_comun_terreno;
        $object->area_comun_construccion = $predio->area_comun_construccion;
        $object->valor_terreno_comun = $predio->valor_terreno_comun;
        $object->valor_construccion_comun = $predio->valor_construccion_comun;
        $object->valor_total_terreno = $predio->valor_total_terreno;
        $object->valor_total_construccion = $predio->valor_total_construccion;
        $object->valor_catastral = $predio->valor_catastral;
        $object->tipo_vialidad = $predio->tipo_vialidad;
        $object->tipo_asentamiento = $predio->tipo_asentamiento;
        $object->nombre_vialidad = $predio->nombre_vialidad;
        $object->nombre_asentamiento = $predio->nombre_asentamiento;
        $object->numero_exterior = $predio->numero_exterior;
        $object->numero_exterior_2 = $predio->numero_exterior_2;
        $object->numero_adicional = $predio->numero_adicional;
        $object->numero_adicional_2 = $predio->numero_adicional_2;
        $object->numero_interior = $predio->numero_interior;
        $object->manzana = $predio->manzana;
        $object->codigo_postal = $predio->codigo_postal;
        $object->lote_fraccionador = $predio->lote_fraccionador;
        $object->manzana_fraccionador = $predio->manzana_fraccionador;
        $object->etapa_fraccionador = $predio->etapa_fraccionador;
        $object->nombre_edificio = $predio->nombre_edificio;
        $object->clave_edificio = $predio->clave_edificio;
        $object->departamento_edificio = $predio->departamento_edificio;
        $object->nombre_predio = $predio->nombre_predio;
        $object->estado = $predio->estado;
        $object->municipio = $predio->municipio;
        $object->localidad = $predio->localidad;
        $object->xutm = $predio->xutm;
        $object->yutm = $predio->yutm;
        $object->zutm = $predio->zutm;
        $object->lon = $predio->lon;
        $object->lat = $predio->lat;
        $object->observaciones = $predio->observaciones;
        $object->colindancias = $colindancias;
        $object->propietarios = $propietarios;
        $object->terrenos = $terrenos;
        $object->terrenosComun = $terrenosComun;
        $object->construcciones = $construcciones;
        $object->construccionesComun = $construccionesComun;
        $object->ubicacion_en_manzana  = $predio->ubicacion_en_manzana;
        $object->superficie_terreno = $predio->superficie_terreno;
        $object->superficie_judicial = $predio->superficie_judicial;
        $object->superficie_notarial = $predio->superficie_notarial;

        return $object;

    }

}
