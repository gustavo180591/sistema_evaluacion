<?php

class Evaluador
{
    /**
     * Obtiene un evaluador por email, creándolo automáticamente si no existe
     * pero el usuario sí existe con rol evaluador
     */
    public static function obtenerPorEmail($email)
    {
        global $pdo;
        
        // Primero buscar en la tabla evaluadores
        $stmt = $pdo->prepare("SELECT * FROM evaluadores WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $evaluador = $stmt->fetch();
        
        // Si no existe, verificar si hay un usuario con ese email y rol evaluador
        if (!$evaluador) {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND rol = 'evaluador' LIMIT 1");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch();
            
            // Si existe el usuario evaluador, crear automáticamente el registro en evaluadores
            if ($usuario) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO evaluadores (nombre, apellido, email, password, fecha_alta) 
                                          VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $usuario['nombre'],
                        $usuario['apellido'],
                        $usuario['email'],
                        $usuario['password'],
                        $usuario['fecha_registro']
                    ]);
                    
                    // Obtener el registro recién creado
                    $evaluadorId = $pdo->lastInsertId();
                    $stmt = $pdo->prepare("SELECT * FROM evaluadores WHERE id = ? LIMIT 1");
                    $stmt->execute([$evaluadorId]);
                    $evaluador = $stmt->fetch();
                    
                    error_log("Evaluador creado automáticamente para: " . $email);
                } catch (Exception $e) {
                    error_log("Error al crear evaluador automáticamente: " . $e->getMessage());
                    return false;
                }
            }
        }
        
        return $evaluador;
    }
    
    public static function crear($nombre, $apellido, $email, $password)
    {
        global $pdo;
        
        $stmt = $pdo->prepare("INSERT INTO evaluadores (nombre, apellido, email, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $apellido, $email, $password]);
    }
    
    public static function verificarEvaluador($usuario_id)
    {
        global $pdo;
        
        // Verificar que el usuario existe y es evaluador
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE id = ? AND rol = 'evaluador'");
        $stmt->execute([$usuario_id]);
        
        if ($stmt->fetchColumn() == 0) {
            return false;
        }
        
        // Obtener el email del usuario
        $stmt = $pdo->prepare("SELECT email FROM usuarios WHERE id = ?");
        $stmt->execute([$usuario_id]);
        $usuario = $stmt->fetch();
        
        if (!$usuario) {
            return false;
        }
        
        // Verificar que existe en la tabla evaluadores (o crearlo si no existe)
        $evaluador = self::obtenerPorEmail($usuario['email']);
        
        return $evaluador !== false;
    }
    
    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM evaluadores ORDER BY apellido, nombre");
        return $stmt->fetchAll();
    }
    
    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM evaluadores WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public static function actualizar($id, $nombre, $apellido, $email)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE evaluadores SET nombre = ?, apellido = ?, email = ? WHERE id = ?");
        return $stmt->execute([$nombre, $apellido, $email, $id]);
    }
    
    public static function eliminar($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM evaluadores WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>