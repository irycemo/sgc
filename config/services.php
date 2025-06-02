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
        'AWS_FLAG' => env('AWS_FLAG', false),
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

];
