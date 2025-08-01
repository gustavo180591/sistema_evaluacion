<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-edit text-warning"></i> Editar Lugar
                    </h1>
                    <p class="text-muted mb-0">
                        Modifica la información del lugar seleccionado
                    </p>
                </div>
                <div>
                    <a href="index.php?controller=Admin&action=gestionarLugares" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a Lugares
                    </a>
                </div>
            </div>

            <!-- Alertas -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-<?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'check-circle' : 'exclamation-circle'; ?> me-2"></i>
                        <div>
                            <strong><?php echo ucfirst($_SESSION['tipo_mensaje']); ?>:</strong>
                            <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php 
                unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); 
                ?>
            <?php endif; ?>

            <!-- Formulario de Edición -->
            <div class="card shadow border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i> Información del Lugar
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="form-section">
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="nombre" class="form-label fw-semibold">
                                                <i class="fas fa-building me-1"></i> Nombre del Lugar *
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   id="nombre" 
                                                   name="nombre" 
                                                   required 
                                                   maxlength="100"
                                                   value="<?php echo htmlspecialchars($lugar['nombre'] ?? ''); ?>"
                                                   placeholder="Ej: Polideportivo Municipal">
                                            <div class="invalid-feedback">
                                                El nombre del lugar es obligatorio
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="zona" class="form-label fw-semibold">
                                                <i class="fas fa-map me-1"></i> Zona
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   id="zona" 
                                                   name="zona" 
                                                   maxlength="100"
                                                   value="<?php echo htmlspecialchars($lugar['zona'] ?? ''); ?>"
                                                   placeholder="Ej: Centro, Norte, Sur">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="direccion" class="form-label fw-semibold">
                                                <i class="fas fa-location-arrow me-1"></i> Dirección
                                            </label>
                                            <textarea class="form-control form-control-sm" 
                                                      id="direccion" 
                                                      name="direccion" 
                                                      rows="3" 
                                                      maxlength="255"
                                                      placeholder="Dirección completa del lugar"><?php echo htmlspecialchars($lugar['direccion'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-save me-2"></i> Guardar Cambios
                                            </button>
                                            <a href="index.php?controller=Admin&action=gestionarLugares" class="btn btn-outline-secondary ms-2">
                                                <i class="fas fa-times me-2"></i> Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="card mt-4 shadow border-0">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i> Información del Lugar
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">ID del Lugar:</small>
                            <br><strong>#<?php echo $lugar['id']; ?></strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Estado:</small>
                            <br><span class="badge bg-success">Activo</span>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <small>
                                <strong>Nota:</strong> Si este lugar está siendo utilizado por atletas, 
                                los cambios se reflejarán en sus registros.
                            </small>
                        </div>
                    </div>
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
</script>

<style>
/* Estilos para form-section y field-card */
.form-section {
    margin-bottom: 2rem;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.form-field {
    flex: 1;
    min-width: 200px;
}

.field-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.2s ease-in-out;
    height: 100%;
}

.field-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.form-label {
    color: #495057;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control-sm {
    border-radius: 8px;
    border: 1px solid #ced4da;
    transition: all 0.2s ease-in-out;
}

.form-control-sm:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-field {
        min-width: 100%;
    }
    
    .field-card {
        padding: 1rem;
    }
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 