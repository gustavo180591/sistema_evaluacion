<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-map-marker-alt text-warning"></i> Gestión de Lugares
                    </h1>
                    <p class="text-muted mb-0">
                        Administra los lugares disponibles para las evaluaciones de atletas
                    </p>
                </div>
                <a href="index.php?controller=Admin&action=configuracion" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver a Configuración
                </a>
            </div>

            <!-- Alertas -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-<?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'check-circle' : (($_SESSION['tipo_mensaje'] === 'warning') ? 'exclamation-triangle' : 'exclamation-circle'); ?> me-2"></i>
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

            <!-- Estadísticas -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt text-warning fs-2"></i>
                            <div class="mt-2">
                                <strong><?php echo number_format($totalLugares); ?></strong>
                                <br><small class="text-muted">Lugares registrados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario para Crear Lugar -->
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i> Crear Nuevo Lugar
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?controller=Admin&action=crearLugar" class="needs-validation" novalidate>
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
                                                   placeholder="Ej: Polideportivo Municipal">
                                            <div class="invalid-feedback">
                                                El nombre del lugar es obligatorio
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
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
                                                      rows="2" 
                                                      maxlength="255"
                                                      placeholder="Dirección completa del lugar"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-plus me-2"></i> Crear Lugar
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary ms-2">
                                                <i class="fas fa-undo me-2"></i> Limpiar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Lugares -->
            <div class="card shadow border-0">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i> Lugares Registrados
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($lugares)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-map-marker-alt text-muted fs-1"></i>
                            <p class="text-muted mt-2 mb-0">No hay lugares registrados aún</p>
                            <small class="text-muted">Crea el primer lugar usando el formulario anterior</small>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">
                                            <i class="fas fa-building me-1"></i> Nombre
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-map me-1"></i> Zona
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-location-arrow me-1"></i> Dirección
                                        </th>
                                        <th scope="col" class="text-center">
                                            <i class="fas fa-cogs me-1"></i> Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lugares as $lugar): ?>
                                        <tr>
                                            <td class="text-muted"><?php echo $lugar['id']; ?></td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($lugar['nombre'] ?? ''); ?></strong>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($lugar['zona'] ?? 'Sin zona'); ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?php echo htmlspecialchars($lugar['direccion'] ?? 'Sin dirección'); ?>
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="index.php?controller=Admin&action=editarLugar&id=<?php echo $lugar['id']; ?>" 
                                                       class="btn btn-outline-primary btn-sm" 
                                                       title="Editar lugar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger btn-sm" 
                                                            title="Eliminar lugar"
                                                            onclick="confirmarEliminacion(<?php echo $lugar['id']; ?>, '<?php echo htmlspecialchars($lugar['nombre'], ENT_QUOTES); ?>')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
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

// Función para confirmar eliminación
function confirmarEliminacion(id, nombre) {
    if (confirm(`¿Estás seguro de que deseas eliminar el lugar "${nombre}"?\n\nEsta acción no se puede deshacer y solo será posible si no hay atletas asociados a este lugar.`)) {
        window.location.href = `index.php?controller=Admin&action=eliminarLugar&id=${id}`;
    }
}
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

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.075);
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