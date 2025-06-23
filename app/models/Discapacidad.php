<?php

class Discapacidad
{
    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM discapacidades ORDER BY nombre");
        return $stmt->fetchAll();
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM discapacidades WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function crear($nombre, $descripcion, $tipo)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO discapacidades (nombre, descripcion, tipo) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $descripcion, $tipo]);
        return $pdo->lastInsertId();
    }

    public static function actualizar($id, $nombre, $descripcion, $tipo)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE discapacidades SET nombre = ?, descripcion = ?, tipo = ? WHERE id = ?");
        return $stmt->execute([$nombre, $descripcion, $tipo, $id]);
    }

    public static function eliminar($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM discapacidades WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
