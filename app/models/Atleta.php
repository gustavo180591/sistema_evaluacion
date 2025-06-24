<?php

class Atleta
{
    public static function todosPorEvaluador($usuario_id)
    {
        global $pdo;
        
        // Primero necesitamos obtener el evaluador_id desde el usuario_id
        // ya que la sesión puede tener usuario_id pero necesitamos evaluador_id
        $stmt = $pdo->prepare("SELECT e.id as evaluador_id FROM evaluadores e 
                               JOIN usuarios u ON e.email = u.email 
                               WHERE u.id = ? LIMIT 1");
        $stmt->execute([$usuario_id]);
        $evaluador = $stmt->fetch();
        
        if (!$evaluador) {
            return []; // Si no encuentra el evaluador, retorna array vacío
        }
        
        $evaluador_id = $evaluador['evaluador_id'];
        
        // Obtener todos los atletas de este evaluador
        $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre 
            FROM atletas a 
            LEFT JOIN lugares l ON a.lugar_id = l.id 
            WHERE a.evaluador_id = ? 
            ORDER BY a.apellido, a.nombre");
        $stmt->execute([$evaluador_id]);
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
        
        // Por ahora asignamos lugar_id = 1 por defecto
        // En el futuro se puede mejorar para que el evaluador tenga un lugar asignado
        $lugar_id = 1;
        
        $stmt = $pdo->prepare("INSERT INTO atletas (
            evaluador_id, lugar_id, nombre, apellido, dni, sexo, fecha_nacimiento,
            altura_cm, peso_kg, envergadura_cm, altura_sentado_cm,
            lateralidad_visual, lateralidad_podal, discapacidad_id, fecha_registro
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        return $stmt->execute([
            $evaluador_id,
            $lugar_id,
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
            $data['discapacidad_id']
        ]);
    }

    public static function actualizar($id, $data)
    {
        global $pdo;
        
        $stmt = $pdo->prepare("UPDATE atletas SET 
            evaluador_id = ?, lugar_id = ?, nombre = ?, apellido = ?, dni = ?, sexo = ?, 
            fecha_nacimiento = ?, altura_cm = ?, peso_kg = ?, envergadura_cm = ?, 
            altura_sentado_cm = ?, lateralidad_visual = ?, lateralidad_podal = ?,
            discapacidad_id = ?
            WHERE id = ?");

        return $stmt->execute([
            $data['evaluador_id'],
            $data['lugar_id'],
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
            $data['discapacidad_id'],
            $id
        ]);
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre, d.nombre as discapacidad_nombre, d.tipo as discapacidad_tipo 
            FROM atletas a 
            LEFT JOIN lugares l ON a.lugar_id = l.id 
            LEFT JOIN discapacidades d ON a.discapacidad_id = d.id 
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

    public static function verificarPertenenciaEvaluador($atleta_id, $usuario_id)
    {
        global $pdo;
        
        // Obtener el evaluador_id desde el usuario_id
        $stmt = $pdo->prepare("SELECT e.id as evaluador_id FROM evaluadores e 
                               JOIN usuarios u ON e.email = u.email 
                               WHERE u.id = ? LIMIT 1");
        $stmt->execute([$usuario_id]);
        $evaluador = $stmt->fetch();
        
        if (!$evaluador) {
            return false;
        }
        
        $evaluador_id = $evaluador['evaluador_id'];
        
        // Verificar que el atleta pertenezca a este evaluador
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM atletas WHERE id = ? AND evaluador_id = ?");
        $stmt->execute([$atleta_id, $evaluador_id]);
        
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
