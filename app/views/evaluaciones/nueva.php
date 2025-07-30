<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-plus-circle text-success"></i> Nueva Evaluación
                    </h1>
                    <p class="text-muted mb-0">
                        Atleta: <strong><?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></strong>
                    </p>
                </div>
                <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <!-- Alertas -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success']) && $_GET['success'] === 'test_completado'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    Test completado exitosamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Formulario Principal -->
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-check me-2"></i> Configuración de la Evaluación
                    </h5>
                </div>
                <div class="card-body p-4">

                    <form method="POST" class="needs-validation" novalidate>
                        
                        <!-- Información de la Evaluación -->
                        <div class="form-section mb-4">
                            
                            <!-- Primera fila: Fecha y Hora -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="fecha_evaluacion" class="form-label fw-semibold">
                                                <i class="fas fa-calendar me-1"></i> Fecha de Evaluación <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" 
                                                   class="form-control form-control-sm" 
                                                   id="fecha_evaluacion" 
                                                   name="fecha_evaluacion" 
                                                   value="<?php echo date('Y-m-d'); ?>" 
                                                   required>
                                            <div class="invalid-feedback">
                                                La fecha de evaluación es obligatoria
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="hora_inicio" class="form-label fw-semibold">
                                                <i class="fas fa-clock me-1"></i> Hora de Inicio
                                            </label>
                                            <input type="time" 
                                                   class="form-control form-control-sm" 
                                                   id="hora_inicio" 
                                                   name="hora_inicio" 
                                                   value="<?php echo date('H:i'); ?>">
                                            <small class="form-text text-muted">
                                                Hora de inicio de la evaluación
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda fila: Lugar y Clima -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="lugar_id" class="form-label fw-semibold">
                                                <i class="fas fa-map-marker-alt me-1"></i> Lugar de Evaluación
                                            </label>
                                            <select class="form-control form-control-sm" id="lugar_id" name="lugar_id">
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
                                                Lugar donde se realizará la evaluación
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="clima" class="form-label fw-semibold">
                                                <i class="fas fa-cloud-sun me-1"></i> Condiciones Climáticas
                                            </label>
                                            <select class="form-control form-control-sm" id="clima" name="clima">
                                                <option value="">Seleccionar...</option>
                                                <option value="soleado">☀️ Soleado</option>
                                                <option value="nublado">☁️ Nublado</option>
                                                <option value="parcialmente_nublado">⛅ Parcialmente Nublado</option>
                                                <option value="lluvioso">🌧️ Lluvioso</option>
                                                <option value="ventoso">💨 Ventoso</option>
                                            </select>
                                            <small class="form-text text-muted">
                                                Condiciones climáticas del día
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tercera fila: Temperatura y Observaciones -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="temperatura_ambiente" class="form-label fw-semibold">
                                                <i class="fas fa-thermometer-half me-1"></i> Temperatura Ambiente (°C)
                                            </label>
                                            <input type="number" 
                                                   class="form-control form-control-sm" 
                                                   id="temperatura_ambiente" 
                                                   name="temperatura_ambiente" 
                                                   min="-10" 
                                                   max="50" 
                                                   step="0.1"
                                                   placeholder="Ej: 22.5">
                                            <small class="form-text text-muted">
                                                Temperatura en grados Celsius
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="observaciones" class="form-label fw-semibold">
                                                <i class="fas fa-sticky-note me-1"></i> Observaciones Iniciales
                                            </label>
                                            <textarea class="form-control form-control-sm" 
                                                      id="observaciones" 
                                                      name="observaciones" 
                                                      rows="3" 
                                                      placeholder="Observaciones sobre el estado del atleta, condiciones especiales, etc."></textarea>
                                            <small class="form-text text-muted">
                                                Notas adicionales sobre la evaluación
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tests Disponibles -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3">
                                <h6 class="section-title">
                                    <i class="fas fa-clipboard-list text-success me-2"></i>
                                    Tests Disponibles para la Evaluación
                                </h6>
                                <p class="text-muted mb-0">
                                    Los tests se organizan por categorías. Complete los que considere necesarios para la evaluación.
                                </p>
                            </div>
                            
                            <?php if (!empty($tests)): ?>
                                <?php foreach ($tests as $categoria => $testList): ?>
                                    <div class="category-section mb-4">
                                        <h6 class="category-header">
                                            <i class="fas fa-folder-open text-primary me-2"></i>
                                            <?php echo ucfirst(str_replace('_', ' ', $categoria)); ?>
                                        </h6>
                                        
                                        <div class="form-row">
                                            <?php foreach ($testList as $test): ?>
                                                <div class="form-field">
                                                    <div class="field-card test-card">
                                                        <div class="test-header d-flex align-items-center mb-2">
                                                            <div class="test-icon me-3">
                                                                <i class="fas fa-<?php echo $test['icono']; ?> text-success"></i>
                                                            </div>
                                                            <div class="test-info flex-grow-1">
                                                                <h6 class="test-title mb-1"><?php echo htmlspecialchars($test['nombre']); ?></h6>
                                                                <p class="test-desc text-muted mb-0 small">
                                                                    <?php echo htmlspecialchars($test['descripcion']); ?>
                                                                </p>
                                                            </div>
                                                            <a href="index.php?controller=Evaluacion&action=realizarTest&test=<?php echo $test['id']; ?>&evaluacion_id=<?php echo $evaluacion_id ?? 'null'; ?>&atleta_id=<?php echo $atleta['id']; ?>" 
                                                               class="btn btn-outline-success btn-sm">
                                                                <i class="fas fa-play me-1"></i> Realizar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No hay tests disponibles en este momento.
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-center align-items-center pt-3 border-top gap-3">
                            <div class="d-flex gap-2">
                                <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                                <button type="reset" class="btn btn-outline-warning" onclick="resetForm()">
                                    <i class="fas fa-undo me-1"></i> Restablecer
                                </button>
                            </div>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-check me-1"></i> Crear Evaluación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* Estilos generales */
