<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <a href="index.php" class="btn btn-outline-success btn-home">
                        <i class="fas fa-home me-2"></i>
                        <span>Volver a Inicio</span>
                    </a>
                    <h1 class="h3 mb-0">Gestión de Evaluadores</h1>
                </div>
                <a href="index.php?controller=Evaluador&action=crear" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Evaluador
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
                    <h5 class="card-title mb-0">Lista de Evaluadores</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($evaluadores)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay evaluadores registrados</p>
                            <a href="index.php?controller=Evaluador&action=crear" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Primer Evaluador
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Email</th>
                                        <th>Fecha Alta</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($evaluadores as $evaluador): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($evaluador['id']); ?></td>
                                            <td><?php echo htmlspecialchars($evaluador['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($evaluador['apellido']); ?></td>
                                            <td><?php echo htmlspecialchars($evaluador['email']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($evaluador['fecha_alta'])); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="index.php?controller=Evaluador&action=editar&id=<?php echo $evaluador['id']; ?>" 
                                                       class="btn btn-outline-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            onclick="confirmarEliminar(<?php echo $evaluador['id']; ?>, '<?php echo htmlspecialchars($evaluador['nombre'] . ' ' . $evaluador['apellido']); ?>')"
                                                            title="Eliminar">
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

<style>
/* Estilos para el botón de inicio */
.btn-home {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    color: white;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.btn-home::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-home:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    color: white;
    text-decoration: none;
}

.btn-home:hover::before {
    left: 100%;
}

.btn-home:active {
    transform: translateY(0);
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
}

.btn-home i {
    font-size: 1.1rem;
    transition: transform 0.3s ease;
}

.btn-home:hover i {
    transform: scale(1.1);
}

/* Responsive para el botón */
@media (max-width: 768px) {
    .btn-home {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    
    .btn-home span {
        display: none;
    }
    
    .btn-home i {
        margin-right: 0 !important;
    }
}
</style>

<script>
function confirmarEliminar(id, nombre) {
    if (confirm(`¿Estás seguro de que quieres eliminar al evaluador "${nombre}"?`)) {
        window.location.href = `index.php?controller=Evaluador&action=eliminar&id=${id}`;
    }
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 