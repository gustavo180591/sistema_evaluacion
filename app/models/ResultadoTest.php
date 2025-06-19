<?php

class ResultadoTest
{
    public static function crear($data)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO resultados_tests (atleta_id, evaluador_id, test_id, lugar_id, fecha_test, resultado_json, evaluacion_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        return $stmt->execute([
            $data['atleta_id'],
            $data['evaluador_id'],
            $data['test_id'],
            $data['lugar_id'],
            $data['fecha_test'],
            json_encode($data['resultado']),
            $data['evaluacion_id'] ?? null
        ]);
    }

    public static function porAtleta($atleta_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT r.*, t.nombre_test, l.nombre AS lugar,
            e.fecha_evaluacion, e.estado as estado_evaluacion
            FROM resultados_tests r
            JOIN tests t ON r.test_id = t.id
            JOIN lugares l ON r.lugar_id = l.id
            LEFT JOIN evaluaciones e ON r.evaluacion_id = e.id
            WHERE r.atleta_id = ?
            ORDER BY r.fecha_test DESC");
        $stmt->execute([$atleta_id]);
        return $stmt->fetchAll();
    }

    public static function porEvaluador($evaluador_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT r.*, a.nombre, a.apellido, t.nombre_test,
            e.fecha_evaluacion, e.estado as estado_evaluacion
            FROM resultados_tests r
            JOIN atletas a ON r.atleta_id = a.id
            JOIN tests t ON r.test_id = t.id
            LEFT JOIN evaluaciones e ON r.evaluacion_id = e.id
            WHERE r.evaluador_id = ?
            ORDER BY r.fecha_test DESC");
        $stmt->execute([$evaluador_id]);
        return $stmt->fetchAll();
    }

    public static function porEvaluacion($evaluacion_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT r.*, t.nombre_test, t.formato_test
            FROM resultados_tests r
            JOIN tests t ON r.test_id = t.id
            WHERE r.evaluacion_id = ?
            ORDER BY r.fecha_test ASC");
        $stmt->execute([$evaluacion_id]);
        return $stmt->fetchAll();
    }

    public static function contar()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM resultados_tests");
        return $stmt->fetchColumn();
    }
}
