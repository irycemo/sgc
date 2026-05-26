<?php

namespace App\Enums\Tramites;

enum AvaluoPara: int
{

    case VARIACION_VIVIENDA = 1;
    case VARIACION_OTRO = 2;
    case DESGLOSE_FRACCIONAMIENTOS = 3;
    case DESGLOSE_SUBDIVISIONES = 4;
    case DESGLOSE_OTRO = 5;
    case DESGLOSE_Y_CAMBIO_DE_REGIMEN = 10;
    case PREDIO_IGNORADO = 6;
    case ACTUALIZACION = 7;
    case FUSION = 8;
    case CAMBIO_REGIMEN = 9;
    /* CAMBIO DE MUNICIPIO */

    public function label(): string
    {

        return match($this){

            AvaluoPara::VARIACION_VIVIENDA => 'Variación catastral vivienda', /* T-Inspección */
            AvaluoPara::VARIACION_OTRO => 'Variación catastral otro tipo de inmueble',/* T-Inspección */
            AvaluoPara::DESGLOSE_FRACCIONAMIENTOS => 'Avalúo de desglose de fraccionamientos, condominios y conjuntos habitacionales',/* T-Inspección  T-Desglose*/
            AvaluoPara::DESGLOSE_OTRO => 'Avalúos de desglose de cualquier otro tipo de inmueble',/* T-Inspección T-Desglose*/
            AvaluoPara::DESGLOSE_SUBDIVISIONES => 'Avalúos de desglose de subdivisiones',/* T-Inspección T-Desglose*/
            AvaluoPara::DESGLOSE_Y_CAMBIO_DE_REGIMEN => 'Avalúo de desglose y cambio de régimen',/* T-Inspección T-Desglose*/
            AvaluoPara::PREDIO_IGNORADO => 'Avalúo para predio ignorado',/* T-Inspección T-Desglose*/
            AvaluoPara::ACTUALIZACION => 'Avalúo de actualización',/* T-Inspección */
            AvaluoPara::FUSION => 'Avalúo de fusión',/* T-Inspección */
            AvaluoPara::CAMBIO_REGIMEN => 'Avalúo de cambio de régimen',/* T-Inspección T-Desglose*/

        };

    }

}
