<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API CORS (Cross-Origin Resource Sharing) Settings
    |--------------------------------------------------------------------------
    |
    | Here you can configure the settings for Cross-Origin Resource Sharing
    | or "CORS". This determines which cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [], // <-- Vamos a cambiar esta línea

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];