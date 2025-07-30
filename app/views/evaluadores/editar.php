<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Editar Evaluador</h1>
                <a href="index.php?controller=Evaluador&action=listado" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Listado
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información del Evaluador</h5>
                </div>
                <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? $evaluador['nombre']); ?>" 
                                           required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa el nombre del evaluador.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="apellido" class="form-label">Apellido *</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" 
                                           value="<?php echo htmlspecialchars($_POST['apellido'] ?? $evaluador['apellido']); ?>" 
                                           required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa el apellido del evaluador.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($_POST['email'] ?? $evaluador['email']); ?>" 
                                           required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa un email válido.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           minlength="6">
                                    <div class="form-text">
                                        Deja en blanco para mantener la contraseña actual.
                                    </div>
                                    <div class="invalid-feedback">
                                        La contraseña debe tener al menos 6 caracteres.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="confirm_password" 
                                           name="confirm_password">
                                    <div class="invalid-feedback">
                                        Las contraseñas no coinciden.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="index.php?controller=Evaluador&action=listado" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Evaluador
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
                
                // Validar que las contraseñas coincidan si se ingresó una nueva
                var password = document.getElementById('password');
                var confirmPassword = document.getElementById('confirm_password');
                
                if (password.value && password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    confirmPassword.setCustomValidity('');
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Validar contraseñas en tiempo real
document.getElementById('confirm_password').addEventListener('input', function() {
    var password = document.getElementById('password');
    var confirmPassword = this;
    
    if (password.value && password.value !== confirmPassword.value) {
        confirmPassword.setCustomValidity('Las contraseñas no coinciden');
    } else {
        confirmPassword.setCustomValidity('');
    }
});

document.getElementById('password').addEventListener('input', function() {
    var password = this;
    var confirmPassword = document.getElementById('confirm_password');
    
    if (password.value && password.value !== confirmPassword.value) {
        confirmPassword.setCustomValidity('Las contraseñas no coinciden');
    } else {
        confirmPassword.setCustomValidity('');
    }
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 