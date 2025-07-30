<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-user-plus text-primary"></i> Crear Nuevo Usuario
                </h1>
                <a href="index.php?controller=Admin&action=usuarios" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a Usuarios
                </a>
            </div>

            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Error:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-cog"></i> Información del Usuario
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate id="formUsuario">
                        <!-- Información Personal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user"></i> Información Personal
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nombre" class="form-label fw-bold">
                                        <i class="fas fa-user"></i> Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" 
                                           required maxlength="100"
                                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>"
                                           placeholder="Ingresa el nombre">
                                    <div class="invalid-feedback">
                                        Por favor ingresa el nombre del usuario.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="apellido" class="form-label fw-bold">
                                        <i class="fas fa-user"></i> Apellido <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="apellido" name="apellido" 
                                           required maxlength="100"
                                           value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>"
                                           placeholder="Ingresa el apellido">
                                    <div class="invalid-feedback">
                                        Por favor ingresa el apellido del usuario.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Acceso -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-key"></i> Información de Acceso
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="fas fa-envelope"></i> Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                           required maxlength="150"
                                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                           placeholder="usuario@ejemplo.com">
                                    <div class="invalid-feedback">
                                        Por favor ingresa un email válido.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="rol" class="form-label fw-bold">
                                        <i class="fas fa-user-tag"></i> Rol <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-lg" id="rol" name="rol" required>
                                        <option value="">Selecciona un rol</option>
                                        <option value="usuario" <?php echo (($_POST['rol'] ?? '') === 'usuario') ? 'selected' : ''; ?>>
                                            <i class="fas fa-user"></i> Usuario
                                        </option>
                                        <option value="evaluador" <?php echo (($_POST['rol'] ?? '') === 'evaluador') ? 'selected' : ''; ?>>
                                            <i class="fas fa-user-tie"></i> Evaluador
                                        </option>
                                        <option value="administrador" <?php echo (($_POST['rol'] ?? '') === 'administrador') ? 'selected' : ''; ?>>
                                            <i class="fas fa-user-shield"></i> Administrador
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor selecciona un rol.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contraseñas -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-lock"></i> Seguridad
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label fw-bold">
                                        <i class="fas fa-lock"></i> Contraseña <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="password" 
                                               name="password" required minlength="8"
                                               placeholder="Mínimo 8 caracteres">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle"></i> La contraseña debe tener al menos 8 caracteres
                                    </div>
                                    <div class="invalid-feedback">
                                        La contraseña debe tener al menos 8 caracteres.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="confirm_password" class="form-label fw-bold">
                                        <i class="fas fa-lock"></i> Confirmar Contraseña <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="confirm_password" 
                                               name="confirm_password" required
                                               placeholder="Repite la contraseña">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">
                                        Las contraseñas no coinciden.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Información Importante</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Roles Disponibles:</h6>
                                                <ul class="mb-0">
                                                    <li><strong>Usuario:</strong> Acceso básico al sistema</li>
                                                    <li><strong>Evaluador:</strong> Puede realizar evaluaciones</li>
                                                    <li><strong>Administrador:</strong> Acceso completo al sistema</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Requisitos de Seguridad:</h6>
                                                <ul class="mb-0">
                                                    <li>Contraseña mínima de 8 caracteres</li>
                                                    <li>Email único en el sistema</li>
                                                    <li>Datos obligatorios marcados con *</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="index.php?controller=Admin&action=usuarios" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="reset" class="btn btn-outline-warning btn-lg">
                                <i class="fas fa-undo"></i> Limpiar
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: none;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-control-lg, .form-select-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    border-radius: 10px;
}

.alert {
    border-radius: 10px;
    border: none;
}

.text-primary {
    color: #0d6efd !important;
}

.fw-bold {
    font-weight: 600 !important;
}

.input-group .btn {
    border-radius: 0 10px 10px 0;
}

.input-group .form-control {
    border-radius: 10px 0 0 10px;
}

/* Animaciones */
.form-control:focus, .form-select:focus {
    transform: translateY(-2px);
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .form-control-lg, .form-select-lg {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }
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
                
                // Validación personalizada de contraseñas
                var password = document.getElementById('password');
                var confirmPassword = document.getElementById('confirm_password');
                
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    confirmPassword.setCustomValidity('');
                }
                
                if (password.value.length < 8) {
                    password.setCustomValidity('La contraseña debe tener al menos 8 caracteres');
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    password.setCustomValidity('');
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Toggle de visibilidad de contraseñas
document.getElementById('togglePassword').addEventListener('click', function() {
    var password = document.getElementById('password');
    var icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    var confirmPassword = document.getElementById('confirm_password');
    var icon = this.querySelector('i');
    
    if (confirmPassword.type === 'password') {
        confirmPassword.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        confirmPassword.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Validación en tiempo real de contraseñas
document.getElementById('confirm_password').addEventListener('input', function() {
    var password = document.getElementById('password');
    var confirmPassword = this;
    
    if (password.value !== confirmPassword.value) {
        confirmPassword.setCustomValidity('Las contraseñas no coinciden');
    } else {
        confirmPassword.setCustomValidity('');
    }
});

document.getElementById('password').addEventListener('input', function() {
    var password = this;
    var confirmPassword = document.getElementById('confirm_password');
    
    if (password.value.length < 8) {
        password.setCustomValidity('La contraseña debe tener al menos 8 caracteres');
    } else {
        password.setCustomValidity('');
    }
    
    if (confirmPassword.value && password.value !== confirmPassword.value) {
        confirmPassword.setCustomValidity('Las contraseñas no coinciden');
    } else {
        confirmPassword.setCustomValidity('');
    }
});

// Animación de carga al enviar
document.getElementById('formUsuario').addEventListener('submit', function() {
    var submitBtn = this.querySelector('button[type="submit"]');
    var originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando...';
    submitBtn.disabled = true;
    
    // Restaurar después de 3 segundos si no hay redirección
    setTimeout(function() {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
