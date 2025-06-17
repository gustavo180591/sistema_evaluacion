<?php

class AtletaController
{
    public function listado()
    {
        session_start();
        if ($_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        $atletas = Atleta::todosPorEvaluador($_SESSION['usuario_id']);

        require_once __DIR__ . '/../views/atletas/listado.php';
    }

    public function crear()
    {
        session_start();
        if ($_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/Atleta.php';
            Atleta::crear($_SESSION['usuario_id'], $_POST);
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        require_once __DIR__ . '/../views/atletas/crear.php';
    }

    public function historial()
    {
        session_start();
        if ($_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/ResultadoTest.php';

        $atleta = Atleta::buscarPorId($id);
        $resultados = ResultadoTest::porAtleta($id);

        require_once __DIR__ . '/../views/atletas/historial.php';
    }
}
