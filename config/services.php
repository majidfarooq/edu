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
    'google' => [
        'client_id' => '415144701981-urfq6kq74jfbke9l73tl402hu7g8158g.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://cloud.ferozitech.com/edu/get_social_credentials_google'],
    'facebook' => [
        'client_id' => '3677666169130691',
        'client_secret' => 'af2cb3263df3057d40a12e0abc8c8e97',
        'redirect' => 'https://cloud.ferozitech.com/edu/get_social_credentials',
    ],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
