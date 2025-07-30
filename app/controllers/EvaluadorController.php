<?php

class EvaluadorController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function listado()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Evaluador.php';
        $evaluadores = Evaluador::todos();

        require_once __DIR__ . '/../views/evaluadores/listado.php';
    }

    public function crear()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Validaciones
            $errores = [];
            if (empty($nombre)) $errores[] = 'El nombre es obligatorio';
            if (empty($apellido)) $errores[] = 'El apellido es obligatorio';
            if (empty($email)) $errores[] = 'El email es obligatorio';
            if (empty($password)) $errores[] = 'La contraseña es obligatoria';
            if ($password !== $confirm_password) $errores[] = 'Las contraseñas no coinciden';
            if (strlen($password) < 6) $errores[] = 'La contraseña debe tener al menos 6 caracteres';

            if (empty($errores)) {
                require_once __DIR__ . '/../models/Evaluador.php';
                require_once __DIR__ . '/../models/Usuario.php';

                try {
                    // Verificar si el email ya existe
                    $evaluadorExistente = Evaluador::obtenerPorEmail($email);
                    if ($evaluadorExistente) {
                        $errores[] = 'El email ya está registrado';
                    } else {
                        $evaluadorId = Evaluador::crear($nombre, $apellido, $email, $password);
                        Usuario::crear([
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'email' => $email,
                            'password' => password_hash($password, PASSWORD_DEFAULT),
                            'rol' => 'evaluador',
                            'estado' => 'activo'
                        ]);

                        $_SESSION['mensaje'] = 'Evaluador creado con exito';
                        $_SESSION['tipo_mensaje'] = 'success';
                        header('Location: index.php?controller=Evaluador&action=listado');
                        exit;
                    }
                } catch (Exception $e) {
                    $errores[] = 'Error al crear el evaluador: ' . $e->getMessage();
                }
            }

            if (!empty($errores)) {
                $_SESSION['mensaje'] = implode(', ', $errores);
                $_SESSION['tipo_mensaje'] = 'danger';
            }
        }

        require_once __DIR__ . '/../views/evaluadores/crear.php';
    }

    public function editar()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Evaluador&action=listado');
            exit;
        }

        require_once __DIR__ . '/../models/Evaluador.php';
        $evaluador = Evaluador::buscarPorId($id);

        if (!$evaluador) {
            $_SESSION['mensaje'] = 'Evaluador no encontrado';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: index.php?controller=Evaluador&action=listado');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validaciones
            $errores = [];
            if (empty($nombre)) $errores[] = 'El nombre es obligatorio';
            if (empty($apellido)) $errores[] = 'El apellido es obligatorio';
            if (empty($email)) $errores[] = 'El email es obligatorio';

            if (empty($errores)) {
                try {
                    Evaluador::actualizar($id, $nombre, $apellido, $email, $password);
                    $_SESSION['mensaje'] = 'Evaluador actualizado exitosamente';
                    $_SESSION['tipo_mensaje'] = 'success';
                    header('Location: index.php?controller=Evaluador&action=listado');
                    exit;
                } catch (Exception $e) {
                    $errores[] = 'Error al actualizar el evaluador: ' . $e->getMessage();
                }
            }

            if (!empty($errores)) {
                $_SESSION['mensaje'] = implode(', ', $errores);
                $_SESSION['tipo_mensaje'] = 'danger';
            }
        }

        require_once __DIR__ . '/../views/evaluadores/editar.php';
    }

    public function eliminar()
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?controller=Evaluador&action=listado');
            exit;
        }

        require_once __DIR__ . '/../models/Evaluador.php';
        
        try {
            Evaluador::eliminar($id);
            $_SESSION['mensaje'] = 'Evaluador eliminado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } catch (Exception $e) {
            $_SESSION['mensaje'] = 'Error al eliminar el evaluador: ' . $e->getMessage();
            $_SESSION['tipo_mensaje'] = 'danger';
        }

        header('Location: index.php?controller=Evaluador&action=listado');
        exit;
    }
}
