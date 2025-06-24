<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Mensajes de éxito/error -->
            <?php if (isset($_GET['success']) && $_GET['success'] == 'finalizada'): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> Evaluación finalizada correctamente.
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'finalizar'): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i> Error al finalizar la evaluación.
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <!-- Información de la Evaluación -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-clipboard-list"></i> Evaluación de <?php echo htmlspecialchars($evaluacion['nombre'] . ' ' . $evaluacion['apellido']); ?>
                    </h4>
                    <small>
                        <i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($evaluacion['fecha_evaluacion'])); ?>
                        <?php if ($evaluacion['hora_inicio']): ?>
                            - <i class="fas fa-clock"></i> <?php echo date('H:i', strtotime($evaluacion['hora_inicio'])); ?>
                        <?php endif; ?>
                        - <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($evaluacion['lugar_nombre'] ?? 'Sin especificar'); ?>
                    </small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Estado:</strong>
                            <span class="badge badge-<?php echo $evaluacion['estado'] == 'completada' ? 'success' : 'warning'; ?> badge-lg">
                                <?php echo ucfirst($evaluacion['estado']); ?>
                            </span>
                        </div>
                        <div class="col-md-3">
                            <?php if ($evaluacion['clima']): ?>
                                <strong>Clima:</strong> <?php echo htmlspecialchars($evaluacion['clima']); ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-3">
                            <?php if ($evaluacion['temperatura_ambiente']): ?>
                                <strong>Temperatura:</strong> <?php echo $evaluacion['temperatura_ambiente']; ?>°C
                            <?php endif; ?>
                        </div>
                        <div class="col-md-3">
                            <?php if ($evaluacion['hora_fin']): ?>
                                <strong>Finalizada:</strong> <?php echo date('H:i', strtotime($evaluacion['hora_fin'])); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($evaluacion['observaciones']): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <strong>Observaciones:</strong>
                                <p class="mt-2 p-3 bg-light rounded"><?php echo nl2br(htmlspecialchars($evaluacion['observaciones'])); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tests Realizados -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line"></i> Tests Realizados
                        <span class="badge badge-info ml-2"><?php echo count($resultados); ?></span>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($resultados)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-info-circle fa-3x text-muted"></i>
                            <h5 class="mt-3 text-muted">No hay tests realizados aún</h5>
                            <p class="text-muted">Comienza agregando tests a esta evaluación.</p>
                            <a href="index.php?controller=Test&action=catalogo" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Agregar Test
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Test</th>
                                        <th>Fecha/Hora</th>
                                        <th>Descripción</th>
                                        <th>Resultado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resultados as $resultado): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($resultado['nombre_test']); ?></strong>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?php echo date('d/m/Y', strtotime($resultado['fecha_test'])); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?php echo htmlspecialchars($resultado['descripcion'] ?? 'Sin descripción'); ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?php 
                                                $resultadosJson = json_decode($resultado['resultado_json'], true);
                                                if ($resultadosJson && is_array($resultadosJson)):
                                                    foreach ($resultadosJson as $key => $value):
                                                        echo '<small><strong>' . htmlspecialchars($key) . ':</strong> ' . htmlspecialchars($value) . '<br></small>';
                                                    endforeach;
                                                else:
                                                    echo '<span class="text-muted">Sin datos</span>';
                                                endif;
                                                ?>
                                            </td>
                                            <td>
                                                <a href="index.php?controller=Test&action=ver&id=<?php echo $resultado['id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Acciones -->
            <div class="card mt-4">
                <div class="card-body text-center">
                    <?php if ($evaluacion['estado'] != 'completada'): ?>
                        <form method="POST" action="index.php?controller=Evaluacion&action=finalizar" class="d-inline">
                            <input type="hidden" name="evaluacion_id" value="<?php echo $evaluacion['id']; ?>">
                            <button type="submit" class="btn btn-success btn-lg mr-2" 
                                    onclick="return confirm('¿Estás seguro de que deseas finalizar esta evaluación?')">
                                <i class="fas fa-check-circle"></i> Finalizar Evaluación
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="index.php?controller=Test&action=catalogo&evaluacion_id=<?php echo $evaluacion['id']; ?>" 
                       class="btn btn-primary btn-lg mr-2">
                        <i class="fas fa-plus"></i> Agregar Test
                    </a>

                    <a href="index.php?controller=Evaluacion&action=listado" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}

.card-header h4 {
    display: flex;
    align-items: center;
}

.card-header small {
    opacity: 0.9;
}

.btn-lg {
    padding: 12px 24px;
    font-size: 1.1rem;
}

.table th {
    border-top: none;
    background-color: #f8f9fa;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 