<?php
require_once __DIR__ . '/../../componentes/navbar.php';

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<div class="container mt-4">
    <h2>Discapacidades</h2>
    
    <div class="mb-3">
        <a href="index.php?controller=Discapacidad&action=crear" class="btn btn-primary">
            <i class="fas fa-plus"></i> Agregar Discapacidad
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($discapacidades as $discapacidad): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($discapacidad['id']); ?></td>
                            <td><?php echo htmlspecialchars($discapacidad['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($discapacidad['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($discapacidad['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($discapacidad['fecha_registro']))); ?></td>
                            <td>
                                <a href="index.php?controller=Discapacidad&action=editar&id=<?php echo $discapacidad['id']; ?>" 
                                   class="btn btn-sm btn-warning me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?controller=Discapacidad&action=eliminar&id=<?php echo $discapacidad['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Estás seguro de eliminar esta discapacidad?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
