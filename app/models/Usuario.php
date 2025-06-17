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

    public static function crear($rol, $referencia_id, $email, $password)
    {
        global $pdo;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (rol, referencia_id, email, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$rol, $referencia_id, $email, $hash]);
    }

    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}
