<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-clipboard-list text-primary"></i> Catálogo de Tests
                    </h1>
                    <p class="text-muted mb-0">Descubre todos los tests físicos disponibles registrados en el sistema</p>
                </div>
                <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <!-- Formulario Principal -->
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-running me-2"></i> Tests Registrados en el Sistema
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Tests Section -->
                    <div class="form-section mb-4">
                        
                        <?php if (empty($tests)): ?>
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-clipboard-list fa-4x text-muted"></i>
                                </div>
                                <h4 class="text-muted mb-3">No hay tests disponibles</h4>
                                <p class="text-muted mb-4">
                                    No se han registrado tests en el sistema aún.<br>
                                    Contacte al administrador para agregar tests.
                                </p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="index.php?controller=Dashboard&action=index" class="btn btn-primary">
                                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                                    </a>
                                    <a href="index.php?controller=Admin&action=tests" class="btn btn-outline-info">
                                        <i class="fas fa-cog"></i> Gestión de Tests
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            
                            <!-- Tests dinámicos de la base de datos -->
                            <?php 
                            $testsPorFila = 3;
                            $totalTests = count($tests);
                            $filas = ceil($totalTests / $testsPorFila);
                            
                            // Array de iconos para los tests
                            $iconos = ['🏃', '💪', '⚡', '🧘', '🦘', '⬆️', '🦶', '🎯', '📏', '⚖️', '🏋️', '🤸'];
                            $colores = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                            ?>
                            
                            <?php for ($fila = 0; $fila < $filas; $fila++): ?>
                                <div class="form-row">
                                    <?php 
                                    $inicio = $fila * $testsPorFila;
                                    $fin = min($inicio + $testsPorFila, $totalTests);
                                    ?>
                                    
                                    <?php for ($i = $inicio; $i < $fin; $i++): ?>
                                        <?php 
                                        $test = $tests[$i];
                                        $icono = $iconos[$i % count($iconos)];
                                        $color = $colores[$i % count($colores)];
                                        ?>
                                        
                                        <div class="form-field">
                                            <div class="field-card">
                                                <div class="test-info">
                                                    <div class="test-header">
                                                        <span class="test-icon"><?php echo $icono; ?></span>
                                                        <h6 class="fw-semibold mb-1">
                                                            <?php echo htmlspecialchars($test['nombre_test']); ?>
                                                        </h6>
                                                    </div>
                                                    
                                                    <p class="text-muted mb-3">
                                                        <?php 
                                                        $descripcion = $test['descripcion'];
                                                        if (strlen($descripcion) > 80) {
                                                            echo htmlspecialchars(substr($descripcion, 0, 80)) . '...';
                                                        } else {
                                                            echo htmlspecialchars($descripcion);
                                                        }
                                                        ?>
                                                    </p>
                                                    
                                                    <div class="test-details">
                                                        <span class="badge bg-<?php echo $color; ?> text-white mb-2 me-2">
                                                            ID: <?php echo $test['id']; ?>
                                                        </span>
                                                        <span class="badge bg-light text-<?php echo $color; ?> mb-2">
                                                            Test Físico
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                    
                                    <!-- Completar la fila con celdas vacías si es necesario -->
                                    <?php for ($j = $fin; $j < $inicio + $testsPorFila; $j++): ?>
                                        <div class="form-field">
                                            <!-- Celda vacía para mantener el layout -->
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            <?php endfor; ?>
                            
                            <!-- Resumen de información -->
                            <div class="alert alert-light border mt-4">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="mb-2">
                                            <i class="fas fa-info-circle text-primary"></i> 
                                            Información del Catálogo
                                        </h6>
                                        <p class="mb-0 text-muted">
                                            Se muestran <strong><?php echo $totalTests; ?></strong> tests disponibles 
                                            para evaluaciones deportivas registrados en el sistema.
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <span class="badge bg-primary fs-6 px-3 py-2">
                                            <?php echo $totalTests; ?> Tests Disponibles
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                        <?php endif; ?>

                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-center align-items-center pt-3 border-top gap-3">
                        <div class="d-flex gap-2">
                            <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </a>
                            <a href="index.php?controller=Test&action=asignar" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-1"></i> Asignar Tests
                            </a>
                            <a href="verificar_tests_web.php" target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-search me-1"></i> Verificar Tests
                            </a>
                        </div>
                        <a href="index.php?controller=Evaluacion&action=nueva" class="btn btn-success px-4">
                            <i class="fas fa-play me-1"></i> Iniciar Evaluación
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos generales */
.card {
    border-radius: 12px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    border-bottom: none;
}

