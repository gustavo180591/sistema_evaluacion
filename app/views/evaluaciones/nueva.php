<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle"></i> Nueva Evaluación
                    </h4>
                    <small>Atleta: <?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></small>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fecha_evaluacion">
                                    <i class="fas fa-calendar"></i> Fecha de Evaluación *
                                </label>
                                <input type="date" 
                                       class="form-control" 
                                       id="fecha_evaluacion" 
                                       name="fecha_evaluacion" 
                                       value="<?php echo date('Y-m-d'); ?>" 
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hora_inicio">
                                    <i class="fas fa-clock"></i> Hora de Inicio
                                </label>
                                <input type="time" 
                                       class="form-control" 
                                       id="hora_inicio" 
                                       name="hora_inicio" 
                                       value="<?php echo date('H:i'); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lugar_id">
                                        <i class="fas fa-map-marker-alt"></i> Lugar de Evaluación
                                    </label>
                                    <select class="form-control" id="lugar_id" name="lugar_id">
                                        <?php foreach ($lugares as $lugar): ?>
                                            <option value="<?php echo $lugar['id']; ?>" 
                                                    <?php echo ($lugar['id'] == $atleta['lugar_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($lugar['nombre']); ?>
                                                <?php if ($lugar['zona']): ?>
                                                    - <?php echo htmlspecialchars($lugar['zona']); ?>
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-muted">
                                        Por defecto se selecciona el lugar asociado al atleta, pero puedes cambiarlo si es necesario.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clima">
                                        <i class="fas fa-cloud-sun"></i> Condiciones Climáticas
                                    </label>
                                    <select class="form-control" id="clima" name="clima">
                                        <option value="">Seleccionar...</option>
                                        <option value="soleado">☀️ Soleado</option>
                                        <option value="nublado">☁️ Nublado</option>
                                        <option value="parcialmente_nublado">⛅ Parcialmente Nublado</option>
                                        <option value="lluvioso">🌧️ Lluvioso</option>
                                        <option value="ventoso">💨 Ventoso</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="temperatura_ambiente">
                                        <i class="fas fa-thermometer-half"></i> Temperatura Ambiente (°C)
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="temperatura_ambiente" 
                                           name="temperatura_ambiente" 
                                           min="-10" 
                                           max="50" 
                                           step="0.1"
                                           placeholder="Ej: 22.5">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">
                                <i class="fas fa-sticky-note"></i> Observaciones Iniciales
                            </label>
                            <textarea class="form-control" 
                                      id="observaciones" 
                                      name="observaciones" 
                                      rows="3" 
                                      placeholder="Observaciones sobre el estado del atleta, condiciones especiales, etc."></textarea>
                        </div>

                        <!-- Sección de Tests Disponibles -->
                        <div class="form-group">
                            <label class="d-block mb-3">
                                <i class="fas fa-clipboard-list text-success"></i> Tests Disponibles
                                <small class="text-muted">Selecciona un test para comenzar</small>
                            </label>
                            
                            <div class="tests-container">
                                <?php if (!empty($tests)): ?>
                                    <?php foreach ($tests as $categoria => $testList): ?>
                                        <div class="test-category mb-4">
                                            <h6 class="category-title">
                                                <i class="fas fa-folder-open text-muted mr-2"></i>
                                                <?php echo ucfirst($categoria); ?>
                                            </h6>
                                            <div class="test-list">
                                                <?php foreach ($testList as $test): ?>
                                                    <a href="<?php echo $test['url']; ?>" class="test-item">
                                                        <div class="test-icon">
                                                            <i class="fas fa-<?php echo $test['icono']; ?>"></i>
                                                        </div>
                                                        <div class="test-details">
                                                            <div class="test-name"><?php echo $test['nombre']; ?></div>
                                                            <div class="test-desc"><?php echo $test['descripcion']; ?></div>
                                                        </div>
                                                        <div class="test-arrow">
                                                            <i class="fas fa-chevron-right"></i>
                                                        </div>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> No hay tests disponibles en este momento.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-play-circle"></i> Iniciar Evaluación
                            </button>
                            <a href="index.php?controller=Atleta&action=listado" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-header {
    border-bottom: 3px solid #28a745;
}

.form-group label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

/* Estilos para la lista de tests */
.tests-container {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    overflow: hidden;
}

.test-category {
    padding: 0 1rem;
}

.test-category:not(:last-child) {
    border-bottom: 1px solid #f0f0f0;
}

.category-title {
    color: #495057;
    font-weight: 600;
    padding: 1rem 0 0.5rem;
    margin: 0;
    display: flex;
    align-items: center;
}

.test-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding-bottom: 1rem;
}

.test-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    border-radius: 6px;
    background: #f8f9fa;
    text-decoration: none;
    color: #333;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.test-item:hover {
    background: #fff;
    border-color: #28a745;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transform: translateY(-1px);
    text-decoration: none;
    color: #333;
}

.test-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e9f5ee;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: #28a745;
    flex-shrink: 0;
}

.test-details {
    flex-grow: 1;
}

.test-name {
    font-weight: 500;
    margin-bottom: 2px;
}

.test-desc {
    font-size: 0.8rem;
    color: #6c757d;
}

.test-arrow {
    color: #adb5bd;
    padding-left: 0.5rem;
    transition: transform 0.2s ease;
}

.test-item:hover .test-arrow {
    transform: translateX(3px);
    color: #28a745;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    padding: 12px 30px;
    font-size: 1.1rem;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.btn-secondary {
    padding: 12px 30px;
    font-size: 1.1rem;
}
</style>

<script>
// Validación del formulario
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 