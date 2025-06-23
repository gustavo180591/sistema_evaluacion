<?php
require_once __DIR__ . '/../../componentes/navbar.php';

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<div class="container mt-4">
    <h2>Nueva Discapacidad</h2>
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="index.php?controller=Discapacidad&action=crear">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="fisica">Física</option>
                        <option value="visual">Visual</option>
                        <option value="auditiva">Auditiva</option>
                        <option value="intelectual">Intelectual</option>
                        <option value="psicosocial">Psicosocial</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
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
