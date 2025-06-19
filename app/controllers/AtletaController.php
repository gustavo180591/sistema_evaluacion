<?php

class AtletaController
{
    public function listado()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        $atletas = Atleta::todosPorEvaluador($_SESSION['usuario_id']);

        require_once __DIR__ . '/../views/atletas/listado.php';
    }

    public function crear()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
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

    public function editar()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';

        // Verificar que el atleta pertenezca al evaluador
        if (!Atleta::verificarPertenenciaEvaluador($id, $_SESSION['usuario_id'])) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Actualizar los datos del atleta
            $resultado = Atleta::actualizar($id, $_POST);
            if ($resultado) {
                header('Location: index.php?controller=Atleta&action=listado&success=1');
            } else {
                header('Location: index.php?controller=Atleta&action=editar&id=' . $id . '&error=1');
            }
            exit;
        }

        // Obtener los datos del atleta para mostrar en el formulario
        $atleta = Atleta::buscarPorId($id);
        if (!$atleta) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        require_once __DIR__ . '/../views/atletas/editar.php';
    }

    public function historial()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
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

    public function eliminar()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        // Solo procesar si es una petición POST con confirmación
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['confirmar']) || $_POST['confirmar'] !== '1') {
            header('Location: index.php?controller=Atleta&action=listado&error=invalid_request');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Atleta&action=listado&error=missing_id');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';

        // Verificar que el atleta pertenezca al evaluador
        if (!Atleta::verificarPertenenciaEvaluador($id, $_SESSION['usuario_id'])) {
            header('Location: index.php?controller=Atleta&action=listado&error=not_authorized');
            exit;
        }

        // Obtener el nombre del atleta antes de eliminarlo (para el mensaje de confirmación)
        $atleta = Atleta::buscarPorId($id);
        if (!$atleta) {
            header('Location: index.php?controller=Atleta&action=listado&error=not_found');
            exit;
        }

        // Intentar eliminar el atleta
        $resultado = Atleta::eliminar($id);
        
        if ($resultado) {
            header('Location: index.php?controller=Atleta&action=listado&success=deleted&nombre=' . urlencode($atleta['nombre'] . ' ' . $atleta['apellido']));
        } else {
            header('Location: index.php?controller=Atleta&action=listado&error=delete_failed');
        }
        exit;
    }
}
