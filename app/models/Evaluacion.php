<?php

class Evaluacion
{
    public static function crear($data)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO evaluaciones (atleta_id, evaluador_id, fecha_evaluacion, hora_inicio, estado, observaciones, clima, temperatura_ambiente)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $data['atleta_id'],
            $data['evaluador_id'],
            $data['fecha_evaluacion'],
            $data['hora_inicio'] ?? null,
            $data['estado'] ?? 'iniciada',
            $data['observaciones'] ?? null,
            $data['clima'] ?? null,
            $data['temperatura_ambiente'] ?? null
        ]);

        return $pdo->lastInsertId();
    }

    public static function porEvaluador($evaluador_id)
    {
        global $pdo;
        try {
            $stmt = $pdo->prepare("SELECT e.*, a.nombre, a.apellido, 
                l.nombre as lugar_nombre,
                COUNT(rt.id) as total_tests,
                GROUP_CONCAT(t.nombre_test SEPARATOR ', ') as tests_realizados
                FROM evaluaciones e
                JOIN atletas a ON e.atleta_id = a.id
                JOIN lugares l ON a.lugar_id = l.id
                LEFT JOIN resultados_tests rt ON e.id = rt.evaluacion_id
                LEFT JOIN tests t ON rt.test_id = t.id
                WHERE e.evaluador_id = ?
                GROUP BY e.id
                ORDER BY e.fecha_evaluacion DESC, e.fecha_creacion DESC");
            $stmt->execute([$evaluador_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en Evaluacion::porEvaluador: " . $e->getMessage());
            return [];
        }
    }

    public static function porId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT e.*, a.nombre, a.apellido, l.nombre AS lugar_nombre
            FROM evaluaciones e
            JOIN atletas a ON e.atleta_id = a.id
            LEFT JOIN lugares l ON a.lugar_id = l.id
            WHERE e.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function actualizar($id, $data)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE evaluaciones SET 
            hora_fin = ?, estado = ?, observaciones = ?, clima = ?, temperatura_ambiente = ?
            WHERE id = ?");

        return $stmt->execute([
            $data['hora_fin'] ?? null,
            $data['estado'] ?? 'completada',
            $data['observaciones'] ?? null,
            $data['clima'] ?? null,
            $data['temperatura_ambiente'] ?? null,
            $id
        ]);
    }

    public static function obtenerResultados($evaluacion_id)
    {
        global $pdo;
        // Primero obtenemos la evaluación para saber el atleta_id
        $stmt = $pdo->prepare("SELECT atleta_id FROM evaluaciones WHERE id = ?");
        $stmt->execute([$evaluacion_id]);
        $evaluacion = $stmt->fetch();
        
        if (!$evaluacion) {
            return [];
        }
        
        // Luego obtenemos los resultados de tests para ese atleta
        $stmt = $pdo->prepare("SELECT rt.*, t.nombre_test, t.descripcion
            FROM resultados_tests rt
            JOIN tests t ON rt.test_id = t.id
            WHERE rt.atleta_id = ?
            ORDER BY rt.fecha_test ASC");
        $stmt->execute([$evaluacion['atleta_id']]);
        return $stmt->fetchAll();
    }

    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT e.*, a.nombre, a.apellido, l.nombre AS lugar_nombre,
            COUNT(rt.id) as total_tests
            FROM evaluaciones e
            JOIN atletas a ON e.atleta_id = a.id
            LEFT JOIN lugares l ON e.lugar_id = l.id
            LEFT JOIN resultados_tests rt ON e.id = rt.evaluacion_id
            GROUP BY e.id
            ORDER BY e.fecha_evaluacion DESC");
        return $stmt->fetchAll();
    }
} 