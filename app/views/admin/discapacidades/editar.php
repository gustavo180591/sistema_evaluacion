<?php
require_once __DIR__ . '/../../componentes/navbar.php';

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<div class="container mt-4">
    <h2>Editar Discapacidad</h2>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="index.php?controller=Discapacidad&action=editar&id=<?php echo $discapacidad['id']; ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" 
                           value="<?php echo htmlspecialchars($discapacidad['nombre']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="fisica" <?php echo $discapacidad['tipo'] === 'fisica' ? 'selected' : ''; ?>>Física</option>
                        <option value="visual" <?php echo $discapacidad['tipo'] === 'visual' ? 'selected' : ''; ?>>Visual</option>
                        <option value="auditiva" <?php echo $discapacidad['tipo'] === 'auditiva' ? 'selected' : ''; ?>>Auditiva</option>
                        <option value="intelectual" <?php echo $discapacidad['tipo'] === 'intelectual' ? 'selected' : ''; ?>>Intelectual</option>
                        <option value="psicosocial" <?php echo $discapacidad['tipo'] === 'psicosocial' ? 'selected' : ''; ?>>Psicosocial</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($discapacidad['descripcion']); ?></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="index.php?controller=Discapacidad&action=index" class="btn btn-secondary me-2">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
