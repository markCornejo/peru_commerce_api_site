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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // tipo de imagen, path y tamaños
    'image' => [
        'url' => 'public/file/images', // path , esto está linkiado en public desde la carpeta storage
        'size' => ['80', '160', '300', '450', '700', '900', '1200'], // size, Example, In the end the image will be located in: file/logo/80/miimagen.jpg
        'oritation' => 'h', // mantener proporcion h => horizontal, v => vertical, o => ambos (cuadratica)
        'image_url' => env('URL_IMAGE') // ubicación de la imagen para renderizar.
    ]

];
