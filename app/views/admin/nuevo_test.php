<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-clipboard-list text-primary"></i> Crear Nuevo Test
                    </h1>
                    <p class="text-muted mb-0">Complete la información para registrar un nuevo test en el sistema</p>
                </div>
                <a href="index.php?controller=Admin&action=tests" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <!-- Alertas -->
            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Error:</strong>
                            <ul class="mb-0 mt-1">
                                <?php foreach ($errores as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] ?? 'success'; ?> alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
            <?php endif; ?>

            <!-- Formulario Principal -->
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-list me-2"></i> Datos del Nuevo Test
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" class="needs-validation" novalidate id="formTest">
                        
                        <!-- Formulario en field cards -->
                        <div class="form-section mb-4">
                            
                            <!-- Primera fila: Información básica -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card field-card-large">
                                        <div class="form-group">
                                            <label for="nombre_test" class="form-label fw-semibold">
                                                <i class="fas fa-clipboard-list me-1"></i> Nombre del Test <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="nombre_test" 
                                                   name="nombre_test" 
                                                   required 
                                                   maxlength="100"
                                                   value="<?php echo htmlspecialchars($_POST['nombre_test'] ?? ''); ?>"
                                                   placeholder="Ej: Test de Fuerza de Agarre">
                                            <div class="form-text">
                                                Ingrese un nombre descriptivo para el test
                                            </div>
                                            <div class="invalid-feedback">
                                                Por favor ingresa el nombre del test.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                                        <!-- Segunda fila: Descripción -->
                            <div class="form-row">
                                <div class="form-field full-width">
                                    <div class="field-card field-card-large">
                                        <div class="form-group">
                                            <label for="descripcion" class="form-label fw-semibold">
                                                <i class="fas fa-file-text me-1"></i> Descripción del Test <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" 
                                                      id="descripcion" 
                                                      name="descripcion" 
                                                      rows="4" 
                                                      required 
                                                      maxlength="500"
                                                      placeholder="Describe el propósito del test, qué mide, cómo se realiza, metodología, etc."><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
                                            <div class="form-text">
                                                Incluye información sobre el propósito, metodología y consideraciones importantes. (<span id="charCount">500</span> caracteres restantes)
                                            </div>
                                            <div class="invalid-feedback">
                                                Por favor ingresa una descripción del test.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tercera fila: Unidad de Medida -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="unidad_medida" class="form-label fw-semibold">
                                                <i class="fas fa-ruler me-1"></i> Unidad de Medida <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" 
                                                    id="unidad_medida" 
                                                    name="unidad_medida" 
                                                    required>
                                                <option value="">Seleccione una unidad...</option>
                                                <option value="kilogramos" <?php echo (($_POST['unidad_medida'] ?? '') == 'kilogramos') ? 'selected' : ''; ?>>Kilogramos (kg)</option>
                                                <option value="gramos" <?php echo (($_POST['unidad_medida'] ?? '') == 'gramos') ? 'selected' : ''; ?>>Gramos (g)</option>
                                                <option value="segundos" <?php echo (($_POST['unidad_medida'] ?? '') == 'segundos') ? 'selected' : ''; ?>>Segundos (s)</option>
                                                <option value="minutos" <?php echo (($_POST['unidad_medida'] ?? '') == 'minutos') ? 'selected' : ''; ?>>Minutos (min)</option>
                                                <option value="metros" <?php echo (($_POST['unidad_medida'] ?? '') == 'metros') ? 'selected' : ''; ?>>Metros (m)</option>
                                                <option value="centimetros" <?php echo (($_POST['unidad_medida'] ?? '') == 'centimetros') ? 'selected' : ''; ?>>Centímetros (cm)</option>
                                                <option value="repeticiones" <?php echo (($_POST['unidad_medida'] ?? '') == 'repeticiones') ? 'selected' : ''; ?>>Repeticiones</option>
                                                <option value="porcentaje" <?php echo (($_POST['unidad_medida'] ?? '') == 'porcentaje') ? 'selected' : ''; ?>>Porcentaje (%)</option>
                                                <option value="velocidad_ms" <?php echo (($_POST['unidad_medida'] ?? '') == 'velocidad_ms') ? 'selected' : ''; ?>>Velocidad (m/s)</option>
                                                <option value="velocidad_kmh" <?php echo (($_POST['unidad_medida'] ?? '') == 'velocidad_kmh') ? 'selected' : ''; ?>>Velocidad (km/h)</option>
                                                <option value="newtons" <?php echo (($_POST['unidad_medida'] ?? '') == 'newtons') ? 'selected' : ''; ?>>Newtons (N)</option>
                                                <option value="watts" <?php echo (($_POST['unidad_medida'] ?? '') == 'watts') ? 'selected' : ''; ?>>Watts (W)</option>
                                                <option value="puntos" <?php echo (($_POST['unidad_medida'] ?? '') == 'puntos') ? 'selected' : ''; ?>>Puntos</option>
                                                <option value="otra" <?php echo (($_POST['unidad_medida'] ?? '') == 'otra') ? 'selected' : ''; ?>>Otra unidad</option>
                                            </select>
                                            <div class="form-text">
                                                Seleccione la unidad en que se medirán los resultados
                                            </div>
                                            <div class="invalid-feedback">
                                                Por favor selecciona una unidad de medida.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campo personalizado para otra unidad -->
                                <div class="form-field" id="otra-unidad-field" style="display: none;">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="unidad_personalizada" class="form-label fw-semibold">
                                                <i class="fas fa-edit me-1"></i> Especificar Unidad
                                            </label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="unidad_personalizada" 
                                                   name="unidad_personalizada" 
                                                   maxlength="20"
                                                   value="<?php echo htmlspecialchars($_POST['unidad_personalizada'] ?? ''); ?>"
                                                   placeholder="Ej: bpm, mmHg, °C">
                                            <div class="form-text">
                                                Escriba la unidad personalizada
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                                    </div>
                        
                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-center align-items-center pt-3 border-top gap-3">
                            <div class="d-flex gap-2">
                                <a href="index.php?controller=Admin&action=tests" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="fas fa-undo me-1"></i> Limpiar
                                </button>
                            </div>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-1"></i> Crear Test
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
    padding: 2.5rem;
    border-left: 5px solid #0d6efd;
    margin-bottom: 2rem;
    text-align: center;
}

