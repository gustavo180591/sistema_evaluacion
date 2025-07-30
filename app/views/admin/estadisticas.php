<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header con gradiente -->
            <div class="dashboard-header mb-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="dashboard-title">
                            <i class="fas fa-chart-line me-3"></i>Dashboard de Estadísticas
                        </h1>
                        <p class="dashboard-subtitle">Análisis completo del rendimiento del sistema</p>
                    </div>
                    <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-light btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                    </a>
                </div>
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

            <!-- Tarjetas de Estadísticas Principales -->
            <div class="row g-4 mb-5">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="metric-card metric-card-primary">
                        <div class="metric-card-content">
                            <div class="metric-card-left">
                                <div class="metric-card-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="metric-card-info">
                                    <div class="metric-card-title">Atletas</div>
                                    <div class="metric-card-description">Total registrados</div>
                                </div>
                            </div>
                            <div class="metric-card-right">
                                <div class="metric-card-number"><?php echo number_format($cantidadAtletas); ?></div>
                                <div class="metric-card-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+12%</span>
                                </div>
                            </div>
                        </div>
                        <div class="metric-card-progress">
                            <div class="progress-bar" style="width: 85%"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="metric-card metric-card-success">
                        <div class="metric-card-content">
                            <div class="metric-card-left">
                                <div class="metric-card-icon">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div class="metric-card-info">
                                    <div class="metric-card-title">Tests Realizados</div>
                                    <div class="metric-card-description">Evaluaciones completadas</div>
                                </div>
                            </div>
                            <div class="metric-card-right">
                                <div class="metric-card-number"><?php echo number_format($cantidadResultados); ?></div>
                                <div class="metric-card-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+8%</span>
                                </div>
                            </div>
                        </div>
                        <div class="metric-card-progress">
                            <div class="progress-bar" style="width: 92%"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="metric-card metric-card-info">
                        <div class="metric-card-content">
                            <div class="metric-card-left">
                                <div class="metric-card-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="metric-card-info">
                                    <div class="metric-card-title">Evaluadores</div>
                                    <div class="metric-card-description">Activos en el sistema</div>
                                </div>
                            </div>
                            <div class="metric-card-right">
                                <div class="metric-card-number"><?php echo number_format($cantidadEvaluadores); ?></div>
                                <div class="metric-card-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+5%</span>
                                </div>
                            </div>
                        </div>
                        <div class="metric-card-progress">
                            <div class="progress-bar" style="width: 78%"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="metric-card metric-card-warning">
                        <div class="metric-card-content">
                            <div class="metric-card-left">
                                <div class="metric-card-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div class="metric-card-info">
                                    <div class="metric-card-title">Tipos de Test</div>
                                    <div class="metric-card-description">Evaluaciones disponibles</div>
                                </div>
                            </div>
                            <div class="metric-card-right">
                                <div class="metric-card-number"><?php echo number_format($cantidadTests); ?></div>
                                <div class="metric-card-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+15%</span>
                                </div>
                            </div>
                        </div>
                        <div class="metric-card-progress">
                            <div class="progress-bar" style="width: 88%"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="metric-card metric-card-danger">
                        <div class="metric-card-content">
                            <div class="metric-card-left">
                                <div class="metric-card-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="metric-card-info">
                                    <div class="metric-card-title">Evaluaciones</div>
                                    <div class="metric-card-description">Sesiones programadas</div>
                                </div>
                            </div>
                            <div class="metric-card-right">
                                <div class="metric-card-number"><?php echo number_format($cantidadEvaluaciones); ?></div>
                                <div class="metric-card-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+20%</span>
                                </div>
                            </div>
                        </div>
                        <div class="metric-card-progress">
                            <div class="progress-bar" style="width: 95%"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="metric-card metric-card-secondary">
                        <div class="metric-card-content">
                            <div class="metric-card-left">
                                <div class="metric-card-icon">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                <div class="metric-card-info">
                                    <div class="metric-card-title">Usuarios</div>
                                    <div class="metric-card-description">Total del sistema</div>
                                </div>
                            </div>
                            <div class="metric-card-right">
                                <div class="metric-card-number"><?php echo number_format($cantidadUsuarios); ?></div>
                                <div class="metric-card-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>+3%</span>
                                </div>
                            </div>
                        </div>
                        <div class="metric-card-progress">
                            <div class="progress-bar" style="width: 72%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="row g-4">
                <!-- Tests Más Utilizados -->
                <div class="col-lg-6">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3><i class="fas fa-chart-bar me-2"></i>Tests Más Utilizados</h3>
                        </div>
                        <div class="content-card-body">
                            <?php if (empty($testsMasUtilizados)): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay datos de tests disponibles</p>
                                </div>
                            <?php else: ?>
                                <div class="test-stats">
                                    <?php foreach ($testsMasUtilizados as $test): ?>
                                        <div class="test-stat-item">
                                            <div class="test-stat-info">
                                                <h5><?php echo htmlspecialchars($test['nombre_test']); ?></h5>
                                                <p class="text-muted"><?php echo $test['cantidad']; ?> realizaciones</p>
                                            </div>
                                            <div class="test-stat-bar">
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: <?php echo min($test['porcentaje'], 100); ?>%"></div>
                                                </div>
                                                <span class="percentage"><?php echo $test['porcentaje']; ?>%</span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Evaluadores Más Activos -->
                <div class="col-lg-6">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3><i class="fas fa-trophy me-2"></i>Evaluadores Más Activos</h3>
                        </div>
                        <div class="content-card-body">
                            <?php if (empty($evaluadoresMasActivos)): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay datos de evaluadores disponibles</p>
                                </div>
                            <?php else: ?>
                                <div class="evaluator-stats">
                                    <?php foreach ($evaluadoresMasActivos as $index => $evaluador): ?>
                                        <div class="evaluator-stat-item">
                                            <div class="evaluator-rank">
                                                <span class="rank-number"><?php echo $index + 1; ?></span>
                                            </div>
                                            <div class="evaluator-info">
                                                <h5><?php echo htmlspecialchars($evaluador['evaluador']); ?></h5>
                                                <p class="text-muted">
                                                    <?php echo $evaluador['total_tests']; ?> tests • 
                                                    <?php echo $evaluador['atletas_evaluados']; ?> atletas
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Últimas Evaluaciones -->
                <div class="col-lg-8">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3><i class="fas fa-history me-2"></i>Últimas Evaluaciones</h3>
                        </div>
                        <div class="content-card-body">
                            <?php if (empty($ultimasEvaluaciones)): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay evaluaciones recientes</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Atleta</th>
                                                <th>Evaluador</th>
                                                <th>Estado</th>
                                                <th>Tests</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ultimasEvaluaciones as $evaluacion): ?>
                                                <tr>
                                                    <td>
                                                        <i class="fas fa-calendar me-1"></i>
                                                        <?php echo date('d/m/Y', strtotime($evaluacion['fecha_evaluacion'])); ?>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-user me-1"></i>
                                                        <?php echo htmlspecialchars($evaluacion['atleta']); ?>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-user-tie me-1"></i>
                                                        <?php echo htmlspecialchars($evaluacion['evaluador']); ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-<?php echo $evaluacion['estado'] == 'completada' ? 'success' : 'warning'; ?>">
                                                            <?php echo ucfirst($evaluacion['estado']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            <?php echo $evaluacion['tests_completados']; ?>
                                                        </span>
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

                <!-- Estadísticas por Lugar -->
                <div class="col-lg-4">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h3><i class="fas fa-map-marker-alt me-2"></i>Actividad por Lugar</h3>
                        </div>
                        <div class="content-card-body">
                            <?php if (empty($estadisticasPorLugar)): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay datos por lugar disponibles</p>
                                </div>
                            <?php else: ?>
                                <div class="location-stats">
                                    <?php foreach ($estadisticasPorLugar as $lugar): ?>
                                        <div class="location-stat-item">
                                            <div class="location-info">
                                                <h6><?php echo htmlspecialchars($lugar['lugar']); ?></h6>
                                                <p class="text-muted">
                                                    <?php echo $lugar['total_tests']; ?> tests • 
                                                    <?php echo $lugar['atletas_unicos']; ?> atletas
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Variables CSS */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    --secondary-gradient: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    --card-shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
    --border-radius: 20px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Dashboard Header */
.dashboard-header {
    background: var(--primary-gradient);
    padding: 2rem;
    border-radius: var(--border-radius);
    color: white;
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0.5rem 0 0 0;
}

.btn-back {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    transition: var(--transition);
    backdrop-filter: blur(10px);
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

/* Metric Cards */
.metric-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
    height: 100%;
    border: none;
    padding: 1.5rem;
}

.metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
}

