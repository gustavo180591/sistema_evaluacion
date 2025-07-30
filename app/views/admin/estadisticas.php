<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="h3 mb-0">
                    <i class="fas fa-chart-line me-2"></i>Estadísticas del Sistema
                </h1>
                <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                </a>
            </div>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <?php echo $_SESSION['mensaje']; ?>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
            <?php endif; ?>

            <!-- Métricas Principales -->
            <div class="row justify-content-center metrics-section">
                <div class="col-xl-10 col-lg-12">
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        <div class="metric-card border-primary">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="text-primary mb-3">
                                        <i class="fas fa-users fa-3x"></i>
                                    </div>
                                    <h4 class="card-title text-primary"><?php echo number_format($cantidadAtletas); ?></h4>
                                    <p class="card-text text-muted">Atletas Registrados</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="metric-card border-success">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="text-success mb-3">
                                        <i class="fas fa-clipboard-check fa-3x"></i>
                                    </div>
                                    <h4 class="card-title text-success"><?php echo number_format($cantidadResultados); ?></h4>
                                    <p class="card-text text-muted">Tests Realizados</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="metric-card border-info">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="text-info mb-3">
                                        <i class="fas fa-user-tie fa-3x"></i>
                                    </div>
                                    <h4 class="card-title text-info"><?php echo number_format($cantidadEvaluadores); ?></h4>
                                    <p class="card-text text-muted">Evaluadores Activos</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="metric-card border-warning">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="text-warning mb-3">
                                        <i class="fas fa-clipboard-list fa-3x"></i>
                                    </div>
                                    <h4 class="card-title text-warning"><?php echo number_format($cantidadTests); ?></h4>
                                    <p class="card-text text-muted">Tipos de Test</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="metric-card border-danger">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="text-danger mb-3">
                                        <i class="fas fa-calendar-check fa-3x"></i>
                                    </div>
                                    <h4 class="card-title text-danger"><?php echo number_format($cantidadEvaluaciones); ?></h4>
                                    <p class="card-text text-muted">Evaluaciones Programadas</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="metric-card border-secondary">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="text-secondary mb-3">
                                        <i class="fas fa-user-cog fa-3x"></i>
                                    </div>
                                    <h4 class="card-title text-secondary"><?php echo number_format($cantidadUsuarios); ?></h4>
                                    <p class="card-text text-muted">Usuarios del Sistema</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido Detallado -->
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12">
                    <div class="row detailed-cards-section">
                        <!-- Tests Más Utilizados -->
                        <div class="col-lg-6 mb-5">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                                        Tests Más Utilizados
                                    </h5>
                                </div>
                        <div class="card-body">
                            <?php if (empty($testsMasUtilizados)): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay datos de tests disponibles</p>
                                </div>
                            <?php else: ?>
                                <div class="table-container" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>Test</th>
                                                <th>Realizaciones</th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($testsMasUtilizados, 0, 5) as $test): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($test['nombre_test']); ?></td>
                                                    <td><?php echo $test['cantidad']; ?></td>
                                                    <td>
                                                        <span class="badge bg-primary"><?php echo $test['porcentaje']; ?>%</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                        <!-- Evaluadores Más Activos -->
                        <div class="col-lg-6 mb-5">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-trophy me-2 text-success"></i>
                                        Evaluadores Más Activos
                                    </h5>
                                </div>
                        <div class="card-body">
                            <?php if (empty($evaluadoresMasActivos)): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay datos de evaluadores disponibles</p>
                                </div>
                            <?php else: ?>
                                <div class="table-container" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>#</th>
                                                <th>Evaluador</th>
                                                <th>Tests</th>
                                                <th>Atletas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($evaluadoresMasActivos, 0, 5) as $index => $evaluador): ?>
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-success"><?php echo $index + 1; ?></span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($evaluador['evaluador']); ?></td>
                                                    <td><?php echo $evaluador['total_tests']; ?></td>
                                                    <td><?php echo $evaluador['atletas_evaluados']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                        <!-- Últimas Evaluaciones -->
                        <div class="col-lg-8 mb-5">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-history me-2 text-info"></i>
                                        Últimas Evaluaciones
                                    </h5>
                                </div>
                        <div class="card-body">
                            <?php if (empty($ultimasEvaluaciones)): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay evaluaciones recientes</p>
                                </div>
                            <?php else: ?>
                                <div class="table-container" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Atleta</th>
                                                <th>Evaluador</th>
                                                <th>Estado</th>
                                                <th>Tests</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (array_slice($ultimasEvaluaciones, 0, 5) as $evaluacion): ?>
                                                <tr>
                                                    <td><?php echo date('d/m/Y', strtotime($evaluacion['fecha_evaluacion'])); ?></td>
                                                    <td><?php echo htmlspecialchars($evaluacion['atleta']); ?></td>
                                                    <td><?php echo htmlspecialchars($evaluacion['evaluador']); ?></td>
                                                    <td>
                                                        <span class="badge <?php echo $evaluacion['estado'] == 'completada' ? 'bg-success' : 'bg-warning'; ?>">
                                                            <?php echo ucfirst($evaluacion['estado']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info"><?php echo $evaluacion['tests_completados']; ?> tests</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                        <!-- Actividad por Lugar -->
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-map-marker-alt me-2 text-warning"></i>
                                        Actividad por Lugar
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($estadisticasPorLugar)): ?>
                                        <div class="text-center py-4">
                                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No hay datos por lugar disponibles</p>
                                        </div>
                                    <?php else: ?>
                                        <div class="table-container" style="max-height: 300px; overflow-y: auto;">
                                            <table class="table table-striped table-hover">
                                                <thead class="table-light sticky-top">
                                                    <tr>
                                                        <th>Lugar</th>
                                                        <th>Tests</th>
                                                        <th>Atletas</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach (array_slice($estadisticasPorLugar, 0, 5) as $lugar): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($lugar['lugar']); ?></td>
                                                            <td><?php echo $lugar['total_tests']; ?></td>
                                                            <td><?php echo $lugar['atletas_unicos']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para estadísticas - Estilo Admin Estándar */

