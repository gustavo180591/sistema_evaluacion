<?php

class Router
{
    public function handleRequest()
    {
        // Si no hay parámetros en la URL, verificar sesión
        if (empty($_GET['controller']) && empty($_GET['action'])) {
            $this->handleDefaultRoute();
            return;
        }

        $controllerName = $_GET['controller'] ?? 'Auth';
        $action = $_GET['action'] ?? $this->getDefaultAction($controllerName);

        $controllerClass = $controllerName . 'Controller';
        $controllerFile = __DIR__ . '/../controllers/' . $controllerClass . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            if (class_exists($controllerClass)) {
                // Pass database connection to controller if it accepts it in constructor
                global $pdo; // Assuming $pdo is the database connection from database.php
                $controller = new $controllerClass($pdo);
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

    private function getDefaultAction($controllerName)
    {
        // Definir acciones por defecto según el controlador
        switch ($controllerName) {
            case 'Dashboard':
                return 'index';
            case 'Auth':
                return 'login';
            case 'Atleta':
                return 'listado';
            case 'Test':
                return 'asignar';
            case 'Admin':
                return 'usuarios';
            case 'Evaluador':
                return 'listado';
            default:
                return 'index';
        }
    }

    private function handleDefaultRoute()
    {
        // Verificar si hay sesión activa
        if (isset($_SESSION['usuario_id']) && isset($_SESSION['rol'])) {
            // Usuario ya logueado, redirigir al dashboard con acción explícita
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        } else {
            // No hay sesión, mostrar login
            require_once __DIR__ . '/../controllers/AuthController.php';
            $authController = new AuthController();
            $authController->login();
        }
    }
}