.metric-card-primary::before { background: var(--primary-gradient); }
.metric-card-success::before { background: var(--success-gradient); }
.metric-card-info::before { background: var(--info-gradient); }
.metric-card-warning::before { background: var(--warning-gradient); }
.metric-card-danger::before { background: var(--danger-gradient); }
.metric-card-secondary::before { background: var(--secondary-gradient); }

.metric-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--card-shadow-hover);
}

.metric-card-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.metric-card-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.metric-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    background: var(--primary-gradient);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: var(--transition);
}

.metric-card-primary .metric-card-icon { background: var(--primary-gradient); }
.metric-card-success .metric-card-icon { background: var(--success-gradient); }
.metric-card-info .metric-card-icon { background: var(--info-gradient); }
.metric-card-warning .metric-card-icon { background: var(--warning-gradient); }
.metric-card-danger .metric-card-icon { background: var(--danger-gradient); }
.metric-card-secondary .metric-card-icon { background: var(--secondary-gradient); }

.metric-card-info {
    display: flex;
    flex-direction: column;
}

.metric-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #495057;
    margin: 0 0 0.25rem 0;
}

.metric-card-description {
    font-size: 0.85rem;
    color: #6c757d;
    margin: 0;
    font-weight: 500;
}

.metric-card-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    text-align: right;
}

