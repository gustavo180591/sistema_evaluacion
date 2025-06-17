<?php

class Test
{
    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM tests ORDER BY nombre_test");
        return $stmt->fetchAll();
    }

    public static function crear($nombre_test, $descripcion)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO tests (nombre_test, descripcion) VALUES (?, ?)");
        return $stmt->execute([$nombre_test, $descripcion]);
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM tests WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
