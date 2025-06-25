<?php
require_once __DIR__ . '/../componentes/navbar.php';
?>

<div class="container mt-4">
    <div class="header-section">
        <h2><i class="fas fa-user-plus"></i> Nuevo Usuario</h2>
        <a href="index.php?controller=Admin&action=usuarios" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver a Usuarios
        </a>
    </div>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success">
            <?php 
            echo htmlspecialchars($_SESSION['mensaje']);
            unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="index.php?controller=Admin&action=nuevoUsuario" id="formUsuario">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required 
                                   value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required
                                   value="<?php echo htmlspecialchars($_POST['apellido'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="rol" class="form-label">Rol <span class="text-danger">*</span></label>
                            <select class="form-select" id="rol" name="rol" required>
                                <option value="usuario" <?php echo (($_POST['rol'] ?? '') === 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                                <option value="administrador" <?php echo (($_POST['rol'] ?? '') === 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary me-md-2">
                        <i class="fas fa-undo"></i> Limpiar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('formUsuario').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Las contraseñas no coinciden');
        return false;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 8 caracteres');
        return false;
    }
    
    return true;
});
</script>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
