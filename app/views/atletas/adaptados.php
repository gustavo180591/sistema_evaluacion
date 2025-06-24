<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2>🧑‍🦯 Atletas Adaptados</h2>
            <p class="text-muted">Lista de atletas con discapacidad asignada</p>
        </div>
        <div class="btn-group">
            <a href="index.php?controller=Atleta&action=listado" class="btn btn-secondary">
                ← Volver a Atletas
            </a>
            <a href="index.php?controller=Atleta&action=crear&adaptado=1" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Atleta Adaptado
            </a>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <strong>✅ Éxito:</strong> Operación realizada correctamente.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <strong>⚠️ Error:</strong> <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Discapacidad</th>
                            <th>Fecha Nacimiento</th>
                            <th>Sexo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($atletas as $atleta): ?>
                            <?php if ($atleta['discapacidad_id']): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($atleta['dni']); ?></td>
                                    <td>
                                        <?php 
                                        $discapacidad = array_filter($discapacidades, function($d) use ($atleta) {
                                            return $d['id'] == $atleta['discapacidad_id'];
                                        });
                                        $discapacidad = reset($discapacidad);
                                        if ($discapacidad): ?>
                                            <span class="badge bg-warning text-dark">
                                                <?php echo htmlspecialchars($discapacidad['nombre']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($atleta['fecha_nacimiento']))); ?></td>
                                    <td>
                                        <?php 
                                        switch ($atleta['sexo']) {
                                            case 'M': ?>
                                                <span class="badge bg-primary">Masculino</span>
                                            <?php break;
                                            case 'F': ?>
                                                <span class="badge bg-danger">Femenino</span>
                                            <?php break;
                                            default: ?>
                                                <span class="badge bg-info">Otro</span>
                                            <?php break;
                                        } ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="index.php?controller=Atleta&action=editar&id=<?php echo $atleta['id']; ?>" 
                                               class="btn btn-sm btn-warning me-1"
                                               title="Editar">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <a href="index.php?controller=Atleta&action=historial&id=<?php echo $atleta['id']; ?>" 
                                               class="btn btn-sm btn-info me-1"
                                               title="Ver Historial">
                                                <i class="fas fa-history"></i> Historial
                                            </a>
                                            <a href="index.php?controller=Atleta&action=eliminar&id=<?php echo $atleta['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('¿Estás seguro de eliminar este atleta?')"
                                               title="Eliminar">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
