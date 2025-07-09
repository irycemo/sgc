<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'flag' => env('AWS_FLAG', false),
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'sap' => [
        'SAP_USUARIO_API' => env('SAP_USUARIO_API'),
        'SAP_CONTRASENA_API' => env('SAP_CONTRASENA_API'),
        'SAP_GENERAR_LINEA_DE_CAPTURA_URL' => env('SAP_GENERAR_LINEA_DE_CAPTURA_URL'),
        'SAP_VALIDAR_LINEA_DE_CAPTURA_URL' => env('SAP_VALIDAR_LINEA_DE_CAPTURA_URL')
    ],

    'sistema_tramites_en_linea' => [
        'token' => env('SISTEMA_TRAMITES_EN_LINEA_TOKEN'),
        'consultar_aviso' => env('SISTEMA_TRAMITES_EN_LINEA_CONSULTAR_AVISO'),
        'rechazar_aviso' => env('SISTEMA_TRAMITES_EN_LINEA_RECHAZAR_AVISO'),
        'autorizar_aviso' => env('SISTEMA_TRAMITES_EN_LINEA_AUTORIZAR_AVISO'),
        'operar_aviso' => env('SISTEMA_TRAMITES_EN_LINEA_OPERAR_AVISO'),
        'generar_aviso_pdf' => env('SISTEMA_TRAMITES_EN_LINEA_GENERAR_AVISO_PDF'),
    ],

    'sistema_peritos_externos' => [
        'token' => env('SISTEMA_PERITOS_EXTERNOS_TOKEN'),
        'consultar_avaluo' => env('SISTEMA_PERITOS_EXTERNOS_CONSULTAR_AVALUO'),
        'operar_avaluo' => env('SISTEMA_PERITOS_EXTERNOS_OPERAR_AVALUO'),
        'generar_avaluo_pdf' => env('SISTEMA_PERITOS_EXTERNOS_GENERAR_AVALUO_PDF'),
    ],

];
