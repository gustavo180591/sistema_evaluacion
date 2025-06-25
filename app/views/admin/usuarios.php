<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="max-width: 1200px; margin: 30px auto; padding: 20px;">
    <div class="card" style="border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0" style="color: #004080;">
                    <i class="fas fa-users-cog"></i> Administración de Usuarios
                </h2>
                <a href="index.php?controller=Admin&action=nuevoUsuario" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </a>
            </div>
            
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success" style="margin-bottom: 20px;">
                    <?php 
                    echo htmlspecialchars($_SESSION['mensaje']); 
                    unset($_SESSION['mensaje']);
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <?php 
                    echo htmlspecialchars($_SESSION['error']); 
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="border-top-left-radius: 8px;">ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Registro</th>
                            <th>Actualización</th>
                            <th style="border-top-right-radius: 8px;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (empty($usuarios)) {
                            echo '<tr><td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-users-slash fa-2x mb-2"></i>
                                    <p class="mb-0">No hay usuarios registrados</p>
                                </div>
                            </td></tr>';
                        } else {
                            foreach ($usuarios as $usuario): 
                                if (!isset($usuario['id'], $usuario['nombre'], $usuario['email'], $usuario['rol'])) {
                                    continue;
                                }
                        ?>
                        <tr>
                            <td class="align-middle"><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($usuario['apellido']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td class="align-middle">
                                <span class="badge bg-<?php echo $usuario['rol'] === 'administrador' ? 'primary' : 'secondary'; ?>" style="font-size: 0.8em;">
                                    <?php echo ucfirst(htmlspecialchars($usuario['rol'])); ?>
                                </span>
                            </td>
                            <td class="align-middle">
                                <form method="POST" action="index.php?controller=Admin&action=toggleEstadoUsuario" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                    <input type="hidden" name="estado_actual" value="<?php echo $usuario['estado']; ?>">
                                    <button type="submit" class="btn btn-sm <?php echo $usuario['estado'] === 'activo' ? 'btn-outline-danger' : 'btn-outline-success'; ?>" 
                                            title="<?php echo $usuario['estado'] === 'activo' ? 'Desactivar usuario' : 'Activar usuario'; ?>">
                                        <i class="fas fa-<?php echo $usuario['estado'] === 'activo' ? 'times' : 'check'; ?> me-1"></i>
                                        <?php echo $usuario['estado'] === 'activo' ? 'Desactivar' : 'Activar'; ?>
                                    </button>
                                </form>
                            </td>
                            <td class="align-middle" style="font-size: 0.9em;">
                                <?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?>
                                <small class="d-block text-muted"><?php echo date('H:i', strtotime($usuario['fecha_registro'])); ?></small>
                            </td>
                            <td class="align-middle" style="font-size: 0.9em;">
                                <?php echo date('d/m/Y', strtotime($usuario['fecha_actualizacion'])); ?>
                                <small class="d-block text-muted"><?php echo date('H:i', strtotime($usuario['fecha_actualizacion'])); ?></small>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex flex-column gap-1">
                                    <a href="index.php?controller=Admin&action=editarUsuario&id=<?php echo $usuario['id']; ?>" 
                                       class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center" 
                                       title="Editar usuario">
                                        <i class="fas fa-edit me-1"></i>
                                        <span>Editar</span>
                                    </a>
                                    <a href="index.php?controller=Admin&action=eliminarUsuario&id=<?php echo $usuario['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center" 
                                       title="Eliminar usuario"
                                       onclick="return confirm('¿Está seguro de eliminar este usuario?');">
                                        <i class="fas fa-trash me-1"></i>
                                        <span>Eliminar</span>
                                    </a>
                                </div>
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

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