/* Secciones con más espaciado */
.metrics-section {
    margin-bottom: 4rem;
    padding: 0 1rem;
}

.detailed-cards-section {
    gap: 1.5rem;
    padding: 0 0.5rem;
}

/* Metric Cards */
.metric-card {
    flex: 0 0 auto;
    width: 200px;
    margin-bottom: 1.5rem;
}

.metric-card .card {
    height: 100%;
    min-height: 180px;
    transition: all 0.3s ease;
}

.metric-card .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.metric-card .card-body {
    padding: 1.5rem 1rem;
}

.metric-card h4 {
    font-weight: 700;
    font-size: 2rem;
    margin: 0.5rem 0;
}

.metric-card .fa-3x {
    margin-bottom: 0.5rem;
}

.table-container {
    position: relative;
}

.table-container .table {
    margin-bottom: 0;
}

.table-container .sticky-top {
    top: 0;
    z-index: 10;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease-in-out;
    margin-bottom: 1rem;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 1.25rem;
}

.card-title {
    font-weight: 600;
    color: #495057;
}

.table {
    font-size: 0.9rem;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

/* Scrollbar personalizada */
.table-container::-webkit-scrollbar {
    width: 6px;
}

.table-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsivo */
@media (max-width: 992px) {
    .metric-card {
        width: 180px;
    }
}

@media (max-width: 768px) {
    .metrics-section {
        margin-bottom: 3rem;
        padding: 0 0.5rem;
    }
    
    .detailed-cards-section {
        gap: 1rem;
    }
    
    .metric-card {
        width: 160px;
        margin-bottom: 1rem;
    }
    
    .metric-card .card {
        min-height: 160px;
    }
    
    .table-container {
        max-height: 250px !important;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .table {
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
    .metrics-section {
        margin-bottom: 2.5rem;
        padding: 0 0.25rem;
    }
    
    .detailed-cards-section {
        gap: 0.75rem;
    }
    
    .metric-card {
        width: 140px;
        margin-bottom: 0.75rem;
    }
    
    .metric-card .card {
        min-height: 140px;
    }
    
    .metric-card .card-body {
        padding: 0.75rem;
    }
    
    .metric-card h4 {
        font-size: 1.5rem;
    }
    
    .metric-card .fa-3x {
        font-size: 2rem !important;
    }
}

/* Animaciones suaves */
.card {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Bordes de colores para las tarjetas de métricas */
.border-primary {
    border-left: 4px solid #007bff !important;
}

.border-success {
    border-left: 4px solid #28a745 !important;
}

.border-info {
    border-left: 4px solid #17a2b8 !important;
}

.border-warning {
    border-left: 4px solid #ffc107 !important;
}

.border-danger {
    border-left: 4px solid #dc3545 !important;
}

.border-secondary {
    border-left: 4px solid #6c757d !important;
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