.section-header {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.step-number {
    width: 40px;
    height: 40px;
    background: #0d6efd;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
}

/* Field Cards */
.field-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease-in-out;
    height: 100%;
}

.field-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    border-color: #0d6efd;
    transform: translateY(-1px);
}

.field-card .form-group {
    margin-bottom: 0;
}

.field-card .form-label {
    color: #495057;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.field-card .form-control,
.field-card .form-select {
    border: 1px solid #ced4da;
    border-radius: 6px;
    transition: all 0.15s ease-in-out;
}

.field-card .form-control:focus,
.field-card .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* Layout Flexbox */
.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    align-items: flex-start;
    justify-content: center;
    margin-bottom: 2rem;
}

.form-row:last-child {
    margin-bottom: 0;
}

.form-field {
    flex: 1;
    min-width: 200px;
    max-width: 300px;
}

.form-field.full-width {
    flex: 1 1 100%;
    max-width: 100%;
}

/* Campos pequeños */
.field-card .form-control-sm,
.field-card .form-select-sm {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    border-radius: 6px;
    width: 100%;
}

.field-card .input-group-sm .form-control {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.field-card .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

/* Input groups compactos */
.field-card .input-group-sm {
    width: 100%;
}

/* Labels más compactos */
.field-card .form-label {
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

/* Texto de ayuda más pequeño */
.field-card .form-text {
    font-size: 0.75rem;
    margin-top: 0.125rem;
}

/* Variantes de Field Cards */
.field-card-small {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-left: 3px solid #6c757d;
}

.field-card-small:hover {
    border-left-color: #0d6efd;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}

.field-card-large {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-left: 3px solid #0d6efd;
}

.field-card-large:hover {
    border-left-color: #198754;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

/* Campos del formulario */
.form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #ced4da;
    transition: all 0.15s ease-in-out;
    padding: 0.5rem 0.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

/* Botones */
.btn {
    border-radius: 8px;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.2s ease-in-out;
}

.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #6c5ce7 100%);
    border: none;
}

.btn-success {
    background: linear-gradient(135deg, #198754 0%, #20c997 100%);
    border: none;
}

.btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
}

.btn-outline-warning {
    border-color: #ffc107;
    color: #ffc107;
}

/* Estados de validación */
.was-validated .form-control:valid {
    border-color: #198754;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.94-.94 1.38 1.38 2.81-2.81.94.94L3.24 9.56z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.was-validated .form-control:invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4 1.4-1.4M7.4 7.2 6 5.8l-1.4 1.4'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* Responsive Design */
@media (max-width: 992px) {
    .form-row {
        gap: 1.5rem;
    }
    
    .form-field {
        min-width: 250px;
        max-width: 100%;
    }
    
    .form-section {
        padding: 2rem;
    }
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-field {
        min-width: 100%;
        max-width: 100%;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .d-flex.justify-content-center {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-center > div {
        width: 100%;
        display: flex;
        justify-content: center;
    }
    
    .d-flex.justify-content-center .btn {
        width: 100%;
        max-width: 200px;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .field-card {
        padding: 0.75rem;
    }
    
    .form-section {
        padding: 0.75rem;
    }
}

/* Campo de unidad personalizada */
#otra-unidad-field {
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease-in-out;
}

#otra-unidad-field.show {
    opacity: 1;
    transform: translateX(0);
}

/* Alineación de campos en la misma fila */
.form-row .form-field {
    display: flex;
    align-items: stretch;
}

.form-row .form-field .field-card {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 100%;
}

/* Efectos hover */
.form-section:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
}

.btn:hover {
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formTest');
    const descripcion = document.getElementById('descripcion');
    const charCount = document.getElementById('charCount');

    // Contador de caracteres para la descripción
    function updateCharCount() {
        const maxLength = 500;
        const currentLength = descripcion.value.length;
        const remaining = maxLength - currentLength;
        
        charCount.textContent = remaining;
        
        if (remaining < 50) {
            charCount.parentElement.classList.add('text-warning');
        } else {
            charCount.parentElement.classList.remove('text-warning');
        }
        
        if (remaining < 0) {
            charCount.parentElement.classList.add('text-danger');
        } else {
            charCount.parentElement.classList.remove('text-danger');
        }
    }

    descripcion.addEventListener('input', updateCharCount);
    updateCharCount(); // Llamar al cargar

    // Manejar campo de unidad personalizada
    const unidadMedida = document.getElementById('unidad_medida');
    const otraUnidadField = document.getElementById('otra-unidad-field');
    const unidadPersonalizada = document.getElementById('unidad_personalizada');

    function toggleOtraUnidad() {
        if (unidadMedida.value === 'otra') {
            otraUnidadField.style.display = 'block';
            setTimeout(() => {
                otraUnidadField.classList.add('show');
            }, 10);
            unidadPersonalizada.required = true;
        } else {
            otraUnidadField.classList.remove('show');
            setTimeout(() => {
                otraUnidadField.style.display = 'none';
            }, 300);
            unidadPersonalizada.required = false;
            unidadPersonalizada.value = '';
            unidadPersonalizada.classList.remove('is-valid', 'is-invalid');
        }
    }

    unidadMedida.addEventListener('change', toggleOtraUnidad);
    
    // Establecer estado inicial
    if (unidadMedida.value === 'otra') {
        otraUnidadField.style.display = 'block';
        otraUnidadField.classList.add('show');
        unidadPersonalizada.required = true;
    } else {
        toggleOtraUnidad();
    }

    // Form validation
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Creando...';
        submitBtn.disabled = true;
        
        // Re-enable after 3 seconds (in case of error)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });

    // Real-time validation feedback
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        });
        
        // También validar en cambio para los select
        if (input.tagName === 'SELECT') {
            input.addEventListener('change', function() {
                if (this.checkValidity()) {
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                }
            });
        }
    });

    // Confirmación antes de limpiar formulario
    const resetBtn = form.querySelector('button[type="reset"]');
    resetBtn.addEventListener('click', function(e) {
        if (!confirm('¿Estás seguro de que quieres limpiar todos los datos del formulario?')) {
            e.preventDefault();
        }
    });
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 