.metric-card-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
}

.metric-card-primary .metric-card-number { background: var(--primary-gradient); }
.metric-card-success .metric-card-number { background: var(--success-gradient); }
.metric-card-info .metric-card-number { background: var(--info-gradient); }
.metric-card-warning .metric-card-number { background: var(--warning-gradient); }
.metric-card-danger .metric-card-number { background: var(--danger-gradient); }
.metric-card-secondary .metric-card-number { background: var(--secondary-gradient); }

.metric-card-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: #28a745;
    background: rgba(40, 167, 69, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
}

.metric-card-trend i {
    font-size: 0.7rem;
}

.metric-card-progress {
    position: relative;
    height: 6px;
    background: #f8f9fa;
    border-radius: 3px;
    overflow: hidden;
}

.metric-card-progress .progress-bar {
    height: 100%;
    background: var(--primary-gradient);
    border-radius: 3px;
    transition: width 1.5s ease-in-out;
    animation: progressAnimation 2s ease-out;
}

.metric-card-primary .progress-bar { background: var(--primary-gradient); }
.metric-card-success .progress-bar { background: var(--success-gradient); }
.metric-card-info .progress-bar { background: var(--info-gradient); }
.metric-card-warning .progress-bar { background: var(--warning-gradient); }
.metric-card-danger .progress-bar { background: var(--danger-gradient); }
.metric-card-secondary .progress-bar { background: var(--secondary-gradient); }

@keyframes progressAnimation {
    from { width: 0%; }
    to { width: 100%; }
}

/* Content Cards */
.content-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    overflow: hidden;
    transition: var(--transition);
    height: 100%;
}

.content-card:hover {
    box-shadow: var(--card-shadow-hover);
}

