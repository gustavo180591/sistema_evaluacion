<?php
require_once __DIR__ . '/../componentes/navbar.php';
?>

<div class="container mt-4">
    <div class="header-section">
        <h2><i class="fas fa-users-cog"></i> Administración de Usuarios</h2>
        <a href="index.php?controller=Admin&action=nuevoUsuario" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Usuario
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Registro</th>
                            <th>Actualización</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (empty($usuarios)) {
                            echo '<tr><td colspan="5" class="text-center">No hay usuarios registrados</td></tr>';
                        } else {
                            foreach ($usuarios as $usuario): 
                                if (!isset($usuario['id'], $usuario['nombre'], $usuario['email'], $usuario['rol'])) {
                                    continue;
                                }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['estado']); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($usuario['fecha_registro']))); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($usuario['fecha_actualizacion']))); ?></td>
                            <td class="actions">
                                <a href="index.php?controller=Admin&action=editarUsuario&id=<?php echo $usuario['id']; ?>" class="btn btn-primary btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?controller=Admin&action=eliminarUsuario&id=<?php echo $usuario['id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   title="Eliminar"
                                   onclick="return confirm('¿Está seguro de eliminar este usuario?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                            endforeach;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
