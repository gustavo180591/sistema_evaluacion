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

    public static function actualizar($id, $nombre, $apellido, $email, $password = null)
    {
        global $pdo;
        
        try {
            $pdo->beginTransaction();
            
            if ($password) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE evaluadores SET nombre = ?, apellido = ?, email = ?, password = ? WHERE id = ?");
                $stmt->execute([$nombre, $apellido, $email, $hash, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE evaluadores SET nombre = ?, apellido = ?, email = ? WHERE id = ?");
                $stmt->execute([$nombre, $apellido, $email, $id]);
            }
            
            // Actualizar también en la tabla usuarios
            $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ? WHERE email = (SELECT email FROM evaluadores WHERE id = ?)");
            $stmt->execute([$nombre, $apellido, $email, $id]);
            
            if ($password) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
                $stmt->execute([$hash, $email]);
            }
            
            $pdo->commit();
            return true;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function eliminar($id)
    {
        global $pdo;
        
        try {
            $pdo->beginTransaction();
            
            // Obtener el email del evaluador antes de eliminarlo
            $stmt = $pdo->prepare("SELECT email FROM evaluadores WHERE id = ?");
            $stmt->execute([$id]);
            $evaluador = $stmt->fetch();
            
            if (!$evaluador) {
                throw new Exception('Evaluador no encontrado');
            }
            
            // Eliminar de la tabla evaluadores
            $stmt = $pdo->prepare("DELETE FROM evaluadores WHERE id = ?");
            $stmt->execute([$id]);
            
            // Eliminar de la tabla usuarios
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE email = ? AND rol = 'evaluador'");
            $stmt->execute([$evaluador['email']]);
            
            $pdo->commit();
            return true;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
