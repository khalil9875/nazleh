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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
      'visa' => [
        'api_key' => env('VISA_API_KEY'),
        'api_secret' => env('VISA_API_SECRET'),
        'merchant_id' => env('VISA_MERCHANT_ID'),
    ],
    
    'apple_pay' => [
        'merchant_id' => env('APPLE_PAY_MERCHANT_ID'),
        'certificate_path' => env('APPLE_PAY_CERTIFICATE_PATH'),
    ],
    
    'mada' => [
        'api_url' => env('MADA_API_URL'),
        'terminal_id' => env('MADA_TERMINAL_ID'),
    ],

];
