<?php

class Evaluador
{
    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM evaluadores ORDER BY apellido, nombre");
        return $stmt->fetchAll();
    }

    public static function crear($nombre, $apellido, $email, $password)
    {
        global $pdo;
        
        // Verificar si el email ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM evaluadores WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("El email ya está registrado");
        }
        
        // Verificar si el email ya existe en usuarios
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("El email ya está registrado en el sistema");
        }
        
        $stmt = $pdo->prepare("INSERT INTO evaluadores (nombre, apellido, email, password, fecha_alta) VALUES (?, ?, ?, ?, NOW())");
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$nombre, $apellido, $email, $hash]);
        return $pdo->lastInsertId();
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM evaluadores WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function obtenerPorEmail($email)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM evaluadores WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function verificarEvaluador($usuario_id)
    {
        global $pdo;
        try {
            // Primero verificar que el usuario existe y es evaluador
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE id = ? AND rol = 'evaluador' LIMIT 1");
            $stmt->execute([$usuario_id]);
            $esEvaluador = $stmt->fetchColumn() > 0;
            
            if (!$esEvaluador) {
                return false;
            }
            
            // Obtener el email del usuario
            $stmt = $pdo->prepare("SELECT email FROM usuarios WHERE id = ? LIMIT 1");
            $stmt->execute([$usuario_id]);
            $usuario = $stmt->fetch();
            
            if (!$usuario) {
                return false;
            }
            
            // Verificar si existe un evaluador con ese email
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM evaluadores WHERE email = ? LIMIT 1");
            $stmt->execute([$usuario['email']]);
            return $stmt->fetchColumn() > 0;
            
        } catch (Exception $e) {
            error_log("Error verificando evaluador: " . $e->getMessage());
            return false;
        }
    }
}
