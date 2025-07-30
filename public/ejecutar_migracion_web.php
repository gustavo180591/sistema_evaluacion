<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejecutar Migración - Campo Activo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-database"></i> Migración: Agregar Campo Activo</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_POST['ejecutar_migracion'])) {
                        try {
                            // Incluir la configuración de base de datos
                            require_once '../config/database.php';
                            
                            echo '<div class="alert alert-info"><strong>🚀 Iniciando migración...</strong></div>';
                            
                            // Verificar si el campo ya existe
                            $stmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
                            if ($stmt->rowCount() > 0) {
                                echo '<div class="alert alert-warning"><strong>⚠️ El campo "activo" ya existe en la tabla atletas</strong></div>';
                            } else {
                                // Agregar el campo activo
                                echo '<div class="alert alert-info">📝 Agregando campo "activo" a la tabla atletas...</div>';
                                $pdo->exec("ALTER TABLE atletas ADD COLUMN activo BOOLEAN DEFAULT TRUE");
                                
                                // Marcar todos los atletas existentes como activos
                                echo '<div class="alert alert-info">✅ Marcando atletas existentes como activos...</div>';
                                $pdo->exec("UPDATE atletas SET activo = TRUE WHERE activo IS NULL");
                                
                                // Agregar índice
                                echo '<div class="alert alert-info">🗂️ Agregando índice para mejor performance...</div>';
                                $pdo->exec("CREATE INDEX idx_atletas_activo ON atletas(activo)");
                                
                                echo '<div class="alert alert-success"><strong>✅ ¡Migración ejecutada exitosamente!</strong></div>';
                                echo '<div class="alert alert-info">
                                    <h6>📊 Cambios realizados:</h6>
                                    <ul>
                                        <li>✅ Campo "activo" agregado a tabla atletas</li>
                                        <li>✅ Todos los atletas existentes marcados como activos</li>
                                        <li>✅ Índice agregado para mejorar consultas</li>
                                    </ul>
                                </div>';
                            }
                            
                            // Verificar el resultado
                            $stmt = $pdo->query("SELECT COUNT(*) as total FROM atletas WHERE activo = TRUE");
                            $totalActivos = $stmt->fetchColumn();
                            
                            $stmt = $pdo->query("SELECT COUNT(*) as total FROM atletas");
                            $totalAtletas = $stmt->fetchColumn();
                            
                            echo '<div class="alert alert-success">
                                <h6>📈 Estado actual:</h6>
                                <ul>
                                    <li><strong>Total atletas:</strong> ' . $totalAtletas . '</li>
                                    <li><strong>Atletas activos:</strong> ' . $totalActivos . '</li>
                                    <li><strong>Atletas ocultos:</strong> ' . ($totalAtletas - $totalActivos) . '</li>
                                </ul>
                            </div>';
                            
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger"><strong>❌ Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
                        }
                    } else {
                        ?>
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle"></i> ¡Importante!</h6>
                            <p>Esta migración agregará el campo <code>activo</code> a la tabla <code>atletas</code> para implementar eliminación suave.</p>
                            <ul>
                                <li>✅ Todos los atletas existentes serán marcados como activos</li>
                                <li>🔒 Los datos existentes no se eliminarán</li>
                                <li>⚡ Se agregará un índice para mejorar performance</li>
                            </ul>
                        </div>
                        
                        <form method="post">
                            <div class="text-center">
                                <button type="submit" name="ejecutar_migracion" class="btn btn-primary btn-lg">
                                    <i class="fas fa-play"></i> Ejecutar Migración
                                </button>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                    
                    <hr>
                    <div class="text-center">
                        <a href="../index.php" class="btn btn-success">
                            <i class="fas fa-home"></i> Volver al Sistema
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</body>
</html> 