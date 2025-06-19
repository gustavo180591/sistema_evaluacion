<?php

class Atleta
{
    public static function todosPorEvaluador($evaluador_id)
    {
        global $pdo;
        // Obtener el lugar del evaluador primero
        $lugar_evaluador = self::obtenerLugarEvaluador($evaluador_id);
        
        if (!$lugar_evaluador) {
            // Si el evaluador no tiene lugar asignado, mostrar todos los atletas del evaluador
            $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre 
                FROM atletas a 
                LEFT JOIN lugares l ON a.lugar_id = l.id 
                WHERE a.evaluador_id = ? 
                ORDER BY a.apellido, a.nombre");
            $stmt->execute([$evaluador_id]);
            return $stmt->fetchAll();
        }
        
        // Solo mostrar atletas del mismo lugar que el evaluador
        $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre 
            FROM atletas a 
            LEFT JOIN lugares l ON a.lugar_id = l.id 
            WHERE a.lugar_id = ? 
            ORDER BY a.apellido, a.nombre");
        $stmt->execute([$lugar_evaluador]);
        return $stmt->fetchAll();
    }

    public static function obtenerLugarEvaluador($evaluador_id)
    {
        global $pdo;
        // En el seeder, los evaluadores están asociados a lugares por su ID
        // Evaluador 1 -> Lugar 1, Evaluador 2 -> Lugar 2, etc.
        // Pero deberíamos tener una tabla de relación más formal
        
        // Por ahora, basándonos en el seeder actual:
        $stmt = $pdo->prepare("SELECT id as lugar_id FROM lugares WHERE id = ?");
        $stmt->execute([$evaluador_id]);
        $result = $stmt->fetch();
        
        return $result ? $result['lugar_id'] : null;
    }

    public static function crear($evaluador_id, $data)
    {
        global $pdo;
        
        // Obtener el lugar del evaluador para asignarlo automáticamente al atleta
        $lugar_evaluador = self::obtenerLugarEvaluador($evaluador_id);
        
        $stmt = $pdo->prepare("INSERT INTO atletas (
            evaluador_id, nombre, apellido, dni, sexo, fecha_nacimiento,
            altura_cm, peso_kg, envergadura_cm, altura_sentado_cm,
            lateralidad_visual, lateralidad_podal, lugar_id, fecha_registro
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        return $stmt->execute([
            $evaluador_id,
            $data['nombre'],
            $data['apellido'],
            $data['dni'],
            $data['sexo'],
            $data['fecha_nacimiento'],
            $data['altura_cm'],
            $data['peso_kg'],
            $data['envergadura_cm'],
            $data['altura_sentado_cm'],
            $data['lateralidad_visual'],
            $data['lateralidad_podal'],
            $lugar_evaluador
        ]);
    }

    public static function actualizar($id, $data)
    {
        global $pdo;
        
        $stmt = $pdo->prepare("UPDATE atletas SET 
            nombre = ?, apellido = ?, dni = ?, sexo = ?, fecha_nacimiento = ?,
            altura_cm = ?, peso_kg = ?, envergadura_cm = ?, altura_sentado_cm = ?,
            lateralidad_visual = ?, lateralidad_podal = ?
            WHERE id = ?");

        return $stmt->execute([
            $data['nombre'],
            $data['apellido'],
            $data['dni'],
            $data['sexo'],
            $data['fecha_nacimiento'],
            $data['altura_cm'],
            $data['peso_kg'],
            $data['envergadura_cm'],
            $data['altura_sentado_cm'],
            $data['lateralidad_visual'],
            $data['lateralidad_podal'],
            $id
        ]);
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre 
            FROM atletas a 
            LEFT JOIN lugares l ON a.lugar_id = l.id 
            WHERE a.id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function contar()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM atletas");
        return $stmt->fetchColumn();
    }

    public static function verificarPertenenciaEvaluador($atleta_id, $evaluador_id)
    {
        global $pdo;
        $lugar_evaluador = self::obtenerLugarEvaluador($evaluador_id);
        
        if (!$lugar_evaluador) {
            // Si no hay lugar asignado, verificar por evaluador_id directamente
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM atletas WHERE id = ? AND evaluador_id = ?");
            $stmt->execute([$atleta_id, $evaluador_id]);
            return $stmt->fetchColumn() > 0;
        }
        
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM atletas WHERE id = ? AND lugar_id = ?");
        $stmt->execute([$atleta_id, $lugar_evaluador]);
        
        return $stmt->fetchColumn() > 0;
    }

    public static function eliminar($id)
    {
        global $pdo;
        
        try {
            // Iniciar transacción para asegurar consistencia
            $pdo->beginTransaction();
            
            // Eliminar todos los resultados de tests del atleta
            $stmt = $pdo->prepare("DELETE FROM resultados_tests WHERE atleta_id = ?");
            $stmt->execute([$id]);
            
            // Si existe tabla de evaluaciones, eliminar las evaluaciones del atleta
            $stmt = $pdo->prepare("SHOW TABLES LIKE 'evaluaciones'");
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt = $pdo->prepare("DELETE FROM evaluaciones WHERE atleta_id = ?");
                $stmt->execute([$id]);
            }
            
            // Finalmente, eliminar el atleta
            $stmt = $pdo->prepare("DELETE FROM atletas WHERE id = ?");
            $resultado = $stmt->execute([$id]);
            
            // Confirmar la transacción
            $pdo->commit();
            
            return $resultado && $stmt->rowCount() > 0;
            
        } catch (Exception $e) {
            // En caso de error, revertir la transacción
            $pdo->rollback();
            error_log("Error al eliminar atleta: " . $e->getMessage());
            return false;
        }
    }
}
