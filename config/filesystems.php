<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

        'certificaciones' => [
            'driver' => 'local',
            'root' => storage_path('app/certificaciones'),
            'url' => env('APP_URL').'/certificaciones',
            'visibility' => 'public',
            'throw' => false,
        ],

        'avaluos' => [
            'driver' => 'local',
            'root' => storage_path('app/avaluos'),
            'url' => env('APP_URL').'/avaluos',
            'visibility' => 'public',
            'throw' => false,
        ],

        'efirmas' => [
            'driver' => 'local',
            'root' => storage_path('app/efirmas'),
            'url' => env('APP_URL').'/efirmas',
            'visibility' => 'public',
            'throw' => false,
        ],

        'variacionescatastrales' => [
            'driver' => 'local',
            'root' => storage_path('app/variacionescatastrales'),
            'url' => env('APP_URL').'/variacionescatastrales',
            'visibility' => 'public',
            'throw' => false,
        ],

        'prediosignorados' => [
            'driver' => 'local',
            'root' => storage_path('app/prediosignorados'),
            'url' => env('APP_URL').'/prediosignorados',
            'visibility' => 'public',
            'throw' => false,
        ],

        'preguntas' => [
            'driver' => 'local',
            'root' => storage_path('app/preguntas'),
            'url' => env('APP_URL').'/preguntas',
            'visibility' => 'public',
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('avaluos') => storage_path('app/avaluos'),
        public_path('efirmas') => storage_path('app/efirmas'),
        public_path('variacionescatastrales') => storage_path('app/variacionescatastrales'),
        public_path('prediosignorados') => storage_path('app/prediosignorados'),
        public_path('certificaciones') => storage_path('app/certificaciones'),
        public_path('preguntas') => storage_path('app/preguntas'),
    ],

];
