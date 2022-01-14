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



    'facebook' => [
        'client_id' => '133656512001284',
        'client_secret' => '155c851adc4c68eb8918b4e124ee1cb3',
        'redirect' => 'https://localhost:8000/callback/facebook',
    ],

    'twitter' => [
//        'client_id' => '251835483325387',
//        'client_secret' => '49771aeef7323ed5be878a0247abf036',
        'redirect' => 'https://localhost:8000/callback/twitter',
    ],

    'google' => [
        'client_id' => '451791936130-khc953tl4j61l3i9vqis8smibmt7995k.apps.googleusercontent.com',
        'client_secret' => '7adXf2zDjWQrLDOfSYebQuer',
        'redirect' => 'https://localhost:8000/callback/google',
    ],

    'linkedin' => [
        'client_id' => '86rqah4d605u9v',
        'client_secret' => 'zO7f5amtPhBiIKmF',
        'redirect' => 'https://localhost:8000/callback/linkedin',
        //'redirect' => 'https://www.mostaql.com/callback/linkedin/',
    ],

];
