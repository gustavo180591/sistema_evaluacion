<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-clipboard-check"></i> 
                                <?php echo htmlspecialchars($test_info['nombre'] ?? 'Test Físico'); ?>
                            </h4>
                            <small>Atleta: <?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></small>
                        </div>
                        <a href="index.php?controller=Evaluacion&action=nueva&atleta_id=<?php echo $atleta['id']; ?>" 
                           class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver a Evaluación
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!$test_info): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            <strong>Error:</strong> No se pudo cargar la información del test solicitado.
                        </div>
                        <div class="text-center">
                            <a href="index.php?controller=Atleta&action=listado" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Volver al listado de atletas
                            </a>
                        </div>
                    <?php else: ?>
                    

                    <div class="row">
                        <div class="col-md-8">
                            <div class="test-description mb-4">
                                <h5><i class="fas fa-info-circle text-primary"></i> Descripción del Test</h5>
                                <p class="text-muted">
                                    <?php echo htmlspecialchars($test_info['descripcion'] ?? 'Descripción del test no disponible'); ?>
                                </p>
                            </div>

                            <form method="POST" class="needs-validation" novalidate>
                                <div class="form-section">
                                    <h5><i class="fas fa-edit text-success"></i> Datos del Test</h5>
                                    
                                    <?php 
                                    $resultado_existente_data = [];
                                    if ($resultado_existente && $resultado_existente['resultado_json']) {
                                        $resultado_existente_data = json_decode($resultado_existente['resultado_json'], true);
                                    }
                                    ?>
                                    
                                    <?php if (isset($test_info['campos']) && is_array($test_info['campos'])): ?>
                                        <?php foreach ($test_info['campos'] as $campo => $config): ?>
                                        <div class="form-group">
                                            <label for="<?php echo $campo; ?>">
                                                <i class="fas fa-ruler"></i> <?php echo htmlspecialchars($config['label']); ?>
                                            </label>
                                            <input type="<?php echo $config['type']; ?>" 
                                                   class="form-control" 
                                                   id="<?php echo $campo; ?>" 
                                                   name="resultados[<?php echo $campo; ?>]" 
                                                   value="<?php echo htmlspecialchars($resultado_existente_data[$campo] ?? ''); ?>"
                                                   <?php if (isset($config['step'])): ?>step="<?php echo $config['step']; ?>"<?php endif; ?>
                                                   <?php if (isset($config['min'])): ?>min="<?php echo $config['min']; ?>"<?php endif; ?>
                                                   <?php if (isset($config['max'])): ?>max="<?php echo $config['max']; ?>"<?php endif; ?>
                                                   required>
                                            <div class="invalid-feedback">
                                                Por favor ingresa un valor válido.
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            No se encontró información de campos para este test.
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-section">
                                    <h5><i class="fas fa-sticky-note text-warning"></i> Observaciones</h5>
                                    <div class="form-group">
                                        <textarea class="form-control" 
                                                  id="observaciones" 
                                                  name="observaciones" 
                                                  rows="4" 
                                                  placeholder="Observaciones sobre el test, condiciones especiales, etc."><?php echo htmlspecialchars($resultado_existente['observaciones'] ?? ''); ?></textarea>
                                    </div>
                                </div>

                                <div class="form-actions text-center mt-4">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-save"></i> 
                                        <?php echo $resultado_existente ? 'Actualizar' : 'Guardar'; ?> Resultado
                                    </button>
                                    <a href="index.php?controller=Evaluacion&action=nueva&atleta_id=<?php echo $atleta['id']; ?>" 
                                       class="btn btn-secondary btn-lg ml-2">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-user"></i> Información del Atleta</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></p>
                                    <p><strong>DNI:</strong> <?php echo htmlspecialchars($atleta['dni']); ?></p>
                                    <p><strong>Edad:</strong> <?php echo date_diff(date_create($atleta['fecha_nacimiento']), date_create('today'))->y; ?> años</p>
                                    <p><strong>Sexo:</strong> <?php echo $atleta['sexo'] === 'M' ? 'Masculino' : 'Femenino'; ?></p>
                                    <p><strong>Altura:</strong> <?php echo $atleta['altura_cm']; ?> cm</p>
                                    <p><strong>Peso:</strong> <?php echo $atleta['peso_kg']; ?> kg</p>
                                </div>
                            </div>
                            
                            <?php if ($resultado_existente): ?>
                                <div class="card mt-3 bg-info text-white">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Test Anterior</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($resultado_existente['fecha_test'])); ?></p>
                                        <p><strong>Estado:</strong> <span class="badge badge-light">Completado</span></p>
                                        <small>Puedes actualizar los resultados anteriores.</small>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<style>
.card-header {
    border-bottom: 3px solid #007bff;
}

.form-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border-left: 4px solid #007bff;
}

.form-section h5 {
    color: #495057;
    margin-bottom: 1rem;
}

.form-group label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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

.test-description {
    background: #e3f2fd;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #2196f3;
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