<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-user-edit text-primary"></i> Editar Evaluador
                    </h1>
                    <p class="text-muted mb-0">Modifique la información del evaluador en el sistema</p>
                </div>
                <a href="index.php?controller=Evaluador&action=listado" class="btn btn-outline-secondary">
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
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>

            <!-- Formulario Principal -->
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-edit me-2"></i> Datos del Evaluador
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" class="needs-validation" novalidate id="formEvaluador">
                        
                        <!-- Formulario en una sola fila -->
                        <div class="form-section mb-4">
                            
                            <!-- Primera fila: Nombre, Apellido y Rol -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="nombre" class="form-label fw-semibold">
                                                <i class="fas fa-user me-1"></i> Nombre <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   id="nombre" 
                                                   name="nombre" 
                                                   required 
                                                   maxlength="30"
                                                   value="<?php echo htmlspecialchars($_POST['nombre'] ?? $evaluador['nombre']); ?>"
                                                   placeholder="Ingrese nombre">
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="apellido" class="form-label fw-semibold">
                                                <i class="fas fa-user me-1"></i> Apellido <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   id="apellido" 
                                                   name="apellido" 
                                                   required 
                                                   maxlength="30"
                                                   value="<?php echo htmlspecialchars($_POST['apellido'] ?? $evaluador['apellido']); ?>"
                                                   placeholder="Ingrese apellido">
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="rol" class="form-label fw-semibold">
                                                <i class="fas fa-user-tag me-1"></i> Rol <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select form-select-sm" id="rol" name="rol" required>
                                                <option value="">Seleccione rol</option>
                                                <option value="usuario" <?php echo (($_POST['rol'] ?? $evaluador['rol'] ?? '') === 'usuario') ? 'selected' : ''; ?>>
                                                    Atleta
                                                </option>
                                                <option value="evaluador" <?php echo (($_POST['rol'] ?? $evaluador['rol'] ?? '') === 'evaluador') ? 'selected' : ''; ?>>
                                                    Evaluador
                                                </option>
                                                <option value="administrador" <?php echo (($_POST['rol'] ?? $evaluador['rol'] ?? '') === 'administrador') ? 'selected' : ''; ?>>
                                                    Administrador
                                                </option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda fila: Email, Contraseña y Confirmar -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="email" class="form-label fw-semibold">
                                                <i class="fas fa-envelope me-1"></i> Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" 
                                                   class="form-control form-control-sm" 
                                                   id="email" 
                                                   name="email" 
                                                   required 
                                                   maxlength="80"
                                                   value="<?php echo htmlspecialchars($_POST['email'] ?? $evaluador['email']); ?>"
                                                   placeholder="Ingrese email">
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="password" class="form-label fw-semibold">
                                                <i class="fas fa-lock me-1"></i> Nueva Contraseña
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input type="password" 
                                                       class="form-control form-control-sm" 
                                                       id="password" 
                                                       name="password" 
                                                       minlength="8"
                                                       placeholder="Ingrese nueva contraseña"
                                                       style="padding-right: 2.5rem;">
                                                <button class="btn btn-sm position-absolute" 
                                                        type="button" 
                                                        id="togglePassword"
                                                        aria-label="Mostrar/ocultar contraseña">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="confirm_password" class="form-label fw-semibold">
                                                <i class="fas fa-lock me-1"></i> Confirmar <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input type="password" 
                                                   class="form-control form-control-sm" 
                                                   id="confirm_password" 
                                                   name="confirm_password" 
                                                   placeholder="Confirme nueva contraseña"
                                                   style="padding-right: 2.5rem;">
                                                <button class="btn btn-sm position-absolute" 
                                                        type="button" 
                                                        id="toggleConfirmPassword"
                                                        aria-label="Mostrar/ocultar confirmación de contraseña">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="invalid-feedback">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-center align-items-center pt-3 border-top gap-3">
                            <div class="d-flex gap-2">
                                <a href="index.php?controller=Evaluador&action=listado" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="fas fa-undo me-1"></i> Limpiar
                                </button>
                            </div>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-1"></i> Actualizar Evaluador
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
    margin-top: 0.25rem;
}

/* Input groups */
.input-group .btn {
    border-radius: 0 6px 6px 0;
    border-left: none;
}

.input-group .form-control {
    border-radius: 6px 0 0 6px;
}

/* Botones */
.btn {
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.15s ease-in-out;
}

.btn-success {
    background-color: #198754;
    border-color: #198754;
}

.btn-success:hover {
    background-color: #157347;
    border-color: #146c43;
}

/* Estados de validación */
.was-validated .form-control:valid,
.was-validated .form-select:valid {
    border-color: #198754;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.94-.94 2.89 2.89 2.89-2.89.94.94L4.12 9.61z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.was-validated .form-control:invalid,
.was-validated .form-select:invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4M7.2 4.6l-1.4 1.4'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* Responsive */
@media (max-width: 1200px) {
    .form-field {
        min-width: 180px;
        max-width: 250px;
    }
}

@media (max-width: 992px) {
    .form-field {
        min-width: 160px;
        max-width: 220px;
    }
    
    .field-card {
        padding: 1.25rem;
    }
}

@media (max-width: 768px) {
    .form-section {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .field-card {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    /* En móviles, apilar los campos */
    .form-row {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-field {
        min-width: 100%;
        max-width: 100%;
    }
    
    /* En móviles, mantener la proporción pero apilados */
    .field-card-small,
    .field-card-large {
        background: white;
        border-left: 3px solid #0d6efd;
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

/* Efectos hover */
.form-section:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
}

.btn:hover {
    transform: translateY(-1px);
}

/* Estilos para botones dentro de inputs */
.input-group {
    position: relative;
}

.input-group .position-absolute {
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    border: none;
    background: transparent;
    z-index: 10;
    border-radius: 0 4px 4px 0;
    transition: all 0.2s ease;
    width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.input-group .position-absolute:hover {
    background-color: transparent !important;
    color: #0d6efd;
}

.input-group .position-absolute:focus {
    box-shadow: none;
    outline: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formEvaluador');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        togglePassword.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        toggleConfirmPassword.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    // Password confirmation validation
    function validatePassword() {
        if (password.value && password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Las contraseñas no coinciden');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);

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
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Actualizando...';
        submitBtn.disabled = true;
        
        // Re-enable after 3 seconds (in case of error)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });

    // Real-time validation feedback
    const inputs = form.querySelectorAll('input, select');
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