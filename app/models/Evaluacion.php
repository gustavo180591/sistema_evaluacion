<?php

class Evaluacion
{
    public static function crear($data)
    {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO evaluaciones (atleta_id, evaluador_id, fecha_evaluacion, hora_inicio, estado, observaciones, clima, temperatura_ambiente)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Convert empty string to null for decimal fields
        $temperatura = !empty($data['temperatura_ambiente']) ? (float)$data['temperatura_ambiente'] : null;

        $stmt->execute([
            $data['atleta_id'],
            $data['evaluador_id'],
            $data['fecha_evaluacion'],
            $data['hora_inicio'] ?? null,
            $data['estado'] ?? 'iniciada',
            $data['observaciones'] ?? null,
            $data['clima'] ?? null,
            $temperatura
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
        
        // Construir la query dinámicamente basándose en los datos proporcionados
        $campos_permitidos = ['hora_fin', 'estado', 'observaciones', 'clima', 'temperatura_ambiente', 'lugar_id'];
        $campos_actualizar = [];
        $valores = [];
        
        foreach ($data as $campo => $valor) {
            if (in_array($campo, $campos_permitidos)) {
                $campos_actualizar[] = "$campo = ?";
                $valores[] = $valor;
            }
        }
        
        if (empty($campos_actualizar)) {
            return false; // No hay campos válidos para actualizar
        }
        
        $sql = "UPDATE evaluaciones SET " . implode(', ', $campos_actualizar) . " WHERE id = ?";
        $valores[] = $id;
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($valores);
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
    
    public static function buscarEnProgreso($atleta_id, $evaluador_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM evaluaciones 
            WHERE atleta_id = ? AND evaluador_id = ? AND estado = 'iniciada'
            ORDER BY fecha_creacion DESC LIMIT 1");
        $stmt->execute([$atleta_id, $evaluador_id]);
        return $stmt->fetch();
    }
    
    public static function obtenerResultadosPorEvaluacion($evaluacion_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT rt.*, t.nombre_test, t.descripcion
            FROM resultados_tests rt
            JOIN tests t ON rt.test_id = t.id
            WHERE rt.evaluacion_id = ?
            ORDER BY rt.fecha_test ASC");
        $stmt->execute([$evaluacion_id]);
        return $stmt->fetchAll();
    }

    public static function todos()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT e.*, a.nombre, a.apellido, l.nombre AS lugar_nombre,
            COUNT(rt.id) as total_tests,
            ev.nombre AS evaluador_nombre, ev.apellido AS evaluador_apellido,
            ev.email AS evaluador_email
            FROM evaluaciones e
            JOIN atletas a ON e.atleta_id = a.id
            LEFT JOIN lugares l ON a.lugar_id = l.id
            LEFT JOIN resultados_tests rt ON e.id = rt.evaluacion_id
            LEFT JOIN evaluadores ev ON e.evaluador_id = ev.id
            GROUP BY e.id
            ORDER BY e.fecha_evaluacion DESC");
        return $stmt->fetchAll();
    }

    public static function contar()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) FROM evaluaciones");
        return $stmt->fetchColumn();
    }
} 