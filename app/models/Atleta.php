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
        
        // Verificar si el campo activo existe
        $checkStmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
        $campoActivoExiste = $checkStmt->rowCount() > 0;
        
        if ($campoActivoExiste) {
            // Obtener todos los atletas activos de este evaluador
            $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre 
                FROM atletas a 
                LEFT JOIN lugares l ON a.lugar_id = l.id 
                WHERE a.evaluador_id = ? AND a.activo = TRUE
                ORDER BY a.apellido, a.nombre");
        } else {
            // Si no existe el campo activo, obtener todos los atletas de este evaluador
            $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre 
                FROM atletas a 
                LEFT JOIN lugares l ON a.lugar_id = l.id 
                WHERE a.evaluador_id = ?
                ORDER BY a.apellido, a.nombre");
        }
        
        $stmt->execute([$evaluador_id]);
        return $stmt->fetchAll();
    }

    public static function todos()
    {
        global $pdo;
        
        // Verificar si el campo activo existe
        $stmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
        $campoActivoExiste = $stmt->rowCount() > 0;
        
        if ($campoActivoExiste) {
            // Obtener todos los atletas activos del sistema con información del evaluador y lugar
            $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre, 
                                         CONCAT(e.nombre, ' ', e.apellido) as evaluador_nombre,
                                         e.email as evaluador_email
                                  FROM atletas a 
                                  LEFT JOIN lugares l ON a.lugar_id = l.id 
                                  LEFT JOIN evaluadores e ON a.evaluador_id = e.id
                                  WHERE a.activo = TRUE
                                  ORDER BY a.apellido, a.nombre");
        } else {
            // Si no existe el campo activo, obtener todos los atletas
            $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre, 
                                         CONCAT(e.nombre, ' ', e.apellido) as evaluador_nombre,
                                         e.email as evaluador_email
                                  FROM atletas a 
                                  LEFT JOIN lugares l ON a.lugar_id = l.id 
                                  LEFT JOIN evaluadores e ON a.evaluador_id = e.id
                                  ORDER BY a.apellido, a.nombre");
        }
        
        $stmt->execute();
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
        
        // Usar lugar_id del formulario o 1 por defecto
        $lugar_id = $data['lugar_id'] ?? 1;
        
        // Convertir sexo al formato de BD
        $sexo = $data['sexo'] ?? '';
        if (strtolower($sexo) === 'masculino') {
            $sexo = 'M';
        } elseif (strtolower($sexo) === 'femenino') {
            $sexo = 'F';
        }
        
        // Verificar si el campo activo existe
        $checkStmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
        $campoActivoExiste = $checkStmt->rowCount() > 0;
        
        // Campos básicos que siempre estarán presentes
        $campos_basicos = [
            'evaluador_id', 'lugar_id', 'nombre', 'apellido', 'dni', 'sexo',
            'edad', 'nacionalidad', 'altura', 'peso', 
            'lateralidad_visual', 'lateralidad_podal', 'fecha_registro'
        ];
        
        $valores_basicos = [
            $evaluador_id,
            $lugar_id,
            $data['nombre'],
            $data['apellido'],
            $data['dni'],
            $sexo,
            $data['edad'],
            $data['nacionalidad'] ?? null,
            $data['altura'],
            $data['peso'],
            $data['lateralidad_visual'],
            $data['lateralidad_podal'],
            'NOW()'
        ];
        
        // Agregar discapacidad_id si está presente
        if (isset($data['discapacidad_id']) && !empty($data['discapacidad_id'])) {
            $campos_basicos[] = 'discapacidad_id';
            $valores_basicos[] = $data['discapacidad_id'];
        }
        
        // Agregar campo activo si existe
        if ($campoActivoExiste) {
            $campos_basicos[] = 'activo';
            $valores_basicos[] = true;
        }
        
        // Construir la query
        $placeholders = str_repeat('?,', count($valores_basicos) - 1) . 'NOW()';
        $valores_execute = array_slice($valores_basicos, 0, -1); // Remover 'NOW()' para execute
        
        $sql = "INSERT INTO atletas (" . implode(', ', $campos_basicos) . ") VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute($valores_execute);
    }

    public static function actualizar($id, $data)
    {
        global $pdo;
        
        // Mapear los campos del formulario a los campos de la base de datos
        $campos = [];
        $valores = [];
        
        // Campos opcionales que pueden o no estar presentes
        $camposPermitidos = [
            'evaluador_id' => 'evaluador_id',
            'lugar_id' => 'lugar_id', 
            'nombre' => 'nombre',
            'apellido' => 'apellido',
            'dni' => 'dni',
            'sexo' => 'sexo',
            'edad' => 'edad',
            'nacionalidad' => 'nacionalidad',
            'altura' => 'altura', // Mapear altura a altura (no altura_cm)
            'peso' => 'peso', // Mapear peso a peso (no peso_kg)
            'lateralidad_visual' => 'lateralidad_visual',
            'lateralidad_podal' => 'lateralidad_podal',
            'discapacidad_id' => 'discapacidad_id'
        ];
        
        // Construir la query dinámicamente solo con los campos presentes
        foreach ($camposPermitidos as $campoFormulario => $campoBD) {
            if (isset($data[$campoFormulario])) {
                $campos[] = "$campoBD = ?";
                
                // Conversión especial para el campo sexo
                if ($campoFormulario === 'sexo') {
                    // Convertir formato completo a formato de BD si es necesario
                    $sexo = strtolower($data[$campoFormulario]);
                    if ($sexo === 'masculino') {
                        $valores[] = 'M';
                    } elseif ($sexo === 'femenino') {
                        $valores[] = 'F';
                    } else {
                        $valores[] = $data[$campoFormulario];
                    }
                } else {
                    $valores[] = $data[$campoFormulario];
                }
            }
        }
        
        if (empty($campos)) {
            return false; // No hay campos para actualizar
        }
        
        $sql = "UPDATE atletas SET " . implode(', ', $campos) . " WHERE id = ?";
        $valores[] = $id;
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($valores);
    }

    public static function buscarPorId($id)
    {
        global $pdo;
        
        // Verificar si el campo activo existe
        $checkStmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
        $campoActivoExiste = $checkStmt->rowCount() > 0;
        
        if ($campoActivoExiste) {
            // Para evaluaciones, permitir buscar atletas activos e inactivos
            $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre, d.nombre as discapacidad_nombre, d.tipo as discapacidad_tipo 
                FROM atletas a 
                LEFT JOIN lugares l ON a.lugar_id = l.id 
                LEFT JOIN discapacidades d ON a.discapacidad_id = d.id 
                WHERE a.id = ? LIMIT 1");
        } else {
            $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre, d.nombre as discapacidad_nombre, d.tipo as discapacidad_tipo 
                FROM atletas a 
                LEFT JOIN lugares l ON a.lugar_id = l.id 
                LEFT JOIN discapacidades d ON a.discapacidad_id = d.id 
                WHERE a.id = ? LIMIT 1");
        }
        
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function contar()
    {
        global $pdo;
        
        // Verificar si el campo activo existe
        $checkStmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
        $campoActivoExiste = $checkStmt->rowCount() > 0;
        
        if ($campoActivoExiste) {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM atletas WHERE activo = TRUE");
        } else {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM atletas");
        }
        
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

    public static function ocultar($id)
    {
        global $pdo;
        
        try {
            // Verificar si el campo activo existe
            $checkStmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
            $campoActivoExiste = $checkStmt->rowCount() > 0;
            
            if ($campoActivoExiste) {
                // Marcar el atleta como inactivo (eliminación suave)
                $stmt = $pdo->prepare("UPDATE atletas SET activo = FALSE WHERE id = ?");
                $resultado = $stmt->execute([$id]);
                
                return $resultado && $stmt->rowCount() > 0;
            } else {
                // Si no existe el campo activo, no hacer nada por ahora
                error_log("Intento de ocultar atleta pero el campo 'activo' no existe. Ejecute la migración primero.");
                return false;
            }
            
        } catch (Exception $e) {
            error_log("Error al ocultar atleta: " . $e->getMessage());
            return false;
        }
    }

    // Método para restaurar un atleta oculto (por si acaso se necesita)
    public static function restaurar($id)
    {
        global $pdo;
        
        try {
            // Verificar si el campo activo existe
            $checkStmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
            $campoActivoExiste = $checkStmt->rowCount() > 0;
            
            if ($campoActivoExiste) {
                $stmt = $pdo->prepare("UPDATE atletas SET activo = TRUE WHERE id = ?");
                $resultado = $stmt->execute([$id]);
                
                return $resultado && $stmt->rowCount() > 0;
            } else {
                error_log("Intento de restaurar atleta pero el campo 'activo' no existe. Ejecute la migración primero.");
                return false;
            }
            
        } catch (Exception $e) {
            error_log("Error al restaurar atleta: " . $e->getMessage());
            return false;
        }
    }

    // Método para obtener atletas ocultos (para administradores)
    public static function obtenerOcultos()
    {
        global $pdo;
        
        // Verificar si el campo activo existe
        $checkStmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
        $campoActivoExiste = $checkStmt->rowCount() > 0;
        
        if ($campoActivoExiste) {
            $stmt = $pdo->prepare("SELECT a.*, l.nombre as lugar_nombre, 
                                         CONCAT(e.nombre, ' ', e.apellido) as evaluador_nombre,
                                         e.email as evaluador_email
                                  FROM atletas a 
                                  LEFT JOIN lugares l ON a.lugar_id = l.id 
                                  LEFT JOIN evaluadores e ON a.evaluador_id = e.id
                                  WHERE a.activo = FALSE
                                  ORDER BY a.apellido, a.nombre");
            $stmt->execute();
            return $stmt->fetchAll();
        } else {
            // Si no existe el campo activo, retornar array vacío
            return [];
        }
    }
}
