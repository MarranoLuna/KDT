<?php

return [
   

    'paths' => ['api/*', 'login', 'logout', 'sanctum/csrf-cookie'], // Es bueno agregar login/logout aquí

    'allowed_methods' => ['*'],

    // especifica el origen de  app de Ionic
    'allowed_origins' => ['http://localhost:8100'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // permite credenciales (cookies de sesión)
    'supports_credentials' => true,

];