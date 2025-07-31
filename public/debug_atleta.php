<?php
// Script de diagnóstico para problemas de creación de atletas
session_start();

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carga la configuración general
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

echo "<h1>Diagnóstico de Creación de Atletas</h1>";
echo "<pre>";

// 1. Verificar sesión
echo "=== SESIÓN ===\n";
echo "usuario_id: " . ($_SESSION['usuario_id'] ?? 'NO EXISTE') . "\n";
echo "rol: " . ($_SESSION['rol'] ?? 'NO EXISTE') . "\n";
echo "evaluador_id: " . ($_SESSION['evaluador_id'] ?? 'NO EXISTE') . "\n";
echo "\n";

// 2. Verificar evaluador
if (isset($_SESSION['usuario_id'])) {
    echo "=== EVALUADOR ===\n";
    try {
        $stmt = $pdo->prepare("SELECT email FROM usuarios WHERE id = ? LIMIT 1");
        $stmt->execute([$_SESSION['usuario_id']]);
        $user = $stmt->fetch();
        echo "Email del usuario: " . ($user ? $user['email'] : 'NO ENCONTRADO') . "\n";
        
        if ($user) {
            $stmt = $pdo->prepare("SELECT * FROM evaluadores WHERE email = ? LIMIT 1");
            $stmt->execute([$user['email']]);
            $evaluador = $stmt->fetch();
            echo "Evaluador encontrado: " . ($evaluador ? 'SÍ (ID: ' . $evaluador['id'] . ')' : 'NO') . "\n";
            
            if ($evaluador && !isset($_SESSION['evaluador_id'])) {
                $_SESSION['evaluador_id'] = $evaluador['id'];
                echo "evaluador_id añadido a la sesión\n";
            }
        }
    } catch (Exception $e) {
        echo "Error al buscar evaluador: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// 3. Verificar estructura de la tabla atletas
echo "=== ESTRUCTURA TABLA ATLETAS ===\n";
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM atletas");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo sprintf("%-20s %-20s %s\n", $col['Field'], $col['Type'], $col['Null'] === 'YES' ? 'NULL' : 'NOT NULL');
    }
} catch (Exception $e) {
    echo "Error al obtener estructura: " . $e->getMessage() . "\n";
}
echo "\n";

// 4. Test de inserción
if (isset($_POST['test_insert'])) {
    echo "=== TEST DE INSERCIÓN ===\n";
    try {
        $test_data = [
            'nombre' => 'Test',
            'apellido' => 'Atleta',
            'dni' => '99999999',
            'sexo' => 'M',
            'fecha_nacimiento' => '2000-01-01',
            'evaluador_id' => $_SESSION['evaluador_id'] ?? 1,
            'lugar_id' => 1
        ];
        
        echo "Datos de prueba:\n";
        print_r($test_data);
        
        $sql = "INSERT INTO atletas (evaluador_id, lugar_id, nombre, apellido, dni, sexo, fecha_nacimiento) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        echo "\nSQL: $sql\n";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            $test_data['evaluador_id'],
            $test_data['lugar_id'],
            $test_data['nombre'],
            $test_data['apellido'],
            $test_data['dni'],
            $test_data['sexo'],
            $test_data['fecha_nacimiento']
        ]);
        
        if ($result) {
            echo "INSERCIÓN EXITOSA - ID: " . $pdo->lastInsertId() . "\n";
            
            // Eliminar el registro de prueba
            $pdo->exec("DELETE FROM atletas WHERE dni = '99999999'");
            echo "Registro de prueba eliminado\n";
        } else {
            echo "INSERCIÓN FALLIDA\n";
            $errorInfo = $stmt->errorInfo();
            echo "Error SQL: " . print_r($errorInfo, true) . "\n";
        }
    } catch (Exception $e) {
        echo "EXCEPCIÓN: " . $e->getMessage() . "\n";
        echo "Trace:\n" . $e->getTraceAsString() . "\n";
    }
    echo "\n";
}

// 5. Verificar configuración de PHP
echo "=== CONFIGURACIÓN PHP ===\n";
echo "max_execution_time: " . ini_get('max_execution_time') . "\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "session.save_path: " . ini_get('session.save_path') . "\n";
echo "session.gc_maxlifetime: " . ini_get('session.gc_maxlifetime') . "\n";
echo "\n";

// 6. Verificar permisos de escritura
echo "=== PERMISOS ===\n";
$storage_path = __DIR__ . '/../storage';
echo "storage writable: " . (is_writable($storage_path) ? 'SÍ' : 'NO') . "\n";
$logs_path = __DIR__ . '/../storage/logs';
echo "logs writable: " . (is_writable($logs_path) ? 'SÍ' : 'NO') . "\n";
echo "\n";

echo "</pre>";

// Formulario para test de inserción
if ($_SESSION['rol'] === 'evaluador') {
    echo '<form method="POST">';
    echo '<button type="submit" name="test_insert" value="1">Ejecutar Test de Inserción</button>';
    echo '</form>';
}

echo '<br><a href="index.php">Volver al sistema</a>';
?>