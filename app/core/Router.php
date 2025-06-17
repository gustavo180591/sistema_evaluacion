<?php

class Router
{
    public function handleRequest()
    {
        $controllerName = $_GET['controller'] ?? 'Auth';
        $action = $_GET['action'] ?? 'login';

        $controllerClass = $controllerName . 'Controller';
        $controllerFile = __DIR__ . '/../controllers/' . $controllerClass . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                } else {
                    echo "Acción '$action' no encontrada en el controlador '$controllerClass'.";
                }
            } else {
                echo "Clase de controlador '$controllerClass' no encontrada.";
            }
        } else {
            echo "Archivo de controlador '$controllerFile' no encontrado.";
        }
    }
}