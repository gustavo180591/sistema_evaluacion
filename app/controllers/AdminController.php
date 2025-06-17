<?php

class AdminController
{
    public function usuarios()
    {
        session_start();
        if ($_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Usuario.php';
        $usuarios = Usuario::todos();

        require_once __DIR__ . '/../views/admin/usuarios.php';
    }

    public function estadisticas()
    {
        session_start();
        if ($_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/ResultadoTest.php';

        $cantidadAtletas = Atleta::contar();
        $cantidadResultados = ResultadoTest::contar();

        require_once __DIR__ . '/../views/admin/estadisticas.php';
    }
}
