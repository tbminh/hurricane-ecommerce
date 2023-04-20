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

    // 'facebook' => [
    //     'client_id' => '4786925174735123',
    //     'client_secret' => '7c439c6fee77edf91e8f1e6f29ffb56c',
    //     'redirect' => 'http://localhost/hurricane.com.vn/fb/callback',
    // ],

    'facebook' => [
        'client_id' => '4786925174735123',
        'client_secret' => '7c439c6fee77edf91e8f1e6f29ffb56c',
        'redirect' => 'http://localhost/hurricane-ecommerce/fb/callback',
    ],

    'google' => [
        'client_id' => '683253586577-ki41lgcdkc580ui7chskjv1l312okdrr.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost/hurricane-ecommerce/gg/callback',
    ],
];
