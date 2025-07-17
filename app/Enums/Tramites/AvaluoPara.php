<?php

namespace App\Enums\Tramites;

enum AvaluoPara: int
{

    case VARIACION_VIVIENDA = 1;
    case VARIACION_OTRO = 2;
    case DESGLOSE_FRACCIONAMIENTOS = 3;
    case DESGLOSE_SUBDIVISIONES = 4;
    case DESGLOSE_OTRO = 5;
    case PREDIO_IGNORADO = 6;
    case ACTUALIZACION = 7;
    case FUSION = 8;
    case CAMBIO_REGIMEN = 9;
    case ACTUALIZACION_RESTO = 10;

    public function label(): string
    {

        return match($this){

            AvaluoPara::VARIACION_VIVIENDA => 'Variación catastral vivienda', /* T-Inscección */
            AvaluoPara::VARIACION_OTRO => 'Variación catastral otro tipo de inmueble',/* T-Inscección */
            AvaluoPara::DESGLOSE_FRACCIONAMIENTOS => 'Avalúo de desglose de fraccionamientos, condominios y conjuntos habitacionales',/* T-Inscección  T-Desglose*/
            AvaluoPara::DESGLOSE_OTRO => 'Avalúos de desglose de cualquier otro tipo de inmueble',/* T-Inscección T-Desglose*/
            AvaluoPara::DESGLOSE_SUBDIVISIONES => 'Avalúos de desglose de subdivisiones',/* T-Inscección T-Desglose*/
            AvaluoPara::PREDIO_IGNORADO => 'Avalúo para predio ignorado',/* T-Inscección T-Desglose*/
            AvaluoPara::ACTUALIZACION => 'Avalúo de actualización',/* T-Inscección */
            AvaluoPara::ACTUALIZACION_RESTO => 'Avalúo de actualización (resto)',/* T-Inscección */
            AvaluoPara::FUSION => 'Avalúo de fusión',/* T-Inscección */
            AvaluoPara::CAMBIO_REGIMEN => 'Avalúo de cambio de régimen'/* T-Inscección T-Desglose*/

        };

    }

}
