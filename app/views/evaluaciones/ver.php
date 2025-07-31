<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Mensajes de éxito/error -->
            <?php if (isset($_GET['success']) && $_GET['success'] == 'finalizada'): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-lg mr-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">¡Éxito!</h5>
                            <p class="mb-0">Evaluación finalizada correctamente.</p>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'finalizar'): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-lg mr-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">¡Error!</h5>
                            <p class="mb-0">No se pudo finalizar la evaluación. Inténtalo de nuevo.</p>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Mensajes para actualización de información ambiental -->
            <?php if (isset($_GET['success']) && $_GET['success'] == 'ambiental_updated'): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-lg mr-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">¡Actualizado!</h5>
                                                         <p class="mb-0">La información de clima y temperatura de la evaluación se ha actualizado correctamente.</p>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['info']) && $_GET['info'] == 'no_changes'): ?>
                <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-lg mr-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Sin cambios</h5>
                                                         <p class="mb-0">No se realizaron cambios en el clima y temperatura.</p>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'update_failed'): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-lg mr-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">¡Error!</h5>
                                                         <p class="mb-0">No se pudo actualizar el clima y temperatura. Inténtalo de nuevo.</p>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Información de la Evaluación -->
            <div class="card shadow-sm border-0 mb-4 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">
                                <i class="fas fa-clipboard-check mr-2"></i>
                                Evaluación de <?php echo htmlspecialchars($evaluacion['nombre'] . ' ' . $evaluacion['apellido']); ?>
                            </h4>
                            <div class="d-flex flex-wrap align-items-center mt-2">
                                <span class="badge badge-light text-primary mr-3 mb-1">
                                    <i class="fas fa-calendar-alt mr-1"></i> 
                                    <?php echo date('d/m/Y', strtotime($evaluacion['fecha_evaluacion'])); ?>
                                </span>
                                <?php if ($evaluacion['hora_inicio']): ?>
                                <span class="badge badge-light text-primary mr-3 mb-1">
                                    <i class="fas fa-clock mr-1"></i> 
                                    <?php echo date('H:i', strtotime($evaluacion['hora_inicio'])); ?>
                                </span>
                                <?php endif; ?>
                                <span class="badge badge-light text-primary mb-1">
                                    <i class="fas fa-map-marker-alt mr-1"></i> 
                                    <?php echo htmlspecialchars($evaluacion['lugar_nombre'] ?? 'Sin especificar'); ?>
                                </span>
                            </div>
                        </div>
                        <span class="badge badge-<?php echo $evaluacion['estado'] == 'completada' ? 'success' : 'warning'; ?> badge-pill px-3 py-2">
                            <i class="fas fa-<?php echo $evaluacion['estado'] == 'completada' ? 'check-circle' : 'hourglass-half'; ?> mr-1"></i>
                            <?php echo ucfirst($evaluacion['estado']); ?>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Botón para editar información ambiental -->
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btnEditarAmbiental" onclick="toggleEditAmbiental()">
                            <i class="fas fa-edit"></i> Editar Clima y Temperatura
                        </button>
                    </div>

                    <!-- Vista normal (solo lectura) -->
                    <div id="infoAmbiental" class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="bg-light p-3 rounded-lg h-100">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-soft-success text-success mr-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-muted small">Lugar</h6>
                                        <p class="mb-0 font-weight-bold"><?php echo htmlspecialchars($evaluacion['lugar_nombre'] ?? 'No especificado'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="bg-light p-3 rounded-lg h-100">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-soft-primary text-primary mr-3">
                                        <i class="fas fa-cloud-sun"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-muted small">Clima</h6>
                                        <p class="mb-0 font-weight-bold"><?php echo !empty($evaluacion['clima']) ? htmlspecialchars($evaluacion['clima']) : 'No especificado'; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="bg-light p-3 rounded-lg h-100">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-soft-info text-info mr-3">
                                        <i class="fas fa-thermometer-half"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-muted small">Temperatura</h6>
                                        <p class="mb-0 font-weight-bold">
                                            <?php echo !empty($evaluacion['temperatura_ambiente']) ? 
                                                $evaluacion['temperatura_ambiente'] . '°C' : 'No registrada'; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de edición (oculto por defecto) -->
                    <div id="formAmbiental" class="d-none">
                        <form method="POST" action="index.php?controller=Evaluacion&action=actualizarAmbiental" class="needs-validation" novalidate>
                            <input type="hidden" name="evaluacion_id" value="<?php echo $evaluacion['id']; ?>">
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt me-1"></i> Lugar de Evaluación
                                    </label>
                                    <div class="form-control bg-light">
                                        <?php echo htmlspecialchars($evaluacion['lugar_nombre'] ?? 'No especificado'); ?>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> El lugar se establece según el atleta. 
                                        <div class="mt-1">
                                            <a href="index.php?controller=Atleta&action=editar&id=<?php echo $evaluacion['atleta_id']; ?>" class="text-primary">
                                                <i class="fas fa-edit"></i> Editar este atleta directamente
                                            </a>
                                            <span class="mx-2">•</span>
                                            <a href="index.php?controller=Atleta&action=listado" class="text-primary">
                                                <i class="fas fa-list"></i> Ver listado de atletas
                                            </a>
                                        </div>
                                    </small>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="clima" class="form-label fw-semibold">
                                        <i class="fas fa-cloud-sun me-1"></i> Condiciones Climáticas
                                    </label>
                                    <select class="form-control" id="clima" name="clima">
                                        <option value="">Seleccionar...</option>
                                        <option value="soleado" <?php echo ($evaluacion['clima'] == 'soleado') ? 'selected' : ''; ?>>☀️ Soleado</option>
                                        <option value="nublado" <?php echo ($evaluacion['clima'] == 'nublado') ? 'selected' : ''; ?>>☁️ Nublado</option>
                                        <option value="parcialmente_nublado" <?php echo ($evaluacion['clima'] == 'parcialmente_nublado') ? 'selected' : ''; ?>>⛅ Parcialmente Nublado</option>
                                        <option value="lluvioso" <?php echo ($evaluacion['clima'] == 'lluvioso') ? 'selected' : ''; ?>>🌧️ Lluvioso</option>
                                        <option value="ventoso" <?php echo ($evaluacion['clima'] == 'ventoso') ? 'selected' : ''; ?>>💨 Ventoso</option>
                                        <option value="caluroso" <?php echo ($evaluacion['clima'] == 'caluroso') ? 'selected' : ''; ?>>🔥 Caluroso</option>
                                        <option value="frio" <?php echo ($evaluacion['clima'] == 'frio') ? 'selected' : ''; ?>>🌡️ Frío</option>
                                    </select>
                                    <small class="form-text text-muted">
                                        Condiciones climáticas durante la evaluación
                                    </small>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="temperatura_ambiente" class="form-label fw-semibold">
                                        <i class="fas fa-thermometer-half me-1"></i> Temperatura Ambiente (°C)
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="temperatura_ambiente" 
                                           name="temperatura_ambiente" 
                                           min="-10" 
                                           max="50" 
                                           step="0.1"
                                           value="<?php echo htmlspecialchars($evaluacion['temperatura_ambiente'] ?? ''); ?>"
                                           placeholder="Ej: 22.5">
                                    <small class="form-text text-muted">
                                        Temperatura en grados Celsius
                                    </small>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" class="btn btn-secondary" onclick="cancelarEditAmbiental()">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <?php if ($evaluacion['hora_fin']): ?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="bg-light p-3 rounded-lg h-100">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-soft-success text-success mr-3">
                                        <i class="fas fa-flag-checkered"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-muted small">Finalizada a las</h6>
                                        <p class="mb-0 font-weight-bold">
                                            <?php echo date('H:i', strtotime($evaluacion['hora_fin'])); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($evaluacion['observaciones']): ?>
                    <div class="mt-4">
                        <h6 class="text-uppercase text-muted mb-3">
                            <i class="far fa-comment-dots mr-2"></i> Observaciones
                        </h6>
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <?php echo nl2br(htmlspecialchars($evaluacion['observaciones'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

            <!-- Tests Realizados -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line text-primary mr-2"></i> Tests Realizados
                            <span class="badge badge-primary badge-pill ml-2"><?php echo count($resultados); ?></span>
                        </h5>
                        <?php if (!empty($resultados)): ?>
                        <a href="index.php?controller=Test&action=catalogo" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus mr-1"></i> Agregar Test
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($resultados)): ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-clipboard-list fa-4x text-muted opacity-25"></i>
                            </div>
                            <h5 class="text-muted mb-3">No hay tests realizados aún</h5>
                            <p class="text-muted mb-4">Comienza agregando tests a esta evaluación para ver los resultados.</p>
                            <a href="index.php?controller=Test&action=catalogo" class="btn btn-primary px-4">
                                <i class="fas fa-plus mr-2"></i> Agregar Test
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">Test</th>
                                        <th class="border-0">Fecha/Hora</th>
                                        <th class="border-0">Descripción</th>
                                        <th class="border-0">Resultado</th>
                                        <th class="border-0 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resultados as $resultado): 
                                        $resultadosJson = json_decode($resultado['resultado_json'], true);
                                    ?>
                                        <tr class="border-bottom">
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-soft-primary text-primary mr-3">
                                                        <i class="fas fa-tasks"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 font-weight-bold"><?php echo htmlspecialchars($resultado['nombre_test']); ?></h6>
                                                        <small class="text-muted">
                                                            <?php echo htmlspecialchars($resultado['categoria'] ?? 'Sin categoría'); ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex flex-column">
                                                    <small class="text-muted">
                                                        <?php echo date('d/m/Y', strtotime($resultado['fecha_test'])); ?>
                                                    </small>
                                                    <small class="text-muted">
                                                        <?php echo date('H:i', strtotime($resultado['fecha_test'])); ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <small class="text-muted">
                                                    <?php echo !empty($resultado['descripcion']) ? 
                                                        htmlspecialchars($resultado['descripcion']) : 
                                                        '<span class="text-muted">Sin descripción</span>'; ?>
                                                </small>
                                            </td>
                                            <td class="align-middle">
                                                <?php if ($resultadosJson && is_array($resultadosJson)): ?>
                                                    <div class="d-flex flex-wrap">
                                                        <?php 
                                                        $count = 0;
                                                        foreach ($resultadosJson as $key => $value): 
                                                            if ($count < 2): // Mostrar solo los primeros 2 resultados
                                                        ?>
                                                            <span class="badge badge-light text-dark border mr-2 mb-1">
                                                                <strong><?php echo htmlspecialchars($key); ?>:</strong> 
                                                                <?php echo htmlspecialchars($value); ?>
                                                            </span>
                                                        <?php 
                                                                $count++;
                                                            endif;
                                                        endforeach; 
                                                        if (count($resultadosJson) > 2): ?>
                                                            <span class="badge badge-light text-muted">
                                                                +<?php echo count($resultadosJson) - 2; ?> más
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="badge badge-light text-muted">Sin datos</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle text-right">
                                                <a href="index.php?controller=Test&action=ver&id=<?php echo $resultado['id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   data-toggle="tooltip" 
                                                   title="Ver detalles del test">
                                                    <i class="fas fa-eye"></i>
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
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-4">
                    <?php if ($evaluacion['estado'] != 'completada'): ?>
                        <form method="POST" action="index.php?controller=Evaluacion&action=finalizar" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de que deseas marcar esta evaluación como completada? No podrás agregar más tests después de esto.');">
                            <input type="hidden" name="evaluacion_id" value="<?php echo $evaluacion['id']; ?>">
                            <button type="submit" class="btn btn-success btn-lg px-4 mr-3" 
                                    onclick="return confirm('¿Estás seguro de que deseas finalizar esta evaluación?')">
                                <i class="fas fa-check-circle"></i> Finalizar Evaluación
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="index.php?controller=Test&action=catalogo&evaluacion_id=<?php echo $evaluacion['id']; ?>" 
                       class="btn btn-primary btn-lg mr-2">
                        <i class="fas fa-plus"></i> Agregar Test
                    </a>

                    <a href="index.php?controller=Test&action=resultados" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="fas fa-arrow-left mr-2"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos generales */
body {
    background-color: #f8f9fa;
}

/* Tarjetas */
.card {
    border: none;
    border-radius: 0.5rem;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05) !important;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    font-weight: 600;
}

/* Iconos */
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
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

/* Formulario de edición ambiental */
.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control {
    border-radius: 6px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.gap-2 {
    gap: 0.5rem !important;
}

.bg-soft-primary { background-color: rgba(0, 123, 255, 0.1); }
.bg-soft-success { background-color: rgba(40, 167, 69, 0.1); }
.bg-soft-info { background-color: rgba(23, 162, 184, 0.1); }
</style>

<script>
function toggleEditAmbiental() {
    const infoDiv = document.getElementById('infoAmbiental');
    const formDiv = document.getElementById('formAmbiental');
    const btnEditar = document.getElementById('btnEditarAmbiental');
    
    if (infoDiv.classList.contains('d-none')) {
        // Mostrar vista normal, ocultar formulario
        infoDiv.classList.remove('d-none');
        formDiv.classList.add('d-none');
        btnEditar.innerHTML = '<i class="fas fa-edit"></i> Editar Clima y Temperatura';
    } else {
        // Mostrar formulario, ocultar vista normal
        infoDiv.classList.add('d-none');
        formDiv.classList.remove('d-none');
        btnEditar.innerHTML = '<i class="fas fa-eye"></i> Ver Información';
    }
}

function cancelarEditAmbiental() {
    const infoDiv = document.getElementById('infoAmbiental');
    const formDiv = document.getElementById('formAmbiental');
    const btnEditar = document.getElementById('btnEditarAmbiental');
    
    // Mostrar vista normal, ocultar formulario
    infoDiv.classList.remove('d-none');
    formDiv.classList.add('d-none');
    btnEditar.innerHTML = '<i class="fas fa-edit"></i> Editar Clima y Temperatura';
    
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

// Validación del formulario
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 