/* Secciones del formulario */
.form-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 2.5rem;
    border-left: 5px solid #0d6efd;
    margin-bottom: 2rem;
    text-align: center;
}

.section-header {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.step-number {
    width: 40px;
    height: 40px;
    background: #0d6efd;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
}

/* Field Cards */
.field-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease-in-out;
    height: 100%;
}

.field-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    border-color: #0d6efd;
    transform: translateY(-1px);
}

.field-card .form-group {
    margin-bottom: 0;
}

.field-card .form-label {
    color: #495057;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

/* Test específicos */
.test-info {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.test-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.test-icon {
    font-size: 2rem;
    margin-right: 0.75rem;
    width: 3rem;
    height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(13, 110, 253, 0.1);
    border-radius: 50%;
}

.test-details {
    margin-top: auto;
}

/* Layout Flexbox */
.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    align-items: flex-start;
    justify-content: center;
    margin-bottom: 2rem;
}

.form-row:last-child {
    margin-bottom: 0;
}

.form-field {
    flex: 1;
    min-width: 200px;
    max-width: 300px;
}

/* Validación */
.was-validated .form-control:valid,
.was-validated .form-select:valid {
    border-color: #198754;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.54-.54L4.5 7.84l3.15-3.15.54.54L4.5 8.84z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.was-validated .form-control:invalid,
.was-validated .form-select:invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 5.8 0.4 0.4 0.4 -0.4'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* Responsive */
@media (max-width: 1200px) {
    .form-field {
        min-width: 180px;
        max-width: 250px;
    }
}

@media (max-width: 992px) {
    .form-field {
        min-width: 160px;
        max-width: 220px;
    }
    
    .field-card {
        padding: 1.25rem;
    }
}

@media (max-width: 768px) {
    .form-section {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .field-card {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    /* En móviles, apilar los campos */
    .form-row {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-field {
        min-width: 100%;
        max-width: 100%;
    }
    
    .d-flex.justify-content-center {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-center > div {
        width: 100%;
        display: flex;
        justify-content: center;
    }
    
    .d-flex.justify-content-center .btn {
        width: 100%;
        max-width: 200px;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .field-card {
        padding: 0.75rem;
    }
    
    .form-section {
        padding: 0.75rem;
    }
    
    .test-icon {
        font-size: 1.5rem;
        width: 2.5rem;
        height: 2.5rem;
    }
    
    .test-header h6 {
        font-size: 0.95rem;
    }
}

/* Efectos hover */
.form-section:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
}

.btn:hover {
    transform: translateY(-1px);
}

/* Loading states */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.btn.loading {
    position: relative;
}

.btn.loading::after {
    content: '';
    width: 16px;
    height: 16px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}

@keyframes spin {
    0% { transform: translateY(-50%) rotate(0deg); }
    100% { transform: translateY(-50%) rotate(360deg); }
}

/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animaciones de entrada
    const fieldCards = document.querySelectorAll('.field-card');
    fieldCards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
        card.classList.add('fadeInUp');
    });

    // Efectos hover mejorados para las cards de tests
    const testCards = document.querySelectorAll('.field-card');
    testCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
        });
    });
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
