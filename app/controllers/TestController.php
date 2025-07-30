<?php

class TestController
{
    public function asignar()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
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
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
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
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        require_once __DIR__ . '/../models/Evaluacion.php';
        $evaluaciones = Evaluacion::porEvaluador($_SESSION['usuario_id']);

        require_once __DIR__ . '/../views/tests/resultados.php';
    }

    public function nuevaEvaluacion()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/Evaluacion.php';
            require_once __DIR__ . '/../models/Atleta.php';
            
            // Verificar que el atleta pertenece al mismo establecimiento del evaluador
            if (!Atleta::verificarPertenenciaEvaluador($_POST['atleta_id'], $_SESSION['usuario_id'])) {
                header('Location: index.php?controller=Test&action=nuevaEvaluacion&error=atleta_no_autorizado');
                exit;
            }
            
            // Verificar que el evaluador_id está en la sesión
            if (!isset($_SESSION['evaluador_id'])) {
                $_SESSION['error'] = 'No se pudo identificar al evaluador. Por favor, inicie sesión nuevamente.';
                header('Location: index.php?controller=Auth&action=login');
                exit;
            }

            $data = [
                'atleta_id' => $_POST['atleta_id'],
                'evaluador_id' => $_SESSION['evaluador_id'],
                'lugar_id' => $_POST['lugar_id'],
                'fecha_evaluacion' => $_POST['fecha_evaluacion'],
                'hora_inicio' => $_POST['hora_inicio'] ?? null,
                'observaciones' => $_POST['observaciones'] ?? null,
                'clima' => $_POST['clima'] ?? null,
                'temperatura_ambiente' => $_POST['temperatura_ambiente'] ?? null
            ];

            $evaluacion_id = Evaluacion::crear($data);
            header('Location: index.php?controller=Test&action=evaluacion&id=' . $evaluacion_id);
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/Lugar.php';

        $atletas = Atleta::todosPorEvaluador($_SESSION['usuario_id']);
        
        // Solo mostrar el lugar del evaluador
        require_once __DIR__ . '/../models/Atleta.php';
        $lugar_evaluador = Atleta::obtenerLugarEvaluador($_SESSION['usuario_id']);
        $lugares = [];
        if ($lugar_evaluador) {
            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM lugares WHERE id = ?");
            $stmt->execute([$lugar_evaluador]);
            $lugares = $stmt->fetchAll();
        }

        require_once __DIR__ . '/../views/tests/nueva_evaluacion.php';
    }

    public function evaluacion()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        $evaluacion_id = $_GET['id'] ?? null;
        if (!$evaluacion_id) {
            header('Location: index.php?controller=Test&action=resultados');
            exit;
        }

        require_once __DIR__ . '/../models/Evaluacion.php';
        require_once __DIR__ . '/../models/Test.php';

        $evaluacion = Evaluacion::porId($evaluacion_id);
        
        // Verificar que la evaluación pertenece al evaluador actual
        if (!$evaluacion || $evaluacion['evaluador_id'] != $_SESSION['usuario_id']) {
            header('Location: index.php?controller=Test&action=resultados&error=evaluacion_no_autorizada');
            exit;
        }

        $resultados = Evaluacion::obtenerResultados($evaluacion_id);
        $tests_disponibles = Test::todos();

        require_once __DIR__ . '/../views/tests/evaluacion.php';
    }

    public function agregarTest()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/ResultadoTest.php';
            require_once __DIR__ . '/../models/Atleta.php';
            require_once __DIR__ . '/../models/Evaluacion.php';
            
            // Verificar que el atleta pertenece al mismo establecimiento del evaluador
            if (!Atleta::verificarPertenenciaEvaluador($_POST['atleta_id'], $_SESSION['usuario_id'])) {
                header('Location: index.php?controller=Test&action=evaluacion&id=' . $_POST['evaluacion_id'] . '&error=atleta_no_autorizado');
                exit;
            }
            
            // Verificar que la evaluación pertenece al evaluador actual
            $evaluacion = Evaluacion::porId($_POST['evaluacion_id']);
            if (!$evaluacion || $evaluacion['evaluador_id'] != $_SESSION['usuario_id']) {
                header('Location: index.php?controller=Test&action=resultados&error=evaluacion_no_autorizada');
                exit;
            }
            
            $data = $_POST;
            $data['evaluador_id'] = $_SESSION['usuario_id'];
            
            ResultadoTest::crear($data);
            header('Location: index.php?controller=Test&action=evaluacion&id=' . $_POST['evaluacion_id']);
            exit;
        }
    }

    public function catalogo()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        require_once __DIR__ . '/../models/Test.php';
        $tests = Test::todos();

        require_once __DIR__ . '/../views/tests/catalogo.php';
    }
}
