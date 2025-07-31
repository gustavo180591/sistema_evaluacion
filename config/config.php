<?php

// Nombre del sistema
define('APP_NAME', 'Sistema de Captación');

// Ruta base (útil para enlaces relativos si es necesario)
// En desarrollo: http://localhost:1000/
// En producción: cambiar a la URL real del servidor
define('BASE_URL', 'http://localhost:1000/');

// Carpeta para uploads
define('UPLOAD_PATH', __DIR__ . '/../storage/uploads/');

// Zona horaria por defecto
date_default_timezone_set('America/Argentina/Buenos_Aires');