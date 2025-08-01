<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Editar Test</h1>
                <a href="index.php?controller=Admin&action=tests" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a Tests
                </a>
            </div>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['mensaje']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información del Test</h5>
                </div>
                <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="nombre_test" class="form-label">Nombre del Test *</label>
                                    <input type="text" class="form-control" id="nombre_test" name="nombre_test" 
                                           value="<?php echo htmlspecialchars($_POST['nombre_test'] ?? $test['nombre_test']); ?>" 
                                           required maxlength="100">
                                    <div class="form-text">
                                        Ej: "Test de Fuerza de Agarre", "Salto Vertical", "Velocidad 30m"
                                    </div>
                                    <div class="invalid-feedback">
                                        Por favor ingresa el nombre del test.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción *</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" 
                                              rows="4" required maxlength="500"
                                              placeholder="Describe el propósito del test, qué mide, cómo se realiza, etc."><?php echo htmlspecialchars($_POST['descripcion'] ?? $test['descripcion']); ?></textarea>
                                    <div class="form-text">
                                        Incluye información sobre el propósito, metodología, unidades de medida y consideraciones importantes.
                                    </div>
                                    <div class="invalid-feedback">
                                        Por favor ingresa una descripción del test.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del test -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Información del Test</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>ID del Test:</strong>
                                                <p class="text-muted"><?php echo $test['id']; ?></p>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Fecha de Creación:</strong>
                                                <p class="text-muted"><?php echo isset($test['fecha_creacion']) ? date('d/m/Y H:i', strtotime($test['fecha_creacion'])) : 'N/A'; ?></p>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Estado:</strong>
                                                <p class="text-success"><i class="fas fa-check-circle"></i> Activo</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="index.php?controller=Admin&action=tests" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

// Contador de caracteres para la descripción
document.getElementById('descripcion').addEventListener('input', function() {
    var maxLength = 500;
    var currentLength = this.value.length;
    var remaining = maxLength - currentLength;
    
    // Actualizar el texto de ayuda
    var formText = this.parentNode.querySelector('.form-text');
    if (formText) {
        formText.textContent = 'Incluye información sobre el propósito, metodología, unidades de medida y consideraciones importantes. (' + remaining + ' caracteres restantes)';
        
        if (remaining < 50) {
            formText.className = 'form-text text-warning';
        } else {
            formText.className = 'form-text';
        }
    }
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 