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
}
