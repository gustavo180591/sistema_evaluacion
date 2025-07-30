<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Gestión de Evaluadores</h1>
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

<script>
function confirmarEliminar(id, nombre) {
    if (confirm(`¿Estás seguro de que quieres eliminar al evaluador "${nombre}"?`)) {
        window.location.href = `index.php?controller=Evaluador&action=eliminar&id=${id}`;
    }
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 