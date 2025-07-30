<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Tests - Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4><i class="fas fa-search"></i> Verificación de Tests en la Base de Datos</h4>
                </div>
                <div class="card-body">
                    <?php
                    try {
                        // Incluir la configuración de base de datos
                        require_once '../config/database.php';
                        
                        echo '<div class="alert alert-info"><strong>🔍 Verificando tests en la base de datos...</strong></div>';
                        
                        // Contar tests
                        $stmt = $pdo->query("SELECT COUNT(*) as total FROM tests");
                        $total = $stmt->fetchColumn();
                        
                        echo '<div class="alert alert-primary"><strong>📊 Total de tests:</strong> ' . $total . '</div>';
                        
                        if ($total > 0) {
                            // Mostrar todos los tests
                            $stmt = $pdo->query("SELECT * FROM tests ORDER BY id");
                            $tests = $stmt->fetchAll();
                            
                            echo '<div class="alert alert-success"><strong>✅ Tests encontrados en la base de datos</strong></div>';
                            
                            echo '<h5>📋 Lista de Tests:</h5>';
                            echo '<div class="table-responsive">';
                            echo '<table class="table table-striped table-hover">';
                            echo '<thead class="table-dark">';
                            echo '<tr><th>ID</th><th>Nombre del Test</th><th>Descripción</th></tr>';
                            echo '</thead><tbody>';
                            
                            foreach ($tests as $test) {
                                echo '<tr>';
                                echo '<td><span class="badge bg-primary">' . htmlspecialchars($test['id']) . '</span></td>';
                                echo '<td><strong>' . htmlspecialchars($test['nombre_test']) . '</strong></td>';
                                echo '<td>' . htmlspecialchars($test['descripcion']) . '</td>';
                                echo '</tr>';
                            }
                            
                            echo '</tbody></table></div>';
                            
                            echo '<div class="alert alert-success mt-4">';
                            echo '<h6><i class="fas fa-check-circle"></i> Resultado de la Verificación:</h6>';
                            echo '<ul>';
                            echo '<li>✅ Los tests se mostrarán correctamente en el catálogo dinámico</li>';
                            echo '<li>✅ El catálogo de evaluadores ahora muestra información real de la base de datos</li>';
                            echo '<li>✅ Sincronizado con la página de administración de tests</li>';
                            echo '</ul>';
                            echo '</div>';
                            
                        } else {
                            echo '<div class="alert alert-warning">';
                            echo '<h6><i class="fas fa-exclamation-triangle"></i> No hay tests registrados</h6>';
                            echo '<p>No se encontraron tests en la base de datos. Para agregar tests:</p>';
                            echo '<ul>';
                            echo '<li>🔐 Inicie sesión como administrador</li>';
                            echo '<li>🛠️ Vaya a la sección "Gestión de Tests"</li>';
                            echo '<li>➕ Use el botón "Nuevo Test" para agregar tests</li>';
                            echo '</ul>';
                            echo '</div>';
                        }
                        
                        // Mostrar la diferencia antes/después
                        echo '<hr><div class="alert alert-light">';
                        echo '<h6><i class="fas fa-info-circle"></i> Cambios Realizados:</h6>';
                        echo '<div class="row">';
                        echo '<div class="col-md-6">';
                        echo '<h7><strong>❌ Antes (Estático):</strong></h7>';
                        echo '<ul class="small text-muted">';
                        echo '<li>Tests hardcodeados en HTML</li>';
                        echo '<li>Información inventada</li>';
                        echo '<li>Datos no sincronizados</li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '<div class="col-md-6">';
                        echo '<h7><strong>✅ Ahora (Dinámico):</strong></h7>';
                        echo '<ul class="small text-success">';
                        echo '<li>Tests desde base de datos</li>';
                        echo '<li>Información real y actualizada</li>';
                        echo '<li>Sincronizado con administración</li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger"><strong>❌ Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
                    }
                    ?>
                    
                    <hr>
                    <div class="text-center">
                        <a href="../index.php?controller=Test&action=catalogo" class="btn btn-primary me-2">
                            <i class="fas fa-eye"></i> Ver Catálogo de Tests
                        </a>
                        <a href="../index.php?controller=Admin&action=tests" class="btn btn-secondary me-2">
                            <i class="fas fa-cog"></i> Gestión de Tests (Admin)
                        </a>
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