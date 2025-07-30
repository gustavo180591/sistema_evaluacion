<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="h3 mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>Gestión de Tests
                </h1>
                <a href="index.php?controller=Admin&action=nuevoTest" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Test
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
                    <h5 class="card-title mb-0">Lista de Tests Disponibles</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($tests)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay tests registrados</p>
                            <a href="index.php?controller=Admin&action=nuevoTest" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Primer Test
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre del Test</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tests as $test): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($test['id']); ?></td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($test['nombre_test']); ?></strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    <?php echo htmlspecialchars($test['descripcion']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="index.php?controller=Admin&action=editarTest&id=<?php echo $test['id']; ?>" 
                                                       class="btn btn-outline-primary" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger" 
                                                            onclick="confirmarEliminar(<?php echo $test['id']; ?>, '<?php echo htmlspecialchars($test['nombre_test']); ?>')"
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

                        <!-- Resumen -->
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-info-circle"></i> 
                                        Total de tests: <strong><?php echo count($tests); ?></strong>
                                    </p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="index.php?controller=Test&action=catalogo" class="btn btn-outline-info btn-sm" target="_blank">
                                        <i class="fas fa-external-link-alt"></i> Ver Catálogo Público
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


        </div>
    </div>
</div>

<script>
function confirmarEliminar(id, nombre) {
    if (confirm(`¿Estás seguro de que quieres eliminar el test "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
        window.location.href = `index.php?controller=Admin&action=eliminarTest&id=${id}`;
    }
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 