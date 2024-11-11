<?php
return [

'paths' => ['api/*'],  // Rutas de la API que tienen CORS habilitado

'allowed_methods' => ['*'],  // Permite todos los métodos HTTP (GET, POST, PUT, DELETE)

'allowed_origins' => ['http://localhost:8000'],  // Permite todos los orígenes, ajusta si es necesario para mayor seguridad

'allowed_headers' => ['*'],  // Permite todos los encabezados

'exposed_headers' => [],  // Agrega los encabezados que quieres exponer

'max_age' => 0,  // El tiempo en segundos que la respuesta preflight puede ser almacenada en caché por el navegador

'supports_credentials' => false,  // Si es necesario permitir credenciales (cookies, autenticación)
];

