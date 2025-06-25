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
        if ($_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Usuario.php';
        $usuarios = Usuario::todos();

        require_once __DIR__ . '/../views/admin/usuarios.php';
    }

    public function estadisticas()
    {
        if ($_SESSION['rol'] !== 'administrador') {
            header('Location: index.php?controller=Dashboard');
            exit;
        }

        require_once __DIR__ . '/../models/Atleta.php';
        require_once __DIR__ . '/../models/ResultadoTest.php';

        $cantidadAtletas = Atleta::contar();
        $cantidadResultados = ResultadoTest::contar();

        require_once __DIR__ . '/../views/admin/estadisticas.php';
    }


    public function nuevoUsuario()
    {
        if ($_SESSION['rol'] !== 'administrador') {
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
            if (empty($password)) $errores[] = 'La contraseña es obligatoria';
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
}
