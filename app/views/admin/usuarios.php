<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<style>
    .user-table {
        --bs-table-bg: #fff;
        --bs-table-striped-bg: #f8f9fa;
        --bs-table-hover-bg: #f1f3f5;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    
    .user-table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
    }
    
    .user-table tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-color: #edf2f7;
    }
    
    .user-table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .status-toggle {
        position: relative;
        display: inline-block;
        width: 80px;
        height: 30px;
    }
    
    .status-toggle input { 
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .status-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #dc3545;
        transition: .4s;
        border-radius: 34px;
    }
    
    .status-slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .status-slider {
        background-color: #28a745;
    }
    
    input:checked + .status-slider:before {
        transform: translateX(50px);
    }
    
    .status-label {
        position: absolute;
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }
    
    .status-label-on {
        left: 10px;
        display: none;
    }
    
    .status-label-off {
        right: 10px;
    }
    
    input:checked + .status-slider .status-label-on {
        display: block;
    }
    
    input:checked + .status-slider .status-label-off {
        display: none;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .action-btn i {
        font-size: 0.9em;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1.25rem 1.5rem;
    }
    
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="h3 mb-0">
                    <i class="fas fa-users-cog me-2"></i>Administración de Usuarios
                </h1>
                <a href="index.php?controller=Admin&action=nuevoUsuario" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </a>
            </div>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <?php echo $_SESSION['mensaje']; ?>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Lista de Usuarios del Sistema</h5>
                </div>
                <div class="card-body">

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
                <table class="table table-hover user-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th style="width: 120px;">Estado</th>
                            <th style="width: 140px;">Registro</th>
                            <th style="width: 160px;">Actualización</th>
                            <th style="width: 150px;" class="text-center">Acciones</th>
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
                                <form method="POST" action="index.php?controller=Admin&action=toggleEstadoUsuario" class="d-inline-block">
                                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                    <input type="hidden" name="estado_actual" value="<?php echo $usuario['estado']; ?>">
                                    <label class="status-toggle">
                                        <input type="checkbox" <?php echo $usuario['estado'] === 'activo' ? 'checked' : ''; ?> 
                                               onchange="this.form.submit()" 
                                               title="<?php echo $usuario['estado'] === 'activo' ? 'Desactivar usuario' : 'Activar usuario'; ?>">
                                        <span class="status-slider">
                                            <span class="status-label status-label-on">ON</span>
                                            <span class="status-label status-label-off">OFF</span>
                                        </span>
                                    </label>
                                </form>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-medium"><?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?></span>
                                    <small class="text-muted"><?php echo date('H:i', strtotime($usuario['fecha_registro'])); ?></small>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-medium"><?php echo date('d/m/Y', strtotime($usuario['fecha_actualizacion'])); ?></span>
                                    <small class="text-muted"><?php echo date('H:i', strtotime($usuario['fecha_actualizacion'])); ?></small>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex justify-content-center">
                                    <a href="index.php?controller=Admin&action=editarUsuario&id=<?php echo $usuario['id']; ?>" 
                                       class="action-btn btn-outline-primary text-primary" 
                                       title="Editar usuario">
                                        <i class="far fa-edit"></i>
                                        <span>Editar</span>
                                    </a>
                                    <a href="index.php?controller=Admin&action=eliminarUsuario&id=<?php echo $usuario['id']; ?>" 
                                       class="action-btn btn-outline-danger text-danger ms-2" 
                                       title="Eliminar usuario"
                                       onclick="return confirm('¿Está seguro de eliminar este usuario?');">
                                        <i class="far fa-trash-alt"></i>
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

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
