<?php

class EvaluadorController
{
    public function listado()
    {
        session_start();
        if ($_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Evaluador.php';
        $evaluadores = Evaluador::todos();

        require_once __DIR__ . '/../views/evaluadores/listado.php';
    }

    public function crear()
    {
        session_start();
        if ($_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            require_once __DIR__ . '/../models/Evaluador.php';
            require_once __DIR__ . '/../models/Usuario.php';

            $evaluadorId = Evaluador::crear($nombre, $apellido, $email, $password);
            Usuario::crear('evaluador', $evaluadorId, $email, $password);

            header('Location: index.php?controller=Evaluador&action=listado');
            exit;
        }

        require_once __DIR__ . '/../views/evaluadores/crear.php';
    }
}
