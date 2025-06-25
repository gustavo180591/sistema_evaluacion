<?php

class Usuario
{
    public static function findByEmail($email)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function crear($datos)
    {
        global $pdo;
        
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password, rol, estado, fecha_registro, fecha_actualizacion) 
                              VALUES (:nombre, :apellido, :email, :password, :rol, :estado, NOW(), NOW())");
        
        $result = $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':apellido' => $datos['apellido'],
            ':email' => $datos['email'],
            ':password' => $datos['password'],
            ':rol' => $datos['rol'],
            ':estado' => $datos['estado']
        ]);
        
        return $result ? $pdo->lastInsertId() : false;
    }

    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}
