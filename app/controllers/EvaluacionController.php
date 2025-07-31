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

        // PERMISOS AMPLIOS: Cualquier evaluador puede evaluar cualquier atleta
        // Se removió la verificación de pertenencia para permitir evaluaciones flexibles

        // Obtener datos del atleta
        $atleta = Atleta::buscarPorId($atleta_id);
        if (!$atleta) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        // Obtener lugares disponibles
        $lugares = Lugar::todos();
        
        // Obtener tests dinámicos de la base de datos
        require_once __DIR__ . '/../models/Test.php';
        $tests_db = Test::todos();
        
        // Mapeo de iconos por nombre de test
        $iconos_tests = [
            'Talla Sentado' => 'ruler-vertical',
            'Envergadura' => 'arrows-alt-h',
            'Fuerza en Prensa' => 'dumbbell',
            'Salto Vertical' => 'arrow-up',
            'Test de Cooper' => 'running',
            'Course Navette' => 'exchange-alt',
            'Sit and Reach' => 'hands-helping',
            'Velocidad 30m' => 'tachometer-alt',
            'Flexibilidad de Hombros' => 'user-friends',
            'Resistencia Cardiovascular' => 'heartbeat',
            'Fuerza de Piernas' => 'walking',
            'Equilibrio Estático' => 'balance-scale',
            'Velocidad de Reacción' => 'bolt'
        ];
        
        // Organizar tests por categoría basándose en el nombre
        $tests = [
            'antropometría' => [],
            'fuerza' => [],
            'resistencia' => [],
            'flexibilidad' => [],
            'velocidad' => []
        ];
        
        foreach ($tests_db as $test) {
            $icono = $iconos_tests[$test['nombre_test']] ?? 'clipboard-check';
            
            $test_data = [
                'id' => $test['id'],
                'nombre' => $test['nombre_test'],
                'descripcion' => $test['descripcion'],
                'icono' => $icono
            ];
            
            // Categorizar basándose en el nombre del test
            $nombre_lower = strtolower($test['nombre_test']);
            if (strpos($nombre_lower, 'talla') !== false || strpos($nombre_lower, 'envergadura') !== false) {
                $tests['antropometría'][] = $test_data;
            } elseif (strpos($nombre_lower, 'fuerza') !== false || strpos($nombre_lower, 'salto') !== false || strpos($nombre_lower, 'prensa') !== false) {
                $tests['fuerza'][] = $test_data;
            } elseif (strpos($nombre_lower, 'resistencia') !== false || strpos($nombre_lower, 'cooper') !== false || strpos($nombre_lower, 'navette') !== false) {
                $tests['resistencia'][] = $test_data;
            } elseif (strpos($nombre_lower, 'flexibilidad') !== false || strpos($nombre_lower, 'sit and reach') !== false) {
                $tests['flexibilidad'][] = $test_data;
            } elseif (strpos($nombre_lower, 'velocidad') !== false || strpos($nombre_lower, 'reacción') !== false) {
                $tests['velocidad'][] = $test_data;
            } else {
                // Si no coincide con ninguna categoría, agregar a fuerza por defecto
                $tests['fuerza'][] = $test_data;
            }
        }

        // Obtener evaluación existente o crear una nueva
        require_once __DIR__ . '/../models/Evaluacion.php';
        $evaluacion_id = null;
        
        // Buscar evaluación en progreso para este atleta
        $evaluacion_existente = Evaluacion::buscarEnProgreso($atleta_id, $_SESSION['usuario_id']);
        if ($evaluacion_existente) {
            $evaluacion_id = $evaluacion_existente['id'];
        }
        
        // Obtener resultados de tests ya realizados
        $resultados_realizados = [];
        if ($evaluacion_id) {
            $resultados_realizados = Evaluacion::obtenerResultados($evaluacion_id);
        }
        
        // Agregar información de estado a cada test
        foreach ($tests as $categoria => $testList) {
            foreach ($testList as $key => $test) {
                $test_id = $test['id'];
                $estado = 'no_realizado'; // Por defecto
                $progreso = 0;
                
                // Verificar si el test ya fue realizado
                foreach ($resultados_realizados as $resultado) {
                    if ($resultado['test_id'] == $test_id) {
                        $estado = 'completado';
                        $progreso = 100;
                        break;
                    }
                }
                
                $tests[$categoria][$key]['estado'] = $estado;
                $tests[$categoria][$key]['progreso'] = $progreso;
                $tests[$categoria][$key]['url'] = 'index.php?controller=Evaluacion&action=realizarTest&test=' . 
                                                $test_id . '&evaluacion_id=' . $evaluacion_id . '&atleta_id=' . $atleta_id;
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
    
    public function realizarTest()
    {
        // Verificar sesión de evaluador
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        $test_id = $_GET['test'] ?? null;
        $evaluacion_id = $_GET['evaluacion_id'] ?? null;
        $atleta_id = $_GET['atleta_id'] ?? null;
        
        if (!$test_id || !$atleta_id) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/Evaluacion.php';
        require_once __DIR__ . '/../models/ResultadoTest.php';

        // PERMISOS AMPLIOS: Cualquier evaluador puede realizar tests a cualquier atleta
        // Se removió la verificación de pertenencia para permitir evaluaciones flexibles

        // Obtener datos del atleta
        $atleta = Atleta::buscarPorId($atleta_id);
        if (!$atleta) {
            header('Location: index.php?controller=Atleta&action=listado');
            exit;
        }

        // Crear evaluación si no existe
        if (!$evaluacion_id || $evaluacion_id === 'null') {
            $data = [
                'atleta_id' => $atleta_id,
                'evaluador_id' => $_SESSION['evaluador_id'] ?? $_SESSION['usuario_id'],
                'fecha_evaluacion' => date('Y-m-d'),
                'hora_inicio' => date('H:i:s'),
                'estado' => 'iniciada'
            ];
            $evaluacion_id = Evaluacion::crear($data);
        }

        // Inicializar variables
        $error = null;
        
        // Obtener información del test desde la base de datos
        require_once __DIR__ . '/../models/Test.php';
        $test_info = $this->obtenerInfoTestDinamico($test_id);
        
        // Si no se encuentra en BD, intentar el método estático como fallback
        if (!$test_info) {
            $test_info = $this->obtenerInfoTest($test_id);
        }
        
        // Si aún no hay información del test, mostrar error
        if (!$test_info) {
            $error = "No se encontró información para el test solicitado (ID: $test_id)";
        }
        
        // Obtener resultado existente si existe
        $resultado_existente = ResultadoTest::buscarPorTestYEvaluacion($test_id, $evaluacion_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado_data = [
                'evaluacion_id' => $evaluacion_id,
                'atleta_id' => $atleta_id,
                'test_id' => $test_id,
                'evaluador_id' => $_SESSION['evaluador_id'] ?? $_SESSION['usuario_id'],
                'fecha_test' => date('Y-m-d H:i:s'),
                'resultado_json' => json_encode($_POST['resultados'] ?? []),
                'observaciones' => $_POST['observaciones'] ?? null
            ];

            try {
                if ($resultado_existente) {
                    // Actualizar resultado existente
                    ResultadoTest::actualizar($resultado_existente['id'], $resultado_data);
                } else {
                    // Crear nuevo resultado
                    ResultadoTest::crear($resultado_data);
                }
                
                // Redirigir de vuelta a la evaluación
                header('Location: index.php?controller=Evaluacion&action=nueva&atleta_id=' . $atleta_id . '&success=test_completado');
                exit;
            } catch (Exception $e) {
                $error = 'Error al guardar el resultado: ' . $e->getMessage();
            }
        }

        require_once __DIR__ . '/../views/evaluaciones/realizar_test.php';
    }
    
    private function obtenerInfoTest($test_id)
    {
        // Mapeo completo de campos para todos los tests
        $tests_info = [
            1 => [ // Flexibilidad de Hombros
                'nombre' => 'Flexibilidad de Hombros',
                'descripcion' => 'Test de flexibilidad para evaluar el rango de movimiento de los hombros',
                'campos' => [
                    'rango_movimiento' => ['label' => 'Rango de Movimiento (grados)', 'type' => 'number', 'step' => '1']
                ]
            ],
            2 => [ // Resistencia Cardiovascular
                'nombre' => 'Resistencia Cardiovascular',
                'descripcion' => 'Test de resistencia para evaluar la capacidad cardiovascular',
                'campos' => [
                    'frecuencia_cardiaca' => ['label' => 'Frecuencia Cardíaca (ppm)', 'type' => 'number'],
                    'tiempo_recuperacion' => ['label' => 'Tiempo de Recuperación (min)', 'type' => 'number', 'step' => '0.1']
                ]
            ],
            3 => [ // Fuerza de Piernas
                'nombre' => 'Fuerza de Piernas',
                'descripcion' => 'Test de fuerza para evaluar la potencia de las extremidades inferiores',
                'campos' => [
                    'peso_maximo' => ['label' => 'Peso Máximo (kg)', 'type' => 'number', 'step' => '0.5'],
                    'repeticiones' => ['label' => 'Repeticiones', 'type' => 'number']
                ]
            ],
            4 => [ // Equilibrio Estático
                'nombre' => 'Equilibrio Estático',
                'descripcion' => 'Test de equilibrio para evaluar la estabilidad corporal',
                'campos' => [
                    'tiempo_equilibrio' => ['label' => 'Tiempo de Equilibrio (segundos)', 'type' => 'number', 'step' => '0.1']
                ]
            ],
            5 => [ // Velocidad de Reacción
                'nombre' => 'Velocidad de Reacción',
                'descripcion' => 'Test de velocidad para evaluar el tiempo de respuesta',
                'campos' => [
                    'tiempo_reaccion' => ['label' => 'Tiempo de Reacción (ms)', 'type' => 'number']
                ]
            ],
            6 => [ // Talla Sentado
                'nombre' => 'Talla Sentado',
                'descripcion' => 'Mide la altura del tronco en posición sentada',
                'campos' => [
                    'talla_sentado_cm' => ['label' => 'Talla Sentado (cm)', 'type' => 'number', 'step' => '0.1']
                ]
            ],
            7 => [ // Envergadura
                'nombre' => 'Envergadura',
                'descripcion' => 'Mide la distancia entre las puntas de los dedos con brazos extendidos',
                'campos' => [
                    'envergadura' => ['label' => 'Envergadura (cm)', 'type' => 'number', 'step' => '0.1']
                ]
            ],
            8 => [ // Fuerza en Prensa
                'nombre' => 'Fuerza en Prensa',
                'descripcion' => 'Evalúa la fuerza máxima en piernas',
                'campos' => [
                    'peso_maximo' => ['label' => 'Peso Máximo (kg)', 'type' => 'number', 'step' => '0.5'],
                    'repeticiones' => ['label' => 'Repeticiones', 'type' => 'number']
                ]
            ],
            9 => [ // Salto Vertical
                'nombre' => 'Salto Vertical',
                'descripcion' => 'Mide la potencia de salto vertical',
                'campos' => [
                    'altura_salto' => ['label' => 'Altura del Salto (cm)', 'type' => 'number', 'step' => '0.1']
                ]
            ],
            10 => [ // Test de Cooper
                'nombre' => 'Test de Cooper',
                'descripcion' => 'Evalúa la resistencia aeróbica',
                'campos' => [
                    'distancia' => ['label' => 'Distancia Recorrida (m)', 'type' => 'number'],
                    'tiempo' => ['label' => 'Tiempo (minutos)', 'type' => 'number', 'step' => '0.1']
                ]
            ],
            11 => [ // Course Navette
                'nombre' => 'Course Navette',
                'descripcion' => 'Test de resistencia progresiva',
                'campos' => [
                    'nivel_alcanzado' => ['label' => 'Nivel Alcanzado', 'type' => 'number'],
                    'palier' => ['label' => 'Palier', 'type' => 'number'],
                    'vma' => ['label' => 'VMA (km/h)', 'type' => 'number', 'step' => '0.1']
                ]
            ],
            12 => [ // Sit and Reach
                'nombre' => 'Sit and Reach',
                'descripcion' => 'Evalúa la flexibilidad de la cadena posterior',
                'campos' => [
                    'distancia' => ['label' => 'Distancia Alcanzada (cm)', 'type' => 'number', 'step' => '0.1']
                ]
            ],
            13 => [ // Velocidad 30m
                'nombre' => 'Velocidad 30m',
                'descripcion' => 'Mide la velocidad en 30 metros',
                'campos' => [
                    'tiempo' => ['label' => 'Tiempo (segundos)', 'type' => 'number', 'step' => '0.01']
                ]
            ]
        ];
        
        return $tests_info[$test_id] ?? null;
    }
    
    private function obtenerInfoTestDinamico($test_id)
    {
        // Obtener información del test desde la base de datos
        global $pdo;
        
        try {
            $stmt = $pdo->prepare("SELECT * FROM tests WHERE id = ? LIMIT 1");
            $stmt->execute([$test_id]);
            $test = $stmt->fetch();
            
            if (!$test) {
                return null;
            }
            
            // Configuración de campos por defecto basada en el tipo de test
            $campos_basicos = [
                'resultado_principal' => [
                    'label' => 'Resultado Principal',
                    'type' => 'number',
                    'step' => '0.1',
                    'required' => true
                ],
                'observaciones_adicionales' => [
                    'label' => 'Observaciones Adicionales',
                    'type' => 'text',
                    'required' => false
                ]
            ];
            
            // Personalizar campos según el nombre del test
            $nombre_test = strtolower($test['nombre_test']);
            
            if (strpos($nombre_test, 'fuerza') !== false) {
                $campos_basicos = [
                    'peso_maximo' => ['label' => 'Peso Máximo (kg)', 'type' => 'number', 'step' => '0.5', 'required' => true],
                    'repeticiones' => ['label' => 'Repeticiones', 'type' => 'number', 'required' => true]
                ];
            } elseif (strpos($nombre_test, 'velocidad') !== false || strpos($nombre_test, 'tiempo') !== false) {
                $campos_basicos = [
                    'tiempo' => ['label' => 'Tiempo (segundos)', 'type' => 'number', 'step' => '0.01', 'required' => true]
                ];
            } elseif (strpos($nombre_test, 'salto') !== false || strpos($nombre_test, 'altura') !== false) {
                $campos_basicos = [
                    'altura_distancia' => ['label' => 'Altura/Distancia (cm)', 'type' => 'number', 'step' => '0.1', 'required' => true]
                ];
            } elseif (strpos($nombre_test, 'resistencia') !== false || strpos($nombre_test, 'cooper') !== false) {
                $campos_basicos = [
                    'distancia' => ['label' => 'Distancia (metros)', 'type' => 'number', 'required' => true],
                    'tiempo' => ['label' => 'Tiempo (minutos)', 'type' => 'number', 'step' => '0.1', 'required' => true]
                ];
            } elseif (strpos($nombre_test, 'flexibilidad') !== false) {
                $campos_basicos = [
                    'rango_distancia' => ['label' => 'Rango/Distancia (cm)', 'type' => 'number', 'step' => '0.1', 'required' => true]
                ];
            }
            
            return [
                'nombre' => $test['nombre_test'],
                'descripcion' => $test['descripcion'] ?? 'Test físico',
                'campos' => $campos_basicos
            ];
            
        } catch (Exception $e) {
            error_log("Error en obtenerInfoTestDinamico: " . $e->getMessage());
            return null;
        }
    }
    
    public function guardarTestAjax()
    {
        // Verificar sesión de evaluador
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }

        $test_id = $_POST['test_id'] ?? null;
        $evaluacion_id = $_POST['evaluacion_id'] ?? null;
        $atleta_id = $_POST['atleta_id'] ?? null;
        $resultados = $_POST['resultados'] ?? [];
        $observaciones = $_POST['observaciones'] ?? null;
        
        if (!$test_id || !$atleta_id) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/Evaluacion.php';
        require_once __DIR__ . '/../models/ResultadoTest.php';

        // PERMISOS AMPLIOS: Cualquier evaluador puede guardar tests de cualquier atleta
        // Se removió la verificación de pertenencia para permitir evaluaciones flexibles

        // Crear evaluación si no existe
        if (!$evaluacion_id || $evaluacion_id === 'null') {
            $data = [
                'atleta_id' => $atleta_id,
                'evaluador_id' => $_SESSION['evaluador_id'] ?? $_SESSION['usuario_id'],
                'fecha_evaluacion' => date('Y-m-d'),
                'hora_inicio' => date('H:i:s'),
                'estado' => 'iniciada'
            ];
            $evaluacion_id = Evaluacion::crear($data);
        }

        // Obtener resultado existente si existe
        $resultado_existente = ResultadoTest::buscarPorTestYEvaluacion($test_id, $evaluacion_id);

        $resultado_data = [
            'evaluacion_id' => $evaluacion_id,
            'atleta_id' => $atleta_id,
            'test_id' => $test_id,
            'evaluador_id' => $_SESSION['evaluador_id'] ?? $_SESSION['usuario_id'],
            'fecha_test' => date('Y-m-d H:i:s'),
            'resultado_json' => json_encode($resultados),
            'observaciones' => $observaciones
        ];

        try {
            if ($resultado_existente) {
                // Actualizar resultado existente
                ResultadoTest::actualizar($resultado_existente['id'], $resultado_data);
            } else {
                // Crear nuevo resultado
                ResultadoTest::crear($resultado_data);
            }
            
            echo json_encode(['success' => true, 'message' => 'Test guardado exitosamente']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }

    public function finalizarEvaluacionAjax()
    {
        // Verificar sesión de evaluador
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            return;
        }

        try {
            $evaluacion_id = $_POST['evaluacion_id'] ?? null;
            if (!$evaluacion_id) {
                echo json_encode(['success' => false, 'error' => 'ID de evaluación requerido']);
                return;
            }

            require_once __DIR__ . '/../models/Evaluacion.php';

            // Verificar que la evaluación pertenezca al evaluador actual
            $evaluacion = Evaluacion::porId($evaluacion_id);
            if (!$evaluacion) {
                echo json_encode(['success' => false, 'error' => 'Evaluación no encontrada']);
                return;
            }

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
                echo json_encode(['success' => false, 'error' => 'No autorizado para finalizar esta evaluación']);
                return;
            }

            // Actualizar estado de la evaluación a 'finalizada'
            global $pdo;
            $stmt = $pdo->prepare("UPDATE evaluaciones SET estado = 'finalizada', fecha_finalizacion = NOW() WHERE id = ?");
            $stmt->execute([$evaluacion_id]);

            echo json_encode(['success' => true, 'message' => 'Evaluación finalizada exitosamente']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error al finalizar: ' . $e->getMessage()]);
        }
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

        // PERMISOS AMPLIOS: Mostrar todas las evaluaciones del sistema
        // Cualquier evaluador puede ver todas las evaluaciones
        require_once __DIR__ . '/../models/Evaluacion.php';
        $evaluaciones = Evaluacion::todos();

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

    public function actualizarAmbiental()
    {
        // Verificar sesión de evaluador
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'evaluador') {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $evaluacion_id = $_POST['evaluacion_id'] ?? null;
            $lugar_id = $_POST['lugar_id'] ?? null;
            $clima = $_POST['clima'] ?? null;
            $temperatura_ambiente = $_POST['temperatura_ambiente'] ?? null;

            if (!$evaluacion_id) {
                header('Location: index.php?controller=Evaluacion&action=listado&error=missing_id');
                exit;
            }

            require_once __DIR__ . '/../models/Evaluacion.php';

            // Verificar que la evaluación existe
            $evaluacion = Evaluacion::porId($evaluacion_id);
            if (!$evaluacion) {
                header('Location: index.php?controller=Evaluacion&action=listado&error=not_found');
                exit;
            }

            // Preparar datos para actualizar
            $data = [];
            
            // Actualizar clima si se especificó
            if (!empty($clima)) {
                $data['clima'] = $clima;
            }
            
            // Actualizar temperatura si se especificó
            if (!empty($temperatura_ambiente) && is_numeric($temperatura_ambiente)) {
                $data['temperatura_ambiente'] = floatval($temperatura_ambiente);
            }

            // NOTA: Por ahora no actualizamos lugar_id porque no existe en la tabla evaluaciones
            // El lugar se maneja a través del atleta. Si se requiere lugar específico por evaluación,
            // sería necesario agregar una migración para el campo lugar_id en evaluaciones.

            try {
                // Solo actualizar si hay datos para cambiar
                if (!empty($data)) {
                    Evaluacion::actualizar($evaluacion_id, $data);
                    header('Location: index.php?controller=Evaluacion&action=ver&id=' . $evaluacion_id . '&success=ambiental_updated');
                } else {
                    header('Location: index.php?controller=Evaluacion&action=ver&id=' . $evaluacion_id . '&info=no_changes');
                }
                exit;
            } catch (Exception $e) {
                error_log("Error actualizando clima y temperatura: " . $e->getMessage());
                header('Location: index.php?controller=Evaluacion&action=ver&id=' . $evaluacion_id . '&error=update_failed');
                exit;
            }
        }

        header('Location: index.php?controller=Evaluacion&action=listado');
        exit;
    }
} 