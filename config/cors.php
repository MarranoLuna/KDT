<?php

return [


    'paths' => ['api/*', 'login', 'logout', 'sanctum/csrf-cookie'], // Es bueno agregar login/logout aquí

    'allowed_methods' => ['*'],

    // ESPECIFICAMOS DE DONDE PUEDE RECIBIR REQUESTS
    'allowed_origins' => [
        'http://localhost',
        'http://localhost:8100',
        'http://localhost:8101', //----------->ionic web
        'http://10.0.2.2', //----------> para probar en android studio
        'http://10.0.2.2:8100',//----------> para probar en android studio
        'capacitor://localhost'
    ],


    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
    ],

    'exposed_headers' => [],

    'max_age' => 0,

    // permite credenciales (cookies de sesión)
    'supports_credentials' => true,

];