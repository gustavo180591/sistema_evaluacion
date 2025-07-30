<?php
// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inicia sesión
session_start();

// Carga la conexión a la base de datos
require_once __DIR__ . '/../config/database.php';

// Carga el enrutador principal
require_once __DIR__ . '/../app/core/Router.php';

// Autocarga de clases si usás PSR-4 o Composer (opcional)
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
        __DIR__ . '/../app/core/' . $class . '.php',
        __DIR__ . '/../app/utils/' . $class . '.php'
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Procesar la solicitud
$router = new Router();
$router->handleRequest();
