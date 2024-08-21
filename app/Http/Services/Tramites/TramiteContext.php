<?php

namespace App\Http\Services\Tramites;


use App\Models\Tramite;
use App\Http\Services\Tramites\Strategies\Reset;
use App\Http\Services\Tramites\Strategies\Simple;
use App\Http\Services\Tramites\Strategies\Completo;
use App\Http\Services\Tramites\Strategies\Certificados;
use App\Http\Services\Tramites\Strategies\CopiasDocumentos;
use App\Http\Services\Tramites\Strategies\PrediosIgnorados;
use App\Http\Services\Tramites\Strategies\InspeccionesOculares;
use App\Http\Services\Tramites\Strategies\LevantamientosTopograficos;

class TramiteContext
{

    private TramitesStrategyInterface $strategy;

    public function __construct(string $categoria, Tramite $tramite)
    {

        $this->strategy = match($this->filtrarCategoria($categoria)){

            'Certificaciones catastrales' => new Certificados($tramite),
            'Predio Ignorado' => new PrediosIgnorados($tramite),
            'Inspecciones Oculares' => new InspeccionesOculares($tramite),
            'Simple' => new Simple($tramite),
            'Completo' => new Completo($tramite),
            'Expedición de duplicados de documentos catastrales' => new CopiasDocumentos($tramite),
            'Levantamientos topográficos' => new LevantamientosTopograficos($tramite),
            default => new Reset($tramite),

        };

    }

    public function cambiarFlags():array
    {
        return $this->strategy->cambiarFlags();
    }

    public function crearTramite($predios):Tramite
    {
        return $this->strategy->crearTramite($predios);
    }

    public function actualizarTramite($predios):Tramite
    {
        return $this->strategy->actualizarTramite($predios);
    }

    public function validaciones():array
    {
        return $this->strategy->validaciones();
    }

    public function filtrarCategoria( String $categoria):string
    {

        return match($categoria){
            'Autorización e inscripción de peritos valuadores de bienes inmuebles' => 'Simple',
            'Desglose de predios y valuación' => 'Simple',
            'Inscripción Catastral para Registro de Predios por Regularizar' => 'Simple',
            'Georreferenciación de croquis administrativos del catastro' => 'Completo',
            'Ubicación cartográfica por cambio de localidad' => 'Completo',
            'Ubicación cartográfica para la asignación correcta de clave catastral'  => 'Completo',
            'Levantamientos aerofotogramétricos y otros servicios de alta precisión' => 'Completo',
            'Aviso Aclaratorio' => 'Completo',
            'Revisión de Aviso y/o cancelación' => 'Completo',
            'Cédula de actualización' => 'Completo',
            'Modificación de datos administrativos catastrales'  => 'Completo',
            'Ubicación de predios en cartografía'  => 'Completo',
            'Información a propietarios o poseedores de predios registrados'   => 'Completo',
            'Solicitud de Variación Catastral'  => 'Completo',
            'Reestructuración de cuentas catastrales'  => 'Completo',
            'Determinación de la ubicación física de predios'=> 'Completo',
            'Expedición de planos catastrales'  => 'Simple',
            'Levantamiento Topográfico con curvas de nivel' => 'Completo',
            default => $categoria
        };

    }

}
