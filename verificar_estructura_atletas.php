<?php
require_once 'config/database.php';

try {
    global $pdo;
    
    // Verificar estructura de la tabla atletas
    $stmt = $pdo->query("DESCRIBE atletas");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "=== ESTRUCTURA DE LA TABLA ATLETAS ===\n";
    foreach ($columns as $column) {
        echo "Campo: {$column['Field']} - Tipo: {$column['Type']} - Null: {$column['Null']} - Default: {$column['Default']}\n";
    }
    
    echo "\n=== EJEMPLO DE DATOS ===\n";
    $stmt = $pdo->query("SELECT * FROM atletas LIMIT 1");
    $example = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($example) {
        foreach ($example as $field => $value) {
            echo "$field: $value\n";
        }
    } else {
        echo "No hay datos en la tabla\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 