<?php

class ResultadoTest
{
    public static function crear($data)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO resultados_tests 
            (evaluacion_id, atleta_id, test_id, evaluador_id, fecha_test, resultado_json, observaciones, lugar_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        return $stmt->execute([
            $data['evaluacion_id'],
            $data['atleta_id'],
            $data['test_id'],
            $data['evaluador_id'],
            $data['fecha_test'],
            $data['resultado_json'],
            $data['observaciones'] ?? null,
            $data['lugar_id'] ?? null
        ]);
    }

    public static function porAtleta($atleta_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT r.*, t.nombre_test, t.descripcion, l.nombre AS lugar, 
                                     CONCAT(u.nombre, ' ', u.apellido) AS evaluador_nombre
            FROM resultados_tests r
            JOIN tests t ON r.test_id = t.id
            JOIN lugares l ON r.lugar_id = l.id
            LEFT JOIN usuarios u ON r.evaluador_id = u.id
            WHERE r.atleta_id = ?
            ORDER BY r.fecha_test DESC");
        $stmt->execute([$atleta_id]);
        return $stmt->fetchAll();
    }

    public static function porEvaluador($evaluador_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT r.*, a.nombre, a.apellido, t.nombre_test
            FROM resultados_tests r
            JOIN atletas a ON r.atleta_id = a.id
            JOIN tests t ON r.test_id = t.id
            WHERE r.evaluador_id = ?
            ORDER BY r.fecha_test DESC");
        $stmt->execute([$evaluador_id]);
        return $stmt->fetchAll();
    }

    public static function porEvaluacion($evaluacion_id)
    {
        // No implementado porque la tabla resultados_tests no tiene evaluacion_id
        throw new Exception('No implementado: la tabla resultados_tests no tiene evaluacion_id');
    }

    public static function contar()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM resultados_tests");
        return $stmt->fetchColumn();
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT r.*, t.nombre_test, t.descripcion, l.nombre AS lugar, 
                                     CONCAT(u.nombre, ' ', u.apellido) AS evaluador_nombre,
                                     CONCAT(a.nombre, ' ', a.apellido) AS atleta_nombre
            FROM resultados_tests r
            JOIN tests t ON r.test_id = t.id
            JOIN lugares l ON r.lugar_id = l.id
            LEFT JOIN usuarios u ON r.evaluador_id = u.id
            JOIN atletas a ON r.atleta_id = a.id
            WHERE r.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public static function buscarPorTestYEvaluacion($test_id, $evaluacion_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM resultados_tests 
            WHERE test_id = ? AND evaluacion_id = ?");
        $stmt->execute([$test_id, $evaluacion_id]);
        return $stmt->fetch();
    }
    
    public static function actualizar($id, $data)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE resultados_tests SET 
            resultado_json = ?, observaciones = ?, fecha_test = ?
            WHERE id = ?");
        
        return $stmt->execute([
            $data['resultado_json'],
            $data['observaciones'] ?? null,
            $data['fecha_test'],
            $id
        ]);
    }
}
