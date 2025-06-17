<?php

class Lugar
{
    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM lugares ORDER BY nombre");
        return $stmt->fetchAll();
    }

    public static function crear($nombre, $zona, $direccion)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO lugares (nombre, zona, direccion) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $zona, $direccion]);
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM lugares WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
