<?php

namespace App\Enums\Certificaciones;

enum CertificacionesEnum:int
{

    case NOTIFICACION_VALOR_CATASTRAL = 1;
    case CERTIFICADO_CATASTRAL = 2;
    case CERTIFICADO_HISTORIA = 3;
    case CERTIFICADO_NEGATIVO = 4;
    case CERTIFICADO_REGISTRO = 5;
    case CEDULA_CATASTRAL = 6;

    public function label(): string
    {

        return match($this){

            CertificacionesEnum::NOTIFICACION_VALOR_CATASTRAL => 'Notificación de valor catastral',
            CertificacionesEnum::CERTIFICADO_CATASTRAL => 'Certificado catastral',
            CertificacionesEnum::CERTIFICADO_HISTORIA => 'Certificado de historia',
            CertificacionesEnum::CERTIFICADO_NEGATIVO => 'Certificado negativo de registro',
            CertificacionesEnum::CERTIFICADO_REGISTRO => 'Certificado de registro',
            CertificacionesEnum::CEDULA_CATASTRAL => 'Cédula catastral',

        };

    }

}