.card {
    border-radius: 12px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    border-bottom: none;
}

/* Secciones del formulario */
.form-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 2rem;
    border-left: 5px solid #28a745;
    margin-bottom: 2rem;
}

.section-header {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.section-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* Layout flexbox para formularios */
.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-field {
    flex: 1;
    min-width: 280px;
}

.field-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.field-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: #28a745;
    transform: translateY(-2px);
}

/* Test cards específicas */
.test-card {
    min-height: 120px;
}

.test-header {
    padding: 0.75rem 0;
}

.test-icon {
    width: 40px;
    height: 40px;
    background: #e9f5ee;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.test-title {
    color: #495057;
    font-weight: 600;
    font-size: 0.9rem;
}

.test-desc {
    font-size: 0.8rem;
    line-height: 1.3;
}

/* Category headers */
.category-header {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #dee2e6;
}

/* Controles de formulario */
.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
    border-radius: 6px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

.form-control-sm:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

/* Validación */
.was-validated .form-control:valid {
    border-color: #28a745;
}

.was-validated .form-control:invalid {
    border-color: #dc3545;
}

/* Responsive */
@media (max-width: 768px) {
    .form-field {
        min-width: 100%;
    }
    
    .field-card {
        padding: 1rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
}

/* Botones */
.btn {
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}
</style>

<script>
// Validación simple del formulario
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Aplicar animaciones a las cards
    const fieldCards = document.querySelectorAll('.field-card');
    fieldCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);
    });

    // Validación del formulario
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Función para reset del formulario
    window.resetForm = function() {
        if (confirm('¿Está seguro de que desea restablecer el formulario? Se perderán todos los datos ingresados.')) {
            const form = document.querySelector('.needs-validation');
            form.reset();
            form.classList.remove('was-validated');
            
            // Limpiar validaciones visuales
            const inputs = form.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.classList.remove('is-valid', 'is-invalid');
            });
        }
    };

    // Validación en tiempo real
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 