.content-card-header {
    background: var(--primary-gradient);
    color: white;
    padding: 1.5rem;
    border-bottom: none;
}

.content-card-header h3 {
    font-size: 1.3rem;
    font-weight: 600;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.content-card-body {
    padding: 1.5rem;
}

/* Test Stats */
.test-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.test-stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: var(--transition);
}

.test-stat-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.test-stat-info h5 {
    font-size: 1rem;
    margin: 0 0 0.25rem 0;
    color: #495057;
}

.test-stat-info p {
    margin: 0;
    font-size: 0.9rem;
}

.test-stat-bar {
    display: flex;
    align-items: center;
    gap: 1rem;
    min-width: 150px;
}

.test-stat-bar .progress {
    flex: 1;
    height: 8px;
    border-radius: 4px;
    background: #e9ecef;
}

.test-stat-bar .progress-bar {
    background: var(--primary-gradient);
    border-radius: 4px;
    transition: width 1s ease-in-out;
}

.test-stat-bar .percentage {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6c757d;
    min-width: 40px;
    text-align: right;
}

/* Evaluator Stats */
.evaluator-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.evaluator-stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: var(--transition);
}

.evaluator-stat-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.evaluator-rank {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
}

.evaluator-info h5 {
    font-size: 1rem;
    margin: 0 0 0.25rem 0;
    color: #495057;
}

.evaluator-info p {
    margin: 0;
    font-size: 0.9rem;
}

/* Location Stats */
.location-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.location-stat-item {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: var(--transition);
}

.location-stat-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.location-info h6 {
    font-size: 1rem;
    margin: 0 0 0.25rem 0;
    color: #495057;
}

.location-info p {
    margin: 0;
    font-size: 0.9rem;
}

/* Table Styles */
.table {
    margin: 0;
}

.table th {
    border-top: none;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    border-top: 1px solid #f8f9fa;
    vertical-align: middle;
    font-size: 0.9rem;
}

.table tbody tr:hover {
    background: #f8f9fa;
}

/* Badge Styles */
.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 2rem;
    }
    
    .metric-card {
        padding: 1rem;
    }
    
    .metric-card-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .metric-card-left {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .metric-card-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .metric-card-title {
        font-size: 1rem;
        text-align: center;
    }
    
    .metric-card-description {
        font-size: 0.8rem;
        text-align: center;
    }
    
    .metric-card-right {
        align-items: center;
        text-align: center;
    }
    
    .metric-card-number {
        font-size: 2rem;
    }
    
    .metric-card-trend {
        font-size: 0.75rem;
    }
    
    .test-stat-item,
    .evaluator-stat-item,
    .location-stat-item {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .test-stat-bar {
        width: 100%;
        justify-content: center;
    }
    
    .table-responsive {
        font-size: 0.8rem;
    }
}

/* Animaciones */
.metric-card {
    animation: slideInUp 0.6s ease-out;
}

.metric-card:nth-child(1) { animation-delay: 0.1s; }
.metric-card:nth-child(2) { animation-delay: 0.2s; }
.metric-card:nth-child(3) { animation-delay: 0.3s; }
.metric-card:nth-child(4) { animation-delay: 0.4s; }
.metric-card:nth-child(5) { animation-delay: 0.5s; }
.metric-card:nth-child(6) { animation-delay: 0.6s; }

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Efectos hover adicionales */
.metric-card-icon {
    transition: var(--transition);
}

.metric-card:hover .metric-card-icon {
    transform: scale(1.1) rotate(5deg);
}

.metric-card:hover .metric-card-trend {
    transform: scale(1.05);
}

.metric-card-trend {
    transition: var(--transition);
}

.metric-card:hover .progress-bar {
    animation: progressPulse 1s ease-in-out;
}

@keyframes progressPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.evaluator-rank {
    transition: var(--transition);
}

.evaluator-stat-item:hover .evaluator-rank {
    transform: scale(1.1);
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
