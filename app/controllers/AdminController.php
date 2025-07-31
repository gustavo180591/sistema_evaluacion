<?php

class AdminController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function usuarios()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Usuario.php';
        $usuarios = Usuario::todos();

        require_once __DIR__ . '/../views/admin/usuarios.php';
    }

    public function estadisticas()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/ResultadoTest.php';
        require_once __DIR__ . '/../models/Test.php';
        require_once __DIR__ . '/../models/Evaluador.php';
        require_once __DIR__ . '/../models/Evaluacion.php';
        require_once __DIR__ . '/../models/Usuario.php';

        // Estadísticas básicas
        $cantidadAtletas = Atleta::contar();
        $cantidadResultados = ResultadoTest::contar();
        $cantidadTests = Test::contar();
        $cantidadEvaluadores = Evaluador::contar();
        $cantidadEvaluaciones = Evaluacion::contar();
        $cantidadUsuarios = Usuario::contar();

        // Estadísticas por mes (últimos 6 meses)
        $estadisticasMensuales = $this->obtenerEstadisticasMensuales();
        
        // Tests más utilizados
        $testsMasUtilizados = $this->obtenerTestsMasUtilizados();
        
        // Evaluadores más activos
        $evaluadoresMasActivos = $this->obtenerEvaluadoresMasActivos();
        
        // Últimas evaluaciones
        $ultimasEvaluaciones = $this->obtenerUltimasEvaluaciones();
        
        // Estadísticas por lugar
        $estadisticasPorLugar = $this->obtenerEstadisticasPorLugar();

        require_once __DIR__ . '/../views/admin/estadisticas.php';
    }

    private function obtenerEstadisticasMensuales()
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT 
                DATE_FORMAT(fecha_test, '%Y-%m') as mes,
                COUNT(*) as total_tests,
                COUNT(DISTINCT atleta_id) as atletas_unicos
            FROM resultados_tests 
            WHERE fecha_test >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(fecha_test, '%Y-%m')
            ORDER BY mes DESC
        ");
        return $stmt->fetchAll();
    }

    private function obtenerTestsMasUtilizados()
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT 
                t.nombre_test,
                COUNT(rt.id) as cantidad,
                ROUND(COUNT(rt.id) * 100.0 / (SELECT COUNT(*) FROM resultados_tests), 1) as porcentaje
            FROM tests t
            LEFT JOIN resultados_tests rt ON t.id = rt.test_id
            GROUP BY t.id, t.nombre_test
            ORDER BY cantidad DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    private function obtenerEvaluadoresMasActivos()
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT 
                CONCAT(u.nombre, ' ', u.apellido) as evaluador,
                COUNT(rt.id) as total_tests,
                COUNT(DISTINCT rt.atleta_id) as atletas_evaluados
            FROM usuarios u
            LEFT JOIN resultados_tests rt ON u.id = rt.evaluador_id
            WHERE u.rol = 'evaluador'
            GROUP BY u.id, u.nombre, u.apellido
            ORDER BY total_tests DESC
            LIMIT 5
        ");
        return $stmt->fetchAll();
    }

    private function obtenerUltimasEvaluaciones()
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT 
                e.fecha_evaluacion,
                CONCAT(a.nombre, ' ', a.apellido) as atleta,
                CONCAT(u.nombre, ' ', u.apellido) as evaluador,
                e.estado,
                COUNT(rt.id) as tests_completados
            FROM evaluaciones e
            JOIN atletas a ON e.atleta_id = a.id
            JOIN usuarios u ON e.evaluador_id = u.id
            LEFT JOIN resultados_tests rt ON e.id = rt.evaluacion_id
            GROUP BY e.id, e.fecha_evaluacion, a.nombre, a.apellido, u.nombre, u.apellido, e.estado
            ORDER BY e.fecha_evaluacion DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    private function obtenerEstadisticasPorLugar()
    {
        global $pdo;
        $stmt = $pdo->query("
            SELECT 
                l.nombre as lugar,
                COUNT(rt.id) as total_tests,
                COUNT(DISTINCT rt.atleta_id) as atletas_unicos
            FROM lugares l
            LEFT JOIN resultados_tests rt ON l.id = rt.lugar_id
            GROUP BY l.id, l.nombre
            ORDER BY total_tests DESC
        ");
        return $stmt->fetchAll();
    }


    public function nuevoUsuario()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        // Si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar y procesar el formulario
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $rol = $_POST['rol'] ?? 'usuario';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validaciones básicas
            $errores = [];
            if (empty($nombre)) $errores[] = 'El nombre es obligatorio';
            if (empty($apellido)) $errores[] = 'El apellido es obligatorio';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'El email no es válido';
            if (empty($password)) {
                $errores[] = 'La contraseña es obligatoria';
            } elseif (strlen($password) < 8) {
                $errores[] = 'La contraseña debe tener al menos 8 caracteres';
            }
            if ($password !== $confirm_password) $errores[] = 'Las contraseñas no coinciden';

            if (empty($errores)) {
                // Hash de la contraseña
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insertar el nuevo usuario
                require_once __DIR__ . '/../models/Usuario.php';
                $resultado = Usuario::crear([
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'rol' => $rol,
                    'estado' => 'activo'
                ]);

                if ($resultado) {
                    $_SESSION['mensaje'] = 'Usuario creado exitosamente';
                    header('Location: index.php?controller=Admin&action=usuarios');
                    exit;
                } else {
                    $errores[] = 'Error al crear el usuario. El correo electrónico podría estar en uso.';
                }
            }

            $_SESSION['errores'] = $errores;
        }

        // Mostrar el formulario
        $errores = $_SESSION['errores'] ?? [];
        unset($_SESSION['errores']);
        
        require_once __DIR__ . '/../views/admin/formulario_usuario.php';
    }
    
    public function toggleEstadoUsuario() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $estado_actual = $_POST['estado_actual'] ?? '';
        $nuevo_estado = $estado_actual === 'activo' ? 'inactivo' : 'activo';

        if ($id) {
            require_once __DIR__ . '/../models/Usuario.php';
            
            try {
                global $pdo;
                $stmt = $pdo->prepare("UPDATE usuarios SET estado = ?, fecha_actualizacion = NOW() WHERE id = ?");
                $result = $stmt->execute([$nuevo_estado, $id]);
                
                if ($result) {
                    $_SESSION['mensaje'] = 'Estado del usuario actualizado correctamente';
                } else {
                    $_SESSION['error'] = 'Error al actualizar el estado del usuario';
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = 'Error en la base de datos: ' . $e->getMessage();
            }
        } else {
            $_SESSION['error'] = 'ID de usuario no proporcionado';
        }
        
        header('Location: index.php?controller=Admin&action=usuarios');
        exit;
    }

    public function tests()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Test.php';
        $tests = Test::todos();

        require_once __DIR__ . '/../views/admin/tests.php';
    }

    public function nuevoTest()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_test = trim($_POST['nombre_test'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');

            // Validaciones
            $errores = [];
            if (empty($nombre_test)) $errores[] = 'El nombre del test es obligatorio';
            if (empty($descripcion)) $errores[] = 'La descripción es obligatoria';

            if (empty($errores)) {
                require_once __DIR__ . '/../models/Test.php';
                
                try {
                    $resultado = Test::crear($nombre_test, $descripcion);
                    if ($resultado) {
                        $_SESSION['mensaje'] = 'Test creado exitosamente';
                        $_SESSION['tipo_mensaje'] = 'success';
                        header('Location: index.php?controller=Admin&action=tests');
                        exit;
                    } else {
                        $errores[] = 'Error al crear el test';
                    }
                } catch (Exception $e) {
                    $errores[] = 'Error al crear el test: ' . $e->getMessage();
                }
            }

            if (!empty($errores)) {
                $_SESSION['mensaje'] = implode(', ', $errores);
                $_SESSION['tipo_mensaje'] = 'danger';
            }
        }

        require_once __DIR__ . '/../views/admin/nuevo_test.php';
    }

    public function editarTest()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Admin&action=tests');
            exit;
        }

        require_once __DIR__ . '/../models/Test.php';
        $test = Test::buscarPorId($id);

        if (!$test) {
            $_SESSION['mensaje'] = 'Test no encontrado';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: index.php?controller=Admin&action=tests');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_test = trim($_POST['nombre_test'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');

            // Validaciones
            $errores = [];
            if (empty($nombre_test)) $errores[] = 'El nombre del test es obligatorio';
            if (empty($descripcion)) $errores[] = 'La descripción es obligatoria';

            if (empty($errores)) {
                try {
                    $resultado = Test::actualizar($id, $nombre_test, $descripcion);
                    if ($resultado) {
                        $_SESSION['mensaje'] = 'Test actualizado exitosamente';
                        $_SESSION['tipo_mensaje'] = 'success';
                        header('Location: index.php?controller=Admin&action=tests');
                        exit;
                    } else {
                        $errores[] = 'Error al actualizar el test';
                    }
                } catch (Exception $e) {
                    $errores[] = 'Error al actualizar el test: ' . $e->getMessage();
                }
            }

            if (!empty($errores)) {
                $_SESSION['mensaje'] = implode(', ', $errores);
                $_SESSION['tipo_mensaje'] = 'danger';
            }
        }

        require_once __DIR__ . '/../views/admin/editar_test.php';
    }

    public function eliminarTest()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Admin&action=tests');
            exit;
        }

        require_once __DIR__ . '/../models/Test.php';
        
        try {
            $resultado = Test::eliminar($id);
            if ($resultado) {
                $_SESSION['mensaje'] = 'Test eliminado exitosamente';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = 'Error al eliminar el test';
                $_SESSION['tipo_mensaje'] = 'danger';
            }
        } catch (Exception $e) {
            $_SESSION['mensaje'] = $e->getMessage();
            $_SESSION['tipo_mensaje'] = 'danger';
        }

        header('Location: index.php?controller=Admin&action=tests');
        exit;
    }

    public function configuracion()
    {
        // Verificar que el usuario esté autenticado
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        // Tanto administradores como evaluadores pueden ver la configuración
        if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['administrador', 'evaluador'])) {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        // Si es POST, procesar la configuración
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->guardarConfiguracion();
            return;
        }

        // Obtener configuraciones actuales
        $configuraciones = $this->obtenerConfiguraciones();
        
        // Obtener estadísticas del sistema
        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/Test.php';
        require_once __DIR__ . '/../models/Evaluacion.php';
        require_once __DIR__ . '/../models/Usuario.php';
        
        $estadisticas = [
            'total_atletas' => Atleta::contar(),
            'total_tests' => Test::contar(),
            'total_evaluaciones' => Evaluacion::contar(),
            'total_usuarios' => Usuario::contar()
        ];

        require_once __DIR__ . '/../views/admin/configuracion.php';
    }

    private function obtenerConfiguraciones()
    {
        return [
            'sistema' => [
                'nombre_sistema' => APP_NAME,
                'zona_horaria' => date_default_timezone_get(),
                'version_php' => PHP_VERSION,
                'fecha_actual' => date('Y-m-d H:i:s T')
            ],
            'base_datos' => [
                'motor' => 'MySQL/MariaDB',
                'host' => $_ENV['DB_HOST'] ?? 'localhost',
                'puerto' => $_ENV['DB_PORT'] ?? '3306',
                'charset' => 'utf8mb4'
            ],
            'evaluaciones' => [
                'duracion_maxima' => '4 horas',
                'tests_simultaneos' => 'Ilimitados',
                'guardado_automatico' => 'Activado',
                'validacion_tiempo_real' => 'Activado'
            ],
            'atletas' => [
                'soft_delete' => 'Activado',
                'edicion_flexible' => 'Activado',
                'campos_obligatorios' => ['nombre', 'apellido', 'dni', 'sexo'],
                'campos_opcionales' => ['lugar_id', 'discapacidad_id', 'nacionalidad']
            ],
            'tests' => [
                'tipos_disponibles' => 'Antropometría, Fuerza, Resistencia, Flexibilidad, Velocidad',
                'campos_sin_tiempo' => ['Envergadura', 'Talla Sentado', 'Salto Vertical', 'Flexibilidad de Hombros', 'Sit and Reach'],
                'unidades_dinamicas' => 'Activado',
                'guardado_individual' => 'Activado'
            ],
            'seguridad' => [
                'sesiones' => 'PHP Sessions',
                'autenticacion' => 'Email + Contraseña',
                'roles' => ['administrador', 'evaluador'],
                'permisos_flexibles' => 'Activado'
            ]
        ];
    }

    private function guardarConfiguracion()
    {
        try {
            // Aquí se procesarían los cambios de configuración
            // Por ahora, solo mostrar mensaje de éxito
            $_SESSION['mensaje'] = 'Configuración actualizada exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } catch (Exception $e) {
            $_SESSION['mensaje'] = 'Error al actualizar la configuración: ' . $e->getMessage();
            $_SESSION['tipo_mensaje'] = 'danger';
        }

        header('Location: index.php?controller=Admin&action=configuracion');
        exit;
    }
}
