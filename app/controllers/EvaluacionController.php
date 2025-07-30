<?php

class EvaluacionController
{
    public function nueva()
    {
        // Verificar sesión de evaluador
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        $atleta_id = $_GET['atleta_id'] ?? null;
        if (!$atleta_id) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/Lugar.php';

        // Verificar que el atleta pertenezca al evaluador
        if (!Atleta::verificarPertenenciaEvaluador($atleta_id, $_SESSION['usuario_id'])) {
            header('Location: index.php?controller=Atleta&action=listado&error=atleta_no_autorizado');
            exit;
        }

        // Obtener datos del atleta
        $atleta = Atleta::buscarPorId($atleta_id);
        if (!$atleta) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        // Obtener lugares disponibles
        $lugares = Lugar::todos();
        
        // Lista de tests disponibles organizados por categoría
        $tests = [
            'antropometría' => [
                [
                    'id' => 'talla_sentado',
                    'nombre' => 'Talla Sentado',
                    'descripcion' => 'Mide la altura del tronco en posición sentada',
                    'icono' => 'ruler-vertical'
                ],
                [
                    'id' => 'envergadura',
                    'nombre' => 'Envergadura',
                    'descripcion' => 'Mide la distancia entre las puntas de los dedos con brazos extendidos',
                    'icono' => 'arrows-alt-h'
                ]
            ],
            'fuerza' => [
                [
                    'id' => 'fuerza_prensa',
                    'nombre' => 'Fuerza en Prensa',
                    'descripcion' => 'Evalúa la fuerza máxima en piernas',
                    'icono' => 'dumbbell'
                ],
                [
                    'id' => 'salto_vertical',
                    'nombre' => 'Salto Vertical',
                    'descripcion' => 'Mide la potencia de salto vertical',
                    'icono' => 'arrow-up'
                ]
            ],
            'resistencia' => [
                [
                    'id' => 'test_cooper',
                    'nombre' => 'Test de Cooper',
                    'descripcion' => 'Evalúa la resistencia aeróbica',
                    'icono' => 'running'
                ],
                [
                    'id' => 'course_navette',
                    'nombre' => 'Course Navette',
                    'descripcion' => 'Test de resistencia progresiva',
                    'icono' => 'exchange-alt'
                ]
            ],
            'flexibilidad' => [
                [
                    'id' => 'sit_and_reach',
                    'nombre' => 'Sit and Reach',
                    'descripcion' => 'Evalúa la flexibilidad de la cadena posterior',
                    'icono' => 'hands-helping'
                ]
            ],
            'velocidad' => [
                [
                    'id' => 'velocidad_30m',
                    'nombre' => 'Velocidad 30m',
                    'descripcion' => 'Mide la velocidad en 30 metros',
                    'icono' => 'tachometer-alt'
                ]
            ]
        ];

        // Agregar la URL a cada test
        foreach ($tests as $categoria => $testList) {
            foreach ($testList as $key => $test) {
                $tests[$categoria][$key]['url'] = 'index.php?controller=Test&action=realizar&test=' . 
                                                $test['id'] . '&evaluacion_id=NEW&atleta_id=' . $atleta_id;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asegurar que evaluador_id esté presente en sesión
            if (!isset($_SESSION['evaluador_id'])) {
                require_once __DIR__ . '/../models/Evaluador.php';
                global $pdo;
                $stmt = $pdo->prepare("SELECT email FROM usuarios WHERE id = ? LIMIT 1");
                $stmt->execute([$_SESSION['usuario_id']]);
                $user = $stmt->fetch();
                if ($user) {
                    $evaluador = Evaluador::obtenerPorEmail($user['email']);
                    if ($evaluador) {
                        $_SESSION['evaluador_id'] = $evaluador['id'];
                    }
                }
            }

            $data = [
                'atleta_id' => $atleta_id,
                'evaluador_id' => $_SESSION['evaluador_id'],
                'fecha_evaluacion' => $_POST['fecha_evaluacion'] ?? date('Y-m-d'),
                'hora_inicio' => $_POST['hora_inicio'] ?? date('H:i:s'),
                'observaciones' => $_POST['observaciones'] ?? null,
                'clima' => $_POST['clima'] ?? null,
                'temperatura_ambiente' => $_POST['temperatura_ambiente'] ?? null
            ];

            // Almacenar el lugar seleccionado en la sesión por si se necesita
            if (isset($_POST['lugar_id'])) {
                $_SESSION['lugar_evaluacion'] = $_POST['lugar_id'];
            }

            try {
                require_once __DIR__ . '/../models/Evaluacion.php';
                $evaluacion_id = Evaluacion::crear($data);
                header('Location: index.php?controller=Evaluacion&action=ver&id=' . $evaluacion_id);
                exit;
            } catch (Exception $e) {
                $error = 'Error al crear la evaluación: ' . $e->getMessage();
            }
        }

        require_once __DIR__ . '/../views/evaluaciones/nueva.php';
    }

    public function ver()
    {
        // Verificar sesión de evaluador
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        $evaluacion_id = $_GET['id'] ?? null;
        if (!$evaluacion_id) {
            header('Location: index.php?controller=Evaluacion&action=listado');
            exit;
        }

        require_once __DIR__ . '/../models/Evaluacion.php';

        // Obtener datos de la evaluación
        $evaluacion = Evaluacion::porId($evaluacion_id);
        if (!$evaluacion) {
            header('Location: index.php?controller=Evaluacion&action=listado');
            exit;
        }

        // Verificar que la evaluación pertenezca al evaluador actual
        if (!isset($_SESSION['evaluador_id'])) {
            require_once __DIR__ . '/../models/Evaluador.php';
            global $pdo;
            $stmt = $pdo->prepare("SELECT email FROM usuarios WHERE id = ? LIMIT 1");
            $stmt->execute([$_SESSION['usuario_id']]);
            $user = $stmt->fetch();
            if ($user) {
                $evaluador = Evaluador::obtenerPorEmail($user['email']);
                if ($evaluador) {
                    $_SESSION['evaluador_id'] = $evaluador['id'];
                }
            }
        }

        if ($evaluacion['evaluador_id'] != $_SESSION['evaluador_id']) {
            header('Location: index.php?controller=Evaluacion&action=listado&error=evaluacion_no_autorizada');
            exit;
        }

        // Obtener resultados de tests de esta evaluación
        $resultados = Evaluacion::obtenerResultados($evaluacion_id);
        
        require_once __DIR__ . '/../views/evaluaciones/ver.php';
    }

    public function listado()
    {
        // Verificar sesión de evaluador
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        // Asegurar que evaluador_id esté presente en sesión
        if (!isset($_SESSION['evaluador_id'])) {
            require_once __DIR__ . '/../models/Evaluador.php';
            global $pdo;
            $stmt = $pdo->prepare("SELECT email FROM usuarios WHERE id = ? LIMIT 1");
            $stmt->execute([$_SESSION['usuario_id']]);
            $user = $stmt->fetch();
            if ($user) {
                $evaluador = Evaluador::obtenerPorEmail($user['email']);
                if ($evaluador) {
                    $_SESSION['evaluador_id'] = $evaluador['id'];
                }
            }
        }

        require_once __DIR__ . '/../models/Evaluacion.php';
        $evaluaciones = Evaluacion::porEvaluador($_SESSION['evaluador_id']);

        require_once __DIR__ . '/../views/evaluaciones/listado.php';
    }

    public function finalizar()
    {
        // Verificar sesión de evaluador
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $evaluacion_id = $_POST['evaluacion_id'] ?? null;
            if (!$evaluacion_id) {
                header('Location: index.php?controller=Evaluacion&action=listado');
                exit;
            }

            require_once __DIR__ . '/../models/Evaluacion.php';

            // Verificar que la evaluación pertenezca al evaluador
            $evaluacion = Evaluacion::porId($evaluacion_id);
            if (!$evaluacion || $evaluacion['evaluador_id'] != $_SESSION['evaluador_id']) {
                header('Location: index.php?controller=Evaluacion&action=listado&error=evaluacion_no_autorizada');
                exit;
            }

            $data = [
                'hora_fin' => date('H:i:s'),
                'estado' => 'completada',
                'observaciones' => $_POST['observaciones'] ?? $evaluacion['observaciones'],
                'clima' => $_POST['clima'] ?? $evaluacion['clima'],
                'temperatura_ambiente' => $_POST['temperatura_ambiente'] ?? $evaluacion['temperatura_ambiente']
            ];

            try {
                Evaluacion::actualizar($evaluacion_id, $data);
                header('Location: index.php?controller=Evaluacion&action=ver&id=' . $evaluacion_id . '&success=finalizada');
                exit;
            } catch (Exception $e) {
                header('Location: index.php?controller=Evaluacion&action=ver&id=' . $evaluacion_id . '&error=finalizar');
                exit;
            }
        }

        header('Location: index.php?controller=Evaluacion&action=listado');
        exit;
    }
} 