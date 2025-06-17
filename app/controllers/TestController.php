<?php

class TestController
{
    public function asignar()
    {
        session_start();
        if ($_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/Test.php';
        require_once __DIR__ . '/../models/Lugar.php';

        $atletas = Atleta::todosPorEvaluador($_SESSION['usuario_id']);
        $tests = Test::todos();
        $lugares = Lugar::todos();

        require_once __DIR__ . '/../views/tests/asignar.php';
    }

    public function registrar()
    {
        session_start();
        if ($_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/ResultadoTest.php';
            ResultadoTest::crear($_POST);
            header('Location: index.php?controller=Test&action=resultados');
            exit;
        }

        require_once __DIR__ . '/../views/tests/registrar.php';
    }

    public function resultados()
    {
        session_start();
        if ($_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/ResultadoTest.php';
        $resultados = ResultadoTest::porEvaluador($_SESSION['usuario_id']);

        require_once __DIR__ . '/../views/tests/resultados.php';
    }
}
