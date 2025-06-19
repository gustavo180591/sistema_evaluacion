<?php

class DashboardController
{
    public function index()
    {
        // session_start() ya se ejecuta en index.php, no duplicar
        
        if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        $rol = $_SESSION['rol'];

        if ($rol === 'administrador') {
            require_once __DIR__ . '/../views/dashboard/admin.php';
        } elseif ($rol === 'evaluador') {
            require_once __DIR__ . '/../views/dashboard/evaluador.php';
        } else {
            echo "Rol no válido";
            exit;
        }
    }
}
