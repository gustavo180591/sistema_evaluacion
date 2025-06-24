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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_evaluacion">
                                        <i class="fas fa-calendar"></i> Fecha de Evaluación *
                                    </label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="fecha_evaluacion" 
                                           name="fecha_evaluacion" 
                                           value="<?php echo date('Y-m-d'); ?>" 
                                           required>
                                    <div class="invalid-feedback">
                                        Por favor, selecciona una fecha válida.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
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
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
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

                        <div class="form-group text-center">
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