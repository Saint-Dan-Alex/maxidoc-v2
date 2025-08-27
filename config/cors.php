<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'courriers/*',
        'regidoc/courriers/*'
    ],

    'allowed_methods' => [
        'POST',
        'GET',
        'OPTIONS',
        'PUT',
        'PATCH',
        'DELETE',
        'HEAD'
    ],

    'allowed_origins' => [
        'http://localhost',
        'http://localhost:8000',
        'http://127.0.0.1',
        'http://127.0.0.1:8000',
        'http://localhost:3000',
        env('APP_URL', 'http://localhost')
    ],

    'allowed_origins_patterns' => [
        '/^https?:\/\/localhost(:[0-9]+)?$/',
        '/^https?:\/\/127\.0\.0\.1(:[0-9]+)?$/',
    ],

    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'X-CSRF-TOKEN',
        'X-XSRF-TOKEN',
        'Authorization',
        'Accept',
        'X-Debug-Token',
        'X-Debug'
    ],

    'exposed_headers' => [
        'Authorization',
        'X-CSRF-TOKEN',
        'X-XSRF-TOKEN',
        'X-Debug-Token',
        'X-Debug-Token-Link'
    ],

    'max_age' => 60 * 60 * 24, // 24 heures

    'supports_credentials' => true,

];
