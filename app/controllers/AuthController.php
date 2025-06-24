<?php

class AuthController
{
    public function login()
    {
        // Si ya hay sesión activa, redirigir al dashboard
        if (isset($_SESSION['usuario_id']) && isset($_SESSION['rol'])) {
            header('Location: index.php?controller=Dashboard&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            require_once __DIR__ . '/../models/Usuario.php';
            $usuario = Usuario::findByEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['rol'] = $usuario['rol'];
                $_SESSION['email'] = $usuario['email'];
                if ($_SESSION['rol'] === 'evaluador') {
                    require_once __DIR__ . '/../models/Evaluador.php';
                    $evaluador = Evaluador::obtenerPorEmail($usuario['email']);
                    if ($evaluador) {
                        $_SESSION['evaluador_id'] = $evaluador['id'];
                    }
                }
                header('Location: index.php?controller=Dashboard&action=index');
                exit;
            } else {
                $_SESSION['error'] = 'Credenciales inválidas';
                header('Location: index.php?controller=Auth&action=login');
                exit;
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?controller=Auth&action=login');
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            // Validar campos requeridos
            if (empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($password_confirm)) {
                $_SESSION['error'] = 'Todos los campos son requeridos';
                header('Location: index.php?controller=Auth&action=register');
                exit;
            }

            // Validar formato de email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Formato de email inválido';
                header('Location: index.php?controller=Auth&action=register');
                exit;
            }

            // Validar que las contraseñas coincidan
            if ($password !== $password_confirm) {
                $_SESSION['error'] = 'Las contraseñas no coinciden';
                header('Location: index.php?controller=Auth&action=register');
                exit;
            }

            require_once __DIR__ . '/../models/Usuario.php';
            require_once __DIR__ . '/../models/Evaluador.php';

            try {
                global $pdo;
                
                // Verificar si el email ya existe en usuarios
                $usuario = Usuario::findByEmail($email);
                if ($usuario) {
                    throw new Exception('El email ya está registrado en el sistema');
                }

                // Verificar si el email ya existe en evaluadores
                $evaluador = Evaluador::obtenerPorEmail($email);
                if ($evaluador) {
                    throw new Exception('El email ya está registrado como evaluador');
                }

                // Iniciar transacción
                $pdo->beginTransaction();

                // Crear usuario
                Usuario::crear($nombre, $apellido, $email, $password, 'evaluador');
                
                // Crear evaluador
                Evaluador::crear($nombre, $apellido, $email, $password);
                
                // Confirmar transacción
                $pdo->commit();

                $_SESSION['success'] = 'Registro exitoso. Por favor, inicia sesión.';
                header('Location: index.php?controller=Auth&action=login');
                exit;

            } catch (Exception $e) {
                // Revertir transacción si hay error
                if (isset($pdo) && $pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                
                $_SESSION['error'] = $e->getMessage();
                header('Location: index.php?controller=Auth&action=register');
                exit;
            }
        }

        require_once __DIR__ . '/../views/auth/register.php';
    }
}
