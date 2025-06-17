<?php

class Auth
{
    public static function check()
    {
        return isset($_SESSION['usuario_id']);
    }

    public static function userId()
    {
        return $_SESSION['usuario_id'] ?? null;
    }

    public static function rol()
    {
        return $_SESSION['rol'] ?? null;
    }

    public static function requireRol($rol)
    {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== $rol) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public static function logout()
    {
        session_destroy();
        header('Location: index.php?controller=Auth&action=login');
        exit;
    }
}
