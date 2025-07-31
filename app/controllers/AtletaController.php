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
        $atletas = Atleta::todos();

        require_once __DIR__ . '/../views/atletas/listado.php';
    }

    public function crear()
    {
        // Log temporal para diagnóstico
        error_log("AtletaController::crear() - INICIO");
        error_log("SESSION: " . print_r($_SESSION, true));
        error_log("REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);
        
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            error_log("AtletaController::crear() - Redirección por falta de permisos");
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        require_once __DIR__ . '/../models/Discapacidad.php';
        $discapacidades = Discapacidad::todos();
        $esAdaptado = isset($_GET['adaptado']);
        $errores = [];
        $formData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("AtletaController::crear() - Procesando POST");
            error_log("POST data: " . print_r($_POST, true));
            
            // Asegurar que evaluador_id esté presente en sesión antes de procesar POST
            if (!isset($_SESSION['evaluador_id'])) {
                error_log("AtletaController::crear() - evaluador_id no está en sesión, buscando...");
                require_once __DIR__ . '/../models/Evaluador.php';
                global $pdo;
                $stmt = $pdo->prepare("SELECT email FROM usuarios WHERE id = ? LIMIT 1");
                $stmt->execute([$_SESSION['usuario_id']]);
                $user = $stmt->fetch();
                if ($user) {
                    $evaluador = Evaluador::obtenerPorEmail($user['email']);
                } else {
                    $evaluador = false;
                }
                if ($evaluador) {
                    $_SESSION['evaluador_id'] = $evaluador['id'];
                } else {
                    $_SESSION['error'] = 'Sesión de evaluador inválida. Por favor, inicia sesión nuevamente.';
                    header('Location: index.php?controller=Dashboard&action=index');
                    exit;
                }
            }

            // Validar datos
            if (empty($_POST['nombre'])) {
                $errores[] = 'El nombre es requerido';
            }
            if (empty($_POST['apellido'])) {
                $errores[] = 'El apellido es requerido';
            }
            if (empty($_POST['dni'])) {
                $errores[] = 'El DNI es requerido';
            }
            if (empty($_POST['fecha_nacimiento'])) {
                $errores[] = 'La fecha de nacimiento es requerida';
            }
            if (empty($_POST['sexo'])) {
                $errores[] = 'El sexo es requerido';
            }
            
            // Si es adaptado, la discapacidad es obligatoria
            if ($esAdaptado && empty($_POST['discapacidad_id'])) {
                $errores[] = 'La discapacidad es obligatoria para atletas adaptados';
            }

            if (empty($errores)) {
                try {
                    $data = [
                        'nombre' => $_POST['nombre'],
                        'apellido' => $_POST['apellido'],
                        'dni' => $_POST['dni'],
                        'sexo' => $_POST['sexo'],
                        'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                        'altura_cm' => $_POST['altura_cm'] ?? null,
                        'peso_kg' => $_POST['peso_kg'] ?? null,
                        'envergadura_cm' => $_POST['envergadura_cm'] ?? null,
                        'altura_sentado_cm' => $_POST['altura_sentado_cm'] ?? null,
                        'lateralidad_visual' => $_POST['lateralidad_visual'] ?? null,
                        'lateralidad_podal' => $_POST['lateralidad_podal'] ?? null,
                        'discapacidad_id' => !empty($_POST['discapacidad_id']) ? (int)$_POST['discapacidad_id'] : null
                    ];
                    
                    // Usar el ID del evaluador correcto desde sesión
                    error_log("AtletaController::crear() - Llamando a Atleta::crear con evaluador_id: " . $_SESSION['evaluador_id']);
                    $resultado = Atleta::crear($_SESSION['evaluador_id'], $data);
                    error_log("AtletaController::crear() - Resultado de crear: " . ($resultado ? 'ÉXITO' : 'FALLO'));
                    
                    // Redirigir a la vista de adaptados si venimos de ahí
                    if ($esAdaptado) {
                        error_log("AtletaController::crear() - Redirigiendo a adaptados");
                        header('Location: index.php?controller=Atleta&action=adaptados&success=1');
                    } else {
                        error_log("AtletaController::crear() - Redirigiendo a listado");
                        header('Location: index.php?controller=Atleta&action=listado&success=1');
                    }
                    exit;
                } catch (Exception $e) {
                    $errores[] = 'Error al crear el atleta: ' . $e->getMessage();
                }
            } else {
                // Mantener los datos del formulario si hay errores
                $formData = $_POST;
            }
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

        // PERMISOS AMPLIOS: Cualquier evaluador puede editar cualquier atleta
        // Se removió la verificación de pertenencia para permitir edición flexible

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener los datos actuales del atleta
            $atletaActual = Atleta::buscarPorId($id);
            
            // Usar datos del formulario, preservando solo evaluador_id si no se envía
            $datosActualizados = $_POST;
            
            // Solo preservar evaluador_id si no viene en el formulario
            if (!isset($datosActualizados['evaluador_id'])) {
                $datosActualizados['evaluador_id'] = $atletaActual['evaluador_id'];
            }
            
            // Actualizar los datos del atleta
            $resultado = Atleta::actualizar($id, $datosActualizados);
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

    public function exportarHistorialPDF()
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
        require_once __DIR__ . '/../utils/PDFGenerator.php';

        $atleta = Atleta::buscarPorId($id);
        $resultados = ResultadoTest::porAtleta($id);

        if (!$atleta) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        $pdfGenerator = new PDFGenerator();
        $pdfGenerator->generarHistorialAtleta($atleta, $resultados);
    }

    public function exportarHistorialExcel()
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
        require_once __DIR__ . '/../utils/ExcelExporter.php';

        $atleta = Atleta::buscarPorId($id);
        $resultados = ResultadoTest::porAtleta($id);

        if (!$atleta) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        $excelExporter = new ExcelExporter();
        $excelExporter->exportarHistorialAtleta($atleta, $resultados);
    }

    public function exportarTestPDF()
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

        require_once __DIR__ . '/../models/ResultadoTest.php';
        require_once __DIR__ . '/../utils/PDFGenerator.php';

        $resultado = ResultadoTest::buscarPorId($id);
        if (!$resultado) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        $pdfGenerator = new PDFGenerator();
        $pdfGenerator->generarTestIndividual($resultado);
    }

    public function adaptados()
    {
        // session_start() ya se ejecuta en index.php
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/Discapacidad.php';
        
        $atletas = Atleta::todosPorEvaluador($_SESSION['usuario_id']);
        $discapacidades = Discapacidad::todos();

        require_once __DIR__ . '/../views/atletas/adaptados.php';
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

        // NUEVO: Cualquier evaluador puede ocultar cualquier atleta
        // Se removió la verificación de pertenencia para permitir permisos amplios

        // Obtener el nombre del atleta antes de eliminarlo (para el mensaje de confirmación)
        $atleta = Atleta::buscarPorId($id);
        if (!$atleta) {
            header('Location: index.php?controller=Atleta&action=listado&error=not_found');
            exit;
        }

        // Intentar ocultar el atleta (eliminación suave)
        $resultado = Atleta::ocultar($id);
        
        if ($resultado) {
            header('Location: index.php?controller=Atleta&action=listado&success=hidden&nombre=' . urlencode($atleta['nombre'] . ' ' . $atleta['apellido']));
        } else {
            header('Location: index.php?controller=Atleta&action=listado&error=hide_failed');
        }
        exit;
    }
}
