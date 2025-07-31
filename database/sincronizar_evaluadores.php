<?php
/**
 * Script para sincronizar usuarios con rol evaluador con la tabla evaluadores
 * Ejecutar desde línea de comandos: php sincronizar_evaluadores.php
 * O desde el navegador (no recomendado en producción)
 */

// Cargar configuración
require_once __DIR__ . '/../config/database.php';

echo "=== SINCRONIZACIÓN DE EVALUADORES ===\n\n";

try {
    // 1. Buscar usuarios con rol evaluador sin registro en tabla evaluadores
    $sql = "SELECT u.* FROM usuarios u 
            WHERE u.rol = 'evaluador' 
            AND NOT EXISTS (
                SELECT 1 FROM evaluadores e WHERE e.email = u.email
            )";
    
    $stmt = $pdo->query($sql);
    $usuariosSinEvaluador = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Usuarios evaluadores sin registro en tabla evaluadores: " . count($usuariosSinEvaluador) . "\n\n";
    
    if (count($usuariosSinEvaluador) > 0) {
        echo "Usuarios encontrados:\n";
        foreach ($usuariosSinEvaluador as $usuario) {
            echo "- {$usuario['nombre']} {$usuario['apellido']} ({$usuario['email']})\n";
        }
        echo "\n";
        
        // 2. Crear registros en tabla evaluadores
        $insertSql = "INSERT INTO evaluadores (nombre, apellido, email, password, fecha_alta) 
                      VALUES (:nombre, :apellido, :email, :password, :fecha_alta)";
        $insertStmt = $pdo->prepare($insertSql);
        
        $created = 0;
        foreach ($usuariosSinEvaluador as $usuario) {
            try {
                $insertStmt->execute([
                    ':nombre' => $usuario['nombre'],
                    ':apellido' => $usuario['apellido'],
                    ':email' => $usuario['email'],
                    ':password' => $usuario['password'],
                    ':fecha_alta' => $usuario['fecha_registro']
                ]);
                echo "✓ Creado evaluador para: {$usuario['email']}\n";
                $created++;
            } catch (Exception $e) {
                echo "✗ Error al crear evaluador para {$usuario['email']}: " . $e->getMessage() . "\n";
            }
        }
        
        echo "\nTotal evaluadores creados: $created\n";
    } else {
        echo "✓ Todos los usuarios evaluadores están sincronizados.\n";
    }
    
    // 3. Verificar integridad
    echo "\n=== VERIFICACIÓN DE INTEGRIDAD ===\n";
    
    // Contar usuarios evaluadores
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'evaluador'");
    $totalUsuariosEvaluadores = $stmt->fetchColumn();
    
    // Contar registros en tabla evaluadores
    $stmt = $pdo->query("SELECT COUNT(*) FROM evaluadores");
    $totalEvaluadores = $stmt->fetchColumn();
    
    echo "Total usuarios con rol evaluador: $totalUsuariosEvaluadores\n";
    echo "Total registros en tabla evaluadores: $totalEvaluadores\n";
    
    if ($totalUsuariosEvaluadores <= $totalEvaluadores) {
        echo "\n✓ SINCRONIZACIÓN COMPLETA: Todos los usuarios evaluadores tienen su registro correspondiente.\n";
    } else {
        echo "\n⚠ ADVERTENCIA: Aún hay discrepancias en los datos.\n";
    }
    
    // 4. Mostrar estado actual
    echo "\n=== ESTADO ACTUAL ===\n";
    $sql = "SELECT u.email, u.nombre, u.apellido, 
            CASE WHEN e.id IS NOT NULL THEN 'SÍ' ELSE 'NO' END as tiene_evaluador,
            e.id as evaluador_id
            FROM usuarios u
            LEFT JOIN evaluadores e ON u.email = e.email
            WHERE u.rol = 'evaluador'
            ORDER BY u.email";
    
    $stmt = $pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo sprintf("%-40s %-30s %-15s %-12s\n", "Email", "Nombre", "En Evaluadores", "ID Evaluador");
    echo str_repeat("-", 100) . "\n";
    
    foreach ($usuarios as $usuario) {
        echo sprintf("%-40s %-30s %-15s %-12s\n", 
            $usuario['email'],
            $usuario['nombre'] . ' ' . $usuario['apellido'],
            $usuario['tiene_evaluador'],
            $usuario['evaluador_id'] ?: 'N/A'
        );
    }
    
} catch (Exception $e) {
    echo "ERROR FATAL: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== FIN DEL SCRIPT ===\n";
?>