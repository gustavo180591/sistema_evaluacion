<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Estadísticas del Sistema</h1>
                <a href="index.php?controller=Dashboard&action=index" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['mensaje']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
            <?php endif; ?>

            <!-- Tarjetas de Estadísticas -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total de Atletas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($cantidadAtletas); ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Tests Realizados
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($cantidadResultados); ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Evaluadores Activos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo isset($cantidadEvaluadores) ? number_format($cantidadEvaluadores) : 'N/A'; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Evaluaciones Pendientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo isset($evaluacionesPendientes) ? number_format($evaluacionesPendientes) : 'N/A'; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos y Estadísticas Detalladas -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Resumen del Sistema</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Atletas Registrados</strong></td>
                                            <td class="text-right"><?php echo number_format($cantidadAtletas); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tests Completados</strong></td>
                                            <td class="text-right"><?php echo number_format($cantidadResultados); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Promedio de Tests por Atleta</strong></td>
                                            <td class="text-right">
                                                <?php 
                                                if ($cantidadAtletas > 0) {
                                                    echo number_format($cantidadResultados / $cantidadAtletas, 1);
                                                } else {
                                                    echo '0';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <a href="index.php?controller=Atleta&action=listado" class="btn btn-primary btn-block">
                                        <i class="fas fa-users"></i> Gestionar Atletas
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="index.php?controller=Evaluador&action=listado" class="btn btn-success btn-block">
                                        <i class="fas fa-user-tie"></i> Gestionar Evaluadores
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="index.php?controller=Admin&action=usuarios" class="btn btn-info btn-block">
                                        <i class="fas fa-user-cog"></i> Gestionar Usuarios
                                    </a>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="index.php?controller=Test&action=catalogo" class="btn btn-warning btn-block">
                                        <i class="fas fa-clipboard-list"></i> Catálogo de Tests
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Información del Sistema</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Versión del Sistema</h6>
                                    <p class="text-muted">Sistema de Evaluación Física v1.0</p>
                                    
                                    <h6>Base de Datos</h6>
                                    <p class="text-muted">MySQL 8.0</p>
                                    
                                    <h6>Servidor Web</h6>
                                    <p class="text-muted">Apache + PHP 8.1</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Última Actualización</h6>
                                    <p class="text-muted"><?php echo date('d/m/Y H:i:s'); ?></p>
                                    
                                    <h6>Estado del Sistema</h6>
                                    <p class="text-success"><i class="fas fa-check-circle"></i> Operativo</p>
                                    
                                    <h6>Mantenimiento</h6>
                                    <p class="text-muted">No programado</p>
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
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.font-weight-bold {
    font-weight: 700 !important;
}

.text-xs {
    font-size: 0.7rem;
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1.25rem;
}

.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 