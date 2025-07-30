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

    public static function actualizar($id, $nombre_test, $descripcion)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE tests SET nombre_test = ?, descripcion = ? WHERE id = ?");
        return $stmt->execute([$nombre_test, $descripcion, $id]);
    }

    public static function eliminar($id)
    {
        global $pdo;
        try {
            $pdo->beginTransaction();
            
            // Verificar si hay resultados de tests asociados
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM resultados_tests WHERE test_id = ?");
            $stmt->execute([$id]);
            $tieneResultados = $stmt->fetchColumn() > 0;
            
            if ($tieneResultados) {
                throw new Exception('No se puede eliminar el test porque tiene resultados asociados');
            }
            
            // Eliminar el test
            $stmt = $pdo->prepare("DELETE FROM tests WHERE id = ?");
            $resultado = $stmt->execute([$id]);
            
            $pdo->commit();
            return $resultado;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function contar()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) FROM tests");
        return $stmt->fetchColumn();
    }
}
