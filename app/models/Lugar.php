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

    public static function actualizar($id, $nombre, $zona, $direccion)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE lugares SET nombre = ?, zona = ?, direccion = ? WHERE id = ?");
        return $stmt->execute([$nombre, $zona, $direccion, $id]);
    }

    public static function eliminar($id)
    {
        global $pdo;
        // Verificar si el lugar está siendo usado por algún atleta
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM atletas WHERE lugar_id = ?");
        $stmt->execute([$id]);
        $enUso = $stmt->fetchColumn();
        
        if ($enUso > 0) {
            return false; // No se puede eliminar si está en uso
        }
        
        $stmt = $pdo->prepare("DELETE FROM lugares WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function contar()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) FROM lugares");
        return $stmt->fetchColumn();
    }

    public static function verificarEnUso($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM atletas WHERE lugar_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }
}
