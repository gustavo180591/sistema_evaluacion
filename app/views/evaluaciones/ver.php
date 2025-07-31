<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-clipboard-check text-primary"></i> 
                        Evaluación de <?php echo htmlspecialchars($evaluacion['nombre'] . ' ' . $evaluacion['apellido']); ?>
                    </h1>
                    <p class="text-muted mb-0">
                        Evaluación realizada el <?php echo date('d/m/Y', strtotime($evaluacion['fecha_evaluacion'])); ?>
                        <?php if ($evaluacion['hora_inicio']): ?>
                            a las <?php echo date('H:i', strtotime($evaluacion['hora_inicio'])); ?> (BA)
                        <?php endif; ?>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-<?php echo $evaluacion['estado'] == 'completada' ? 'success' : 'warning'; ?> fs-6 px-3 py-2">
                        <i class="fas fa-<?php echo $evaluacion['estado'] == 'completada' ? 'check-circle' : 'hourglass-half'; ?> me-1"></i>
                        <?php echo ucfirst($evaluacion['estado']); ?>
                    </span>
                    <a href="index.php?controller=Evaluacion&action=listado" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <!-- Mensajes de Estado -->
            <?php if (isset($_GET['success']) || isset($_GET['error']) || isset($_GET['info'])): ?>
                <?php if (isset($_GET['success'])): ?>
                    <?php 
                    $successMessages = [
                        'finalizada' => '¡Evaluación finalizada correctamente!',
                        'ambiental_updated' => '¡Información de clima y temperatura actualizada!'
                    ];
                    $message = $successMessages[$_GET['success']] ?? '¡Operación completada con éxito!';
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <?php 
                    $errorMessages = [
                        'finalizar' => 'No se pudo finalizar la evaluación. Inténtalo de nuevo.',
                        'update_failed' => 'No se pudieron guardar los cambios.'
                    ];
                    $message = $errorMessages[$_GET['error']] ?? 'Ha ocurrido un problema.';
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Error:</strong> <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['info'])): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        No se realizaron cambios en el clima y temperatura.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Información del Atleta -->
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-primary text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i> Información del Atleta
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="form-section mb-4">
                        <div class="form-row">
                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user me-1"></i> Nombre Completo
                                        </label>
                                        <div class="form-control form-control-sm bg-light">
                                            <?php echo htmlspecialchars(($atleta['nombre'] ?? '') . ' ' . ($atleta['apellido'] ?? '')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-id-card me-1"></i> DNI
                                        </label>
                                        <div class="form-control form-control-sm bg-light">
                                            <?php echo htmlspecialchars($atleta['dni'] ?? ''); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-birthday-cake me-1"></i> Edad
                                        </label>
                                        <div class="form-control form-control-sm bg-light">
                                            <?php echo $atleta['edad'] ?? 'No especificada'; ?> años
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-venus-mars me-1"></i> Sexo
                                        </label>
                                        <div class="form-control form-control-sm bg-light">
                                            <?php echo (($atleta['sexo'] ?? '') === 'M') ? '👨 Masculino' : ((($atleta['sexo'] ?? '') === 'F') ? '👩 Femenino' : 'No especificado'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($atleta['nacionalidad'])): ?>
                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-flag me-1"></i> Nacionalidad
                                        </label>
                                        <div class="form-control form-control-sm bg-light">
                                            <?php echo htmlspecialchars($atleta['nacionalidad'] ?? ''); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-edit me-1"></i> Acciones
                                        </label>
                                        <div class="d-flex gap-2">
                                            <a href="index.php?controller=Atleta&action=editar&id=<?php echo $atleta['id'] ?? 0; ?>" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit me-1"></i> Editar
                                            </a>
                                            <a href="index.php?controller=Atleta&action=historial&id=<?php echo $atleta['id'] ?? 0; ?>" 
                                               class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-history me-1"></i> Historial
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                                                 <?php if (!empty($atleta['altura_cm']) || !empty($atleta['peso_kg'])): ?>
                         <div class="form-row">
                             <?php if (!empty($atleta['altura_cm'])): ?>
                             <div class="form-field">
                                 <div class="field-card field-card-small">
                                     <div class="form-group">
                                         <label class="form-label fw-semibold">
                                             <i class="fas fa-arrows-alt-v me-1"></i> Altura
                                         </label>
                                         <div class="input-group input-group-sm">
                                             <div class="form-control bg-light"><?php echo $atleta['altura_cm'] ?? ''; ?></div>
                                             <span class="input-group-text">cm</span>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <?php endif; ?>

                             <?php if (!empty($atleta['peso_kg'])): ?>
                             <div class="form-field">
                                 <div class="field-card field-card-small">
                                     <div class="form-group">
                                         <label class="form-label fw-semibold">
                                             <i class="fas fa-weight me-1"></i> Peso
                                         </label>
                                         <div class="input-group input-group-sm">
                                             <div class="form-control bg-light"><?php echo $atleta['peso_kg'] ?? ''; ?></div>
                                             <span class="input-group-text">kg</span>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <?php endif; ?>

                             <?php if (!empty($atleta['altura_cm']) && !empty($atleta['peso_kg'])): ?>
                             <div class="form-field">
                                 <div class="field-card field-card-small">
                                     <div class="form-group">
                                         <label class="form-label fw-semibold">
                                             <i class="fas fa-calculator me-1"></i> IMC Calculado
                                         </label>
                                         <div class="form-control form-control-sm bg-light">
                                             <?php 
                                             $alturaM = ($atleta['altura_cm'] ?? 0) / 100;
                                             $imc = ($atleta['peso_kg'] ?? 0) / ($alturaM * $alturaM);
                                             echo $alturaM > 0 ? number_format($imc, 1) : 'No disponible';
                                             ?>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <?php endif; ?>
                         </div>
                         <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Métricas de la Evaluación -->
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-success text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i> Métricas de la Evaluación
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="form-section mb-4">
                        <div class="form-row">
                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-tasks me-1"></i> Tests Totales
                                        </label>
                                        <div class="form-control form-control-sm bg-light text-center">
                                            <span class="badge bg-primary fs-6"><?php echo $estadisticas['total_tests']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-check-circle me-1"></i> Completados
                                        </label>
                                        <div class="form-control form-control-sm bg-light text-center">
                                            <span class="badge bg-success fs-6"><?php echo $estadisticas['tests_completados']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-percentage me-1"></i> Progreso
                                        </label>
                                        <div class="form-control form-control-sm bg-light text-center">
                                            <span class="badge bg-info fs-6">
                                                <?php echo $estadisticas['total_tests'] > 0 ? round(($estadisticas['tests_completados'] / $estadisticas['total_tests']) * 100) : 0; ?>%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-clock me-1"></i> Duración
                                        </label>
                                        <div class="form-control form-control-sm bg-light text-center">
                                            <span class="badge bg-warning text-dark fs-6">
                                                <?php echo $estadisticas['duracion_estimada'] ?? '--:--'; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Ambiental -->
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-info text-white py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cloud-sun me-2"></i> Información Ambiental
                        </h5>
                        <button type="button" class="btn btn-light btn-sm" id="btnEditarAmbiental" onclick="toggleEditAmbiental()">
                            <i class="fas fa-edit me-1"></i> Editar
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Vista normal -->
                    <div id="infoAmbiental" class="form-section mb-4">
                        <div class="form-row">
                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-map-marker-alt me-1"></i> Lugar
                                        </label>
                                        <div class="form-control form-control-sm bg-light">
                                            <?php echo htmlspecialchars($evaluacion['lugar_nombre'] ?? 'No especificado'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-cloud-sun me-1"></i> Clima
                                        </label>
                                        <div class="form-control form-control-sm bg-light">
                                            <?php echo !empty($evaluacion['clima']) ? htmlspecialchars($evaluacion['clima']) : 'No especificado'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-thermometer-half me-1"></i> Temperatura
                                        </label>
                                        <div class="form-control form-control-sm bg-light">
                                            <?php echo !empty($evaluacion['temperatura_ambiente']) ? 
                                                $evaluacion['temperatura_ambiente'] . '°C' : 'No registrada'; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de edición -->
                    <div id="formAmbiental" class="d-none">
                        <form method="POST" action="index.php?controller=Evaluacion&action=actualizarAmbiental" class="needs-validation" novalidate>
                            <input type="hidden" name="evaluacion_id" value="<?php echo $evaluacion['id']; ?>">
                            
                            <div class="form-section mb-4">
                                <div class="form-row">
                                    <div class="form-field">
                                        <div class="field-card field-card-small">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">
                                                    <i class="fas fa-map-marker-alt me-1"></i> Lugar
                                                </label>
                                                <div class="form-control form-control-sm bg-light">
                                                    <?php echo htmlspecialchars($evaluacion['lugar_nombre'] ?? 'No especificado'); ?>
                                                </div>
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i> El lugar se establece según el atleta. 
                                                    <a href="index.php?controller=Atleta&action=editar&id=<?php echo $evaluacion['atleta_id']; ?>" class="text-primary">
                                                        <i class="fas fa-edit"></i> Editar atleta
                                                    </a>
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-field">
                                        <div class="field-card field-card-small">
                                            <div class="form-group">
                                                <label for="clima" class="form-label fw-semibold">
                                                    <i class="fas fa-cloud-sun me-1"></i> Clima
                                                </label>
                                                <select class="form-select form-select-sm" id="clima" name="clima">
                                                    <option value="">Seleccionar...</option>
                                                    <option value="soleado" <?php echo ($evaluacion['clima'] == 'soleado') ? 'selected' : ''; ?>>☀️ Soleado</option>
                                                    <option value="nublado" <?php echo ($evaluacion['clima'] == 'nublado') ? 'selected' : ''; ?>>☁️ Nublado</option>
                                                    <option value="parcialmente_nublado" <?php echo ($evaluacion['clima'] == 'parcialmente_nublado') ? 'selected' : ''; ?>>⛅ Parcialmente Nublado</option>
                                                    <option value="lluvioso" <?php echo ($evaluacion['clima'] == 'lluvioso') ? 'selected' : ''; ?>>🌧️ Lluvioso</option>
                                                    <option value="ventoso" <?php echo ($evaluacion['clima'] == 'ventoso') ? 'selected' : ''; ?>>💨 Ventoso</option>
                                                    <option value="caluroso" <?php echo ($evaluacion['clima'] == 'caluroso') ? 'selected' : ''; ?>>🔥 Caluroso</option>
                                                    <option value="frio" <?php echo ($evaluacion['clima'] == 'frio') ? 'selected' : ''; ?>>🌡️ Frío</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-field">
                                        <div class="field-card field-card-small">
                                            <div class="form-group">
                                                <label for="temperatura_ambiente" class="form-label fw-semibold">
                                                    <i class="fas fa-thermometer-half me-1"></i> Temperatura
                                                </label>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" 
                                                           class="form-control" 
                                                           id="temperatura_ambiente" 
                                                           name="temperatura_ambiente" 
                                                           min="-10" 
                                                           max="50" 
                                                           step="0.1"
                                                           value="<?php echo htmlspecialchars($evaluacion['temperatura_ambiente'] ?? ''); ?>"
                                                           placeholder="Ej: 22.5">
                                                    <span class="input-group-text">°C</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center align-items-center pt-3 border-top gap-3">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-secondary" onclick="cancelarEditAmbiental()">
                                        <i class="fas fa-times me-1"></i> Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tests Realizados por Categoría -->
            <?php if (!empty($resultados)): ?>
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-warning text-dark py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list-alt me-2"></i> Tests Realizados (<?php echo count($resultados); ?>)
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="index.php?controller=Evaluacion&action=nueva&atleta_id=<?php echo $evaluacion['atleta_id']; ?>&evaluacion_id=<?php echo $evaluacion['id']; ?>" 
                               class="btn btn-outline-dark btn-sm">
                                <i class="fas fa-plus me-1"></i> Agregar Tests
                            </a>
                            <div class="dropdown">
                                <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-download me-1"></i> Exportar
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="index.php?controller=Atleta&action=exportarHistorialExcel&id=<?php echo $atleta['id'] ?? 0; ?>">
                                        <i class="fas fa-file-excel text-success me-1"></i> Excel
                                    </a></li>
                                    <li><a class="dropdown-item" href="#" onclick="window.print()">
                                        <i class="fas fa-print text-primary me-1"></i> Imprimir
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <?php 
                    $categories = [
                        'antropometria' => ['name' => 'Antropometría', 'icon' => 'ruler-vertical', 'color' => 'primary'],
                        'fuerza' => ['name' => 'Fuerza', 'icon' => 'dumbbell', 'color' => 'danger'], 
                        'resistencia' => ['name' => 'Resistencia', 'icon' => 'heartbeat', 'color' => 'success'],
                        'flexibilidad' => ['name' => 'Flexibilidad', 'icon' => 'expand-arrows-alt', 'color' => 'warning'],
                        'velocidad' => ['name' => 'Velocidad', 'icon' => 'bolt', 'color' => 'info'],
                        'otros' => ['name' => 'Otros', 'icon' => 'tasks', 'color' => 'secondary']
                    ];

                    foreach ($categories as $key => $category):
                        if (!empty($estadisticas['categorias'][$key])):
                    ?>
                    <div class="form-section mb-4">
                        <div class="section-header mb-3">
                            <h6 class="text-<?php echo $category['color']; ?> fw-bold">
                                <i class="fas fa-<?php echo $category['icon']; ?> me-2"></i>
                                <?php echo $category['name']; ?>
                                <span class="badge bg-<?php echo $category['color']; ?> ms-2">
                                    <?php echo count($estadisticas['categorias'][$key]); ?>
                                </span>
                            </h6>
                        </div>
                        
                        <div class="form-row">
                            <?php foreach ($estadisticas['categorias'][$key] as $resultado): 
                                $resultadosJson = json_decode($resultado['resultado_json'], true);
                            ?>
                            <div class="form-field">
                                <div class="field-card">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-<?php echo $category['icon']; ?> text-<?php echo $category['color']; ?> me-1"></i>
                                            <?php echo htmlspecialchars($resultado['nombre_test']); ?>
                                        </label>
                                        
                                        <div class="bg-light p-2 rounded mb-2">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-clock me-1"></i> 
                                                <?php echo date('d/m/Y H:i', strtotime($resultado['fecha_test'])); ?>
                                            </small>
                                        </div>

                                        <?php if ($resultadosJson && is_array($resultadosJson)): ?>
                                            <?php foreach ($resultadosJson as $k => $v): ?>
                                            <div class="form-control form-control-sm bg-light mb-1">
                                                <strong><?php echo htmlspecialchars($k); ?>:</strong> 
                                                <?php echo htmlspecialchars($v); ?>
                                            </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="form-control form-control-sm bg-light text-muted">
                                                Sin datos registrados
                                            </div>
                                        <?php endif; ?>

                                        <div class="mt-2">
                                            <a href="index.php?controller=Test&action=ver&id=<?php echo $resultado['id']; ?>" 
                                               class="btn btn-outline-<?php echo $category['color']; ?> btn-sm w-100">
                                                <i class="fas fa-eye me-1"></i> Ver Detalles
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
            <?php else: ?>
            <!-- Sin Tests -->
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-light py-4">
                    <h5 class="card-title mb-0 text-muted">
                        <i class="fas fa-clipboard-list me-2"></i> Tests Realizados
                    </h5>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="form-section">
                        <div class="mb-3">
                            <i class="fas fa-clipboard-list fa-4x text-muted opacity-25"></i>
                        </div>
                        <h5 class="text-muted mb-3">No hay tests realizados aún</h5>
                        <p class="text-muted mb-4">Comienza agregando tests a esta evaluación para ver los resultados organizados por categoría.</p>
                        <a href="index.php?controller=Evaluacion&action=nueva&atleta_id=<?php echo $evaluacion['atleta_id']; ?>&evaluacion_id=<?php echo $evaluacion['id']; ?>" 
                           class="btn btn-primary px-4">
                            <i class="fas fa-plus me-2"></i> Agregar Tests
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Observaciones -->
            <?php if ($evaluacion['observaciones']): ?>
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-secondary text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-sticky-note me-2"></i> Observaciones de la Evaluación
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="form-section">
                        <div class="field-card">
                            <div class="form-group">
                                <div class="form-control bg-light" style="min-height: 100px; white-space: pre-wrap;">
                                    <?php echo nl2br(htmlspecialchars($evaluacion['observaciones'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Evaluaciones Anteriores del Atleta -->
            <?php if (!empty($evaluacionesAnteriores)): ?>
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-dark text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i> Evaluaciones Anteriores (<?php echo count($evaluacionesAnteriores); ?>)
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="form-section">
                        <div class="form-row">
                            <?php foreach ($evaluacionesAnteriores as $eval): ?>
                            <div class="form-field">
                                <div class="field-card field-card-small">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-calendar me-1"></i> 
                                            <?php echo date('d/m/Y', strtotime($eval['fecha_evaluacion'])); ?>
                                        </label>
                                        <div class="form-control form-control-sm bg-light text-center">
                                            <span class="badge bg-info"><?php echo $eval['total_tests']; ?> tests</span>
                                        </div>
                                        <div class="mt-2">
                                            <a href="index.php?controller=Evaluacion&action=ver&id=<?php echo $eval['id']; ?>" 
                                               class="btn btn-outline-dark btn-sm w-100">
                                                <i class="fas fa-eye me-1"></i> Ver
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Recomendaciones Inteligentes -->
            <?php if (!empty($recomendaciones)): ?>
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-warning text-dark py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb me-2"></i> Recomendaciones del Sistema
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="form-section">
                        <div class="form-row">
                            <?php foreach ($recomendaciones as $recomendacion): ?>
                            <div class="form-field">
                                <div class="field-card">
                                    <div class="alert alert-<?php echo $recomendacion['tipo']; ?> mb-0" role="alert">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-<?php echo $recomendacion['icono']; ?> me-2 mt-1"></i>
                                            <div>
                                                <h6 class="alert-heading mb-1"><?php echo $recomendacion['titulo']; ?></h6>
                                                <p class="mb-0 small"><?php echo $recomendacion['mensaje']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Acciones Principales -->
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i> Acciones Disponibles
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="form-section">
                        <p class="text-muted text-center mb-4">
                            Gestiona esta evaluación con las acciones disponibles según su estado actual.
                        </p>
                        
                        <div class="d-flex justify-content-center align-items-center pt-3 border-top gap-3">
                            <div class="d-flex gap-2">
                                <a href="index.php?controller=Evaluacion&action=listado" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                                </a>
                                <a href="index.php?controller=Evaluacion&action=nueva&atleta_id=<?php echo $evaluacion['atleta_id']; ?>&evaluacion_id=<?php echo $evaluacion['id']; ?>" 
                                   class="btn btn-primary px-4">
                                    <i class="fas fa-plus me-1"></i> Agregar Tests
                                </a>
                            </div>
                            <?php if ($evaluacion['estado'] != 'completada'): ?>
                            <form method="POST" action="index.php?controller=Evaluacion&action=finalizar" class="d-inline" 
                                  onsubmit="return confirm('¿Estás seguro de que deseas marcar esta evaluación como completada? No podrás agregar más tests después.');">
                                <input type="hidden" name="evaluacion_id" value="<?php echo $evaluacion['id']; ?>">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-check-circle me-1"></i> Finalizar Evaluación
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos heredados de atletas/crear.php */
.card {
    border-radius: 12px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    border-bottom: none;
}

/* Secciones del formulario */
.form-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 2.5rem;
    border-left: 5px solid #0d6efd;
    margin-bottom: 2rem;
    text-align: center;
}

.section-header {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.step-number {
    width: 40px;
    height: 40px;
    background: #0d6efd;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
}

/* Field Cards */
.field-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease-in-out;
    height: 100%;
}

.field-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    border-color: #0d6efd;
    transform: translateY(-1px);
}

.field-card .form-group {
    margin-bottom: 0;
}

.field-card .form-label {
    color: #495057;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.field-card .form-control,
.field-card .form-select {
    border: 1px solid #ced4da;
    border-radius: 6px;
    transition: all 0.15s ease-in-out;
}

.field-card .form-control:focus,
.field-card .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* Layout Flexbox */
.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    align-items: flex-start;
    justify-content: center;
    margin-bottom: 2rem;
}

.form-row:last-child {
    margin-bottom: 0;
}

.form-field {
    flex: 1;
    min-width: 200px;
    max-width: 300px;
}

/* Campos pequeños */
.field-card .form-control-sm,
.field-card .form-select-sm {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    border-radius: 6px;
    width: 100%;
}

.field-card .input-group-sm .form-control {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.field-card .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

/* Input groups compactos */
.field-card .input-group-sm {
    width: 100%;
}

/* Labels más compactos */
.field-card .form-label {
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

/* Validación */
.was-validated .form-control:valid,
.was-validated .form-select:valid {
    border-color: #198754;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.54-.54L4.5 7.84l3.15-3.15.54.54L4.5 8.84z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.was-validated .form-control:invalid,
.was-validated .form-select:invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 5.8 0.4 0.4 0.4 -0.4'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* Responsive */
@media (max-width: 1200px) {
    .form-field {
        min-width: 180px;
        max-width: 250px;
    }
}

@media (max-width: 992px) {
    .form-field {
        min-width: 160px;
        max-width: 220px;
    }
    
    .field-card {
        padding: 1.25rem;
    }
}

@media (max-width: 768px) {
    .form-section {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .field-card {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    /* En móviles, apilar los campos */
    .form-row {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-field {
        min-width: 100%;
        max-width: 100%;
    }
    
    /* En móviles, mantener la proporción pero apilados */
    .field-card-small,
    .field-card-large {
        background: white;
        border-left: 3px solid #0d6efd;
    }
    
    .d-flex.justify-content-center {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-center > div {
        width: 100%;
        display: flex;
        justify-content: center;
    }
    
    .d-flex.justify-content-center .btn {
        width: 100%;
        max-width: 200px;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .field-card {
        padding: 0.75rem;
    }
    
    .form-section {
        padding: 0.75rem;
    }
}

/* Efectos hover */
.form-section:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
}

.btn:hover {
    transform: translateY(-1px);
}

/* Estilos para botones dentro de inputs */
.input-group {
    position: relative;
}

.input-group .position-absolute {
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    display: flex;
    align-items: center;
    padding-right: 10px;
    z-index: 10;
}

/* Loading states */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.btn.loading {
    position: relative;
}

.btn.loading::after {
    content: '';
    width: 16px;
    height: 16px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}

@keyframes spin {
    0% { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
}

/* Character counter */
.char-counter {
    font-size: 0.75rem;
    color: #6c757d;
    text-align: right;
    margin-top: 0.25rem;
}

.char-counter.warning {
    color: #f57c00;
}

.char-counter.danger {
    color: #dc3545;
}

/* Estilos específicos para vista de evaluación */
.bg-light-readonly {
    background-color: #f8f9fa !important;
    color: #495057;
}

/* Impresión */
@media print {
    .btn, .navbar, .dropdown, #btnEditarAmbiental, #formAmbiental {
        display: none !important;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
        break-inside: avoid;
    }
    
    .form-section {
        break-inside: avoid;
    }
}
</style>

<script>
// ========== FUNCIONES DE EDICIÓN AMBIENTAL ==========
function toggleEditAmbiental() {
    const infoDiv = document.getElementById('infoAmbiental');
    const formDiv = document.getElementById('formAmbiental');
    const btnEditar = document.getElementById('btnEditarAmbiental');
    
    if (formDiv.classList.contains('d-none')) {
        // Mostrar formulario, ocultar vista normal
        infoDiv.classList.add('d-none');
        formDiv.classList.remove('d-none');
        btnEditar.innerHTML = '<i class="fas fa-eye me-1"></i> Ver Información';
        btnEditar.classList.remove('btn-light');
        btnEditar.classList.add('btn-outline-light');
    } else {
        // Mostrar vista normal, ocultar formulario
        infoDiv.classList.remove('d-none');
        formDiv.classList.add('d-none');
        btnEditar.innerHTML = '<i class="fas fa-edit me-1"></i> Editar';
        btnEditar.classList.remove('btn-outline-light');
        btnEditar.classList.add('btn-light');
    }
}

function cancelarEditAmbiental() {
    const infoDiv = document.getElementById('infoAmbiental');
    const formDiv = document.getElementById('formAmbiental');
    const btnEditar = document.getElementById('btnEditarAmbiental');
    
    // Ocultar formulario
    infoDiv.classList.remove('d-none');
    formDiv.classList.add('d-none');
    btnEditar.innerHTML = '<i class="fas fa-edit me-1"></i> Editar';
    btnEditar.classList.remove('btn-outline-light');
    btnEditar.classList.add('btn-light');
    
    // Resetear formulario a valores originales
    const form = formDiv.querySelector('form');
    form.reset();
    
    // Restaurar valores seleccionados
    <?php if ($evaluacion['clima']): ?>
    document.getElementById('clima').value = '<?php echo $evaluacion['clima']; ?>';
    <?php endif; ?>
    
    <?php if ($evaluacion['temperatura_ambiente']): ?>
    document.getElementById('temperatura_ambiente').value = '<?php echo $evaluacion['temperatura_ambiente']; ?>';
    <?php endif; ?>
}

// ========== INICIALIZACIÓN ==========
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Validación del formulario ambiental
    const form = document.querySelector('#formAmbiental form');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }

    // Animaciones de entrada
    const fieldCards = document.querySelectorAll('.field-card');
    fieldCards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
        card.classList.add('fadeInUp');
    });

    // Tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    console.log('🏃‍♂️ Vista de evaluación con estilos de crear atleta inicializada');
});

// Animación CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fadeInUp {
        animation: fadeInUp 0.6s ease-out;
    }
`;
document.head.appendChild(style);

// ========== FUNCIONES DE UTILIDAD ==========
function imprimirEvaluacion() {
    window.print();
}

function exportarDatos(formato) {
    const atletaId = <?php echo $atleta['id'] ?? 0; ?>;
    const evaluacionId = <?php echo $evaluacion['id'] ?? 0; ?>;
    
    if (formato === 'excel') {
        window.location.href = `index.php?controller=Atleta&action=exportarHistorialExcel&id=${atletaId}`;
    } else if (formato === 'pdf') {
        window.location.href = `index.php?controller=Evaluacion&action=exportarPDF&id=${evaluacionId}`;
    }
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 