<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Mensajes de error -->
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php if ($_GET['error'] == 'evaluacion_no_autorizada'): ?>
                        No tienes permisos para acceder a esa evaluación.
                    <?php else: ?>
                        Ha ocurrido un error.
                    <?php endif; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-clipboard-list"></i> Mis Evaluaciones
                        </h4>
                        <a href="index.php?controller=Atleta&action=listado" class="btn btn-success">
                            <i class="fas fa-plus"></i> Nueva Evaluación
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($evaluaciones)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-4x text-muted"></i>
                            <h4 class="mt-4 text-muted">No hay evaluaciones registradas</h4>
                            <p class="text-muted">Comienza creando una nueva evaluación para uno de tus atletas.</p>
                            <a href="index.php?controller=Atleta&action=listado" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus"></i> Crear Primera Evaluación
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Atleta</th>
                                        <th>Fecha</th>
                                        <th>Lugar</th>
                                        <th>Estado</th>
                                        <th>Tests</th>
                                        <th>Clima</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($evaluaciones as $evaluacion): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($evaluacion['nombre'] . ' ' . $evaluacion['apellido']); ?></strong>
                                            </td>
                                            <td>
                                                <span class="text-nowrap">
                                                    <i class="fas fa-calendar text-muted"></i>
                                                    <?php echo date('d/m/Y', strtotime($evaluacion['fecha_evaluacion'])); ?>
                                                </span>
                                                <?php if ($evaluacion['hora_inicio']): ?>
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-clock"></i> 
                                                        <?php echo date('H:i', strtotime($evaluacion['hora_inicio'])); ?>
                                                        <?php if ($evaluacion['hora_fin']): ?>
                                                            - <?php echo date('H:i', strtotime($evaluacion['hora_fin'])); ?>
                                                        <?php endif; ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small>
                                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                                    <?php echo htmlspecialchars($evaluacion['lugar_nombre'] ?? 'Sin especificar'); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo $evaluacion['estado'] == 'completada' ? 'success' : 'warning'; ?>">
                                                    <?php echo ucfirst($evaluacion['estado']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-info">
                                                    <?php echo $evaluacion['total_tests'] ?? 0; ?>
                                                </span>
                                                <?php if (!empty($evaluacion['tests_realizados'])): ?>
                                                    <br><small class="text-muted" title="<?php echo htmlspecialchars($evaluacion['tests_realizados']); ?>">
                                                        <?php 
                                                        $tests = explode(', ', $evaluacion['tests_realizados']);
                                                        echo htmlspecialchars(implode(', ', array_slice($tests, 0, 2)));
                                                        if (count($tests) > 2) echo '...';
                                                        ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($evaluacion['clima']): ?>
                                                    <small>
                                                        <?php
                                                        $iconos_clima = [
                                                            'soleado' => '☀️',
                                                            'nublado' => '☁️',
                                                            'parcialmente_nublado' => '⛅',
                                                            'lluvioso' => '🌧️',
                                                            'ventoso' => '💨'
                                                        ];
                                                        echo $iconos_clima[$evaluacion['clima']] ?? '';
                                                        echo ' ' . htmlspecialchars($evaluacion['clima']);
                                                        ?>
                                                    </small>
                                                    <?php if ($evaluacion['temperatura_ambiente']): ?>
                                                        <br><small class="text-muted">
                                                            🌡️ <?php echo $evaluacion['temperatura_ambiente']; ?>°C
                                                        </small>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="index.php?controller=Evaluacion&action=ver&id=<?php echo $evaluacion['id']; ?>" 
                                                       class="btn btn-primary btn-sm" title="Ver Evaluación">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if ($evaluacion['estado'] != 'completada'): ?>
                                                        <a href="index.php?controller=Test&action=catalogo&evaluacion_id=<?php echo $evaluacion['id']; ?>" 
                                                           class="btn btn-success btn-sm" title="Agregar Test">
                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($evaluaciones)): ?>
                    <div class="card-footer text-muted">
                        <div class="row">
                            <div class="col-md-6">
                                <small>
                                    <i class="fas fa-info-circle"></i> 
                                    Total de evaluaciones: <strong><?php echo count($evaluaciones); ?></strong>
                                </small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small>
                                    <i class="fas fa-clock"></i> 
                                    Última actualización: <?php echo date('d/m/Y H:i'); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.table td {
    vertical-align: middle;
}

.table th {
    border-top: none;
    background-color: #f8f9fa;
    font-weight: 600;
}

.btn-group .btn {
    margin: 1px;
}

.badge {
    font-size: 0.8rem;
}

.card-header h4 {
    display: flex;
    align-items: center;
}

.text-nowrap {
    white-space: nowrap;
}

/* Mejorar visibilidad de los botones */
.btn-group .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-group .btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-group .btn:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        margin: 1px 0;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>

<script>
// Inicializar tooltips si Bootstrap está disponible
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $('[title]').tooltip === 'function') {
        $('[title]').tooltip();
    }
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 