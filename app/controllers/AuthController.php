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

            // Validar que las contraseñas coincidan
            if ($password !== $password_confirm) {
                $_SESSION['error'] = 'Las contraseñas no coinciden';
                header('Location: index.php?controller=Auth&action=register');
                exit;
            }

            require_once __DIR__ . '/../models/Evaluador.php';
            require_once __DIR__ . '/../models/Usuario.php';

            Usuario::crear($nombre, $apellido, $email, $password, 'evaluador');

            $_SESSION['success'] = 'Registro exitoso. Por favor, inicia sesión.';
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }

        require_once __DIR__ . '/../views/auth/register.php';
    }
}
