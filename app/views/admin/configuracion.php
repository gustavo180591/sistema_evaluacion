<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-cogs text-primary"></i> Configuración del Sistema
                    </h1>
                    <p class="text-muted mb-0">
                        Gestiona los parámetros y configuraciones generales del sistema de evaluación
                        <?php if ($_SESSION['rol'] === 'evaluador'): ?>
                            <br><small class="text-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Vista de solo lectura - Para cambios contacte al administrador
                            </small>
                        <?php endif; ?>
                    </p>
                </div>
                <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>

            <!-- Alertas -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-<?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
                        <div>
                            <strong><?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'Éxito:' : 'Error:'; ?></strong>
                            <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php 
                unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); 
                ?>
            <?php endif; ?>

            <!-- Secciones de Configuración -->
            <div class="row g-4">
                
                <!-- CONFIGURACIÓN DEL SISTEMA -->
                <div class="col-lg-6">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-desktop me-2"></i> Sistema General
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Nombre del Sistema</strong>
                                        <br><small class="text-muted"><?php echo htmlspecialchars($configuraciones['sistema']['nombre_sistema']); ?></small>
                                    </div>
                                    <span class="badge bg-info">Activo</span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Zona Horaria</strong>
                                        <br><small class="text-muted"><?php echo htmlspecialchars($configuraciones['sistema']['zona_horaria']); ?></small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-clock me-1"></i> Buenos Aires
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Versión PHP</strong>
                                        <br><small class="text-muted">Motor de la aplicación</small>
                                    </div>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($configuraciones['sistema']['version_php']); ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Fecha y Hora Actual</strong>
                                        <br><small class="text-muted">Tiempo del servidor</small>
                                    </div>
                                    <span class="badge bg-light text-dark"><?php echo htmlspecialchars($configuraciones['sistema']['fecha_actual']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONFIGURACIÓN DE BASE DE DATOS -->
                <div class="col-lg-6">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-database me-2"></i> Base de Datos
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Motor de BD</strong>
                                        <br><small class="text-muted">Sistema de gestión</small>
                                    </div>
                                    <span class="badge bg-success"><?php echo htmlspecialchars($configuraciones['base_datos']['motor']); ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Host</strong>
                                        <br><small class="text-muted">Servidor de base de datos</small>
                                    </div>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($configuraciones['base_datos']['host']); ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Puerto</strong>
                                        <br><small class="text-muted">Puerto de conexión</small>
                                    </div>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($configuraciones['base_datos']['puerto']); ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Charset</strong>
                                        <br><small class="text-muted">Codificación de caracteres</small>
                                    </div>
                                    <span class="badge bg-info"><?php echo htmlspecialchars($configuraciones['base_datos']['charset']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONFIGURACIÓN DE EVALUACIONES -->
                <div class="col-lg-6">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clipboard-check me-2"></i> Evaluaciones
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Duración Máxima</strong>
                                        <br><small class="text-muted">Tiempo límite por evaluación</small>
                                    </div>
                                    <span class="badge bg-warning"><?php echo htmlspecialchars($configuraciones['evaluaciones']['duracion_maxima']); ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Tests Simultáneos</strong>
                                        <br><small class="text-muted">Cantidad máxima por evaluación</small>
                                    </div>
                                    <span class="badge bg-success"><?php echo htmlspecialchars($configuraciones['evaluaciones']['tests_simultaneos']); ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Guardado Automático</strong>
                                        <br><small class="text-muted">AJAX individual por test</small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> <?php echo htmlspecialchars($configuraciones['evaluaciones']['guardado_automatico']); ?>
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Validación en Tiempo Real</strong>
                                        <br><small class="text-muted">Validación de campos instantánea</small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> <?php echo htmlspecialchars($configuraciones['evaluaciones']['validacion_tiempo_real']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONFIGURACIÓN DE ATLETAS -->
                <div class="col-lg-6">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-users me-2"></i> Gestión de Atletas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Eliminación Suave</strong>
                                        <br><small class="text-muted">Los atletas se ocultan, no se eliminan</small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-eye-slash me-1"></i> <?php echo htmlspecialchars($configuraciones['atletas']['soft_delete']); ?>
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Edición Flexible</strong>
                                        <br><small class="text-muted">Cualquier evaluador puede editar</small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-edit me-1"></i> <?php echo htmlspecialchars($configuraciones['atletas']['edicion_flexible']); ?>
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div>
                                    <strong>Campos Obligatorios</strong>
                                    <br><small class="text-muted">
                                        <?php echo implode(', ', $configuraciones['atletas']['campos_obligatorios']); ?>
                                    </small>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div>
                                    <strong>Campos Opcionales</strong>
                                    <br><small class="text-muted">
                                        <?php echo implode(', ', $configuraciones['atletas']['campos_opcionales']); ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONFIGURACIÓN DE TESTS -->
                <div class="col-lg-6">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-danger text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-running me-2"></i> Tests Físicos
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="config-item">
                                <div>
                                    <strong>Tipos Disponibles</strong>
                                    <br><small class="text-muted"><?php echo htmlspecialchars($configuraciones['tests']['tipos_disponibles']); ?></small>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div>
                                    <strong>Tests Sin Campo Tiempo</strong>
                                    <br><small class="text-muted">
                                        <?php echo implode(', ', $configuraciones['tests']['campos_sin_tiempo']); ?>
                                    </small>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Unidades Dinámicas</strong>
                                        <br><small class="text-muted">Unidades desde base de datos</small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i> <?php echo htmlspecialchars($configuraciones['tests']['unidades_dinamicas']); ?>
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Guardado Individual</strong>
                                        <br><small class="text-muted">Cada test se guarda por separado</small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-save me-1"></i> <?php echo htmlspecialchars($configuraciones['tests']['guardado_individual']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONFIGURACIÓN DE SEGURIDAD -->
                <div class="col-lg-6">
                    <div class="card h-100 shadow border-0">
                        <div class="card-header bg-dark text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-shield-alt me-2"></i> Seguridad y Accesos
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Gestión de Sesiones</strong>
                                        <br><small class="text-muted">Sistema de autenticación</small>
                                    </div>
                                    <span class="badge bg-primary"><?php echo htmlspecialchars($configuraciones['seguridad']['sesiones']); ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Método de Autenticación</strong>
                                        <br><small class="text-muted">Credenciales requeridas</small>
                                    </div>
                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($configuraciones['seguridad']['autenticacion']); ?></span>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div>
                                    <strong>Roles del Sistema</strong>
                                    <br><small class="text-muted">
                                        <?php echo implode(', ', $configuraciones['seguridad']['roles']); ?>
                                    </small>
                                </div>
                            </div>
                            <hr>
                            <div class="config-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Permisos Flexibles</strong>
                                        <br><small class="text-muted">Evaluadores pueden gestionar cualquier atleta</small>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-unlock me-1"></i> <?php echo htmlspecialchars($configuraciones['seguridad']['permisos_flexibles']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Acciones Rápidas -->
            <div class="card mt-4 shadow border-0">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tools me-2"></i> Acciones de Configuración
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="index.php?controller=Admin&action=usuarios" class="btn btn-outline-primary">
                                    <i class="fas fa-users me-2"></i> Gestionar Usuarios
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="index.php?controller=Admin&action=tests" class="btn btn-outline-success">
                                    <i class="fas fa-running me-2"></i> Configurar Tests
                                </a>
                            </div>
                        </div>
<?php if ($_SESSION['rol'] === 'administrador'): ?>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="index.php?controller=Admin&action=gestionarLugares" class="btn btn-outline-warning">
                                    <i class="fas fa-map-marker-alt me-2"></i> Gestionar Lugares
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="index.php?controller=Admin&action=estadisticas" class="btn btn-outline-info">
                                    <i class="fas fa-chart-bar me-2"></i> Ver Estadísticas
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="index.php?controller=Evaluador&action=listado" class="btn btn-outline-warning">
                                    <i class="fas fa-user-check me-2"></i> Gestionar Evaluadores
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary">
                                    <i class="fas fa-running me-2"></i> Ver Todos los Atletas
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="index.php?controller=Evaluacion&action=listado" class="btn btn-outline-primary">
                                    <i class="fas fa-clipboard-list me-2"></i> Todas las Evaluaciones
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado del Sistema -->
            <div class="card mt-4 shadow border-0">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-heartbeat text-success me-2"></i> Estado del Sistema
                    </h5>
                </div>
                <div class="card-body">
                                         <div class="row g-3">
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-users text-success fs-2"></i>
                                <div class="mt-2">
                                    <strong><?php echo number_format($estadisticas['total_atletas']); ?></strong>
                                    <br><small class="text-muted">Atletas registrados</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-clipboard-list text-primary fs-2"></i>
                                <div class="mt-2">
                                    <strong><?php echo number_format($estadisticas['total_evaluaciones']); ?></strong>
                                    <br><small class="text-muted">Evaluaciones realizadas</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-running text-warning fs-2"></i>
                                <div class="mt-2">
                                    <strong><?php echo number_format($estadisticas['total_tests']); ?></strong>
                                    <br><small class="text-muted">Tests disponibles</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <i class="fas fa-user-check text-info fs-2"></i>
                                <div class="mt-2">
                                    <strong><?php echo number_format($estadisticas['total_usuarios']); ?></strong>
                                    <br><small class="text-muted">Usuarios del sistema</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer de Información -->
            <div class="alert alert-light mt-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle text-primary me-3"></i>
                    <div>
                        <strong>Información del Sistema:</strong>
                        Esta página muestra la configuración actual del sistema. Las configuraciones se gestionan desde archivos de configuración y base de datos.
                        Para cambios avanzados, consulte con el administrador técnico.
                        <br><small class="text-muted mt-1">
                            Última actualización: <?php echo date('d/m/Y H:i:s'); ?> (Buenos Aires)
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.config-item {
    padding: 0.5rem 0;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-size: 0.8rem;
}

.alert {
    border-radius: 8px;
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 