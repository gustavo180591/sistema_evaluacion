<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-plus-circle text-success"></i> Nueva Evaluación
                    </h1>
                    <p class="text-muted mb-0">
                        Atleta: <strong><?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></strong>
                    </p>
                </div>
                <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <!-- Alertas -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success']) && $_GET['success'] === 'test_completado'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    Test completado exitosamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success']) && $_GET['success'] === 'evaluacion_creada'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-rocket text-success me-2 fs-4"></i>
                        <div>
                            <strong>¡Evaluación creada exitosamente!</strong>
                            <br><small>Ahora puedes comenzar a realizar los tests disponibles.</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Formulario Principal -->
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-check me-2"></i> Configuración de la Evaluación
                    </h5>
                </div>
                <div class="card-body p-4">

                    <form method="POST" class="needs-validation" novalidate>
                        
                        <!-- Información de la Evaluación -->
                        <div class="form-section mb-4">
                            
                            <!-- Primera fila: Fecha y Hora -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="fecha_evaluacion" class="form-label fw-semibold">
                                                <i class="fas fa-calendar me-1"></i> Fecha de Evaluación <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" 
                                                   class="form-control form-control-sm" 
                                                   id="fecha_evaluacion" 
                                                   name="fecha_evaluacion" 
                                                   value="<?php echo date('Y-m-d'); ?>" 
                                                   required>
                                            <div class="invalid-feedback">
                                                La fecha de evaluación es obligatoria
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="hora_inicio" class="form-label fw-semibold">
                                                <i class="fas fa-clock me-1"></i> Hora de Inicio
                                                <small class="text-muted fw-normal">(Buenos Aires)</small>
                                            </label>
                                            <input type="time" 
                                                   class="form-control form-control-sm" 
                                                   id="hora_inicio" 
                                                   name="hora_inicio" 
                                                   value="<?php echo date('H:i'); ?>"
                                                   title="Hora actual de Buenos Aires: <?php echo date('H:i T'); ?>">
                                            <small class="form-text text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                Hora de inicio de la evaluación (Zona horaria: Buenos Aires - <?php echo date('T'); ?>)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda fila: Lugar y Clima -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="lugar_id" class="form-label fw-semibold">
                                                <i class="fas fa-map-marker-alt me-1"></i> Lugar de Evaluación
                                            </label>
                                            <select class="form-control form-control-sm" id="lugar_id" name="lugar_id">
                                                <?php foreach ($lugares as $lugar): ?>
                                                    <option value="<?php echo $lugar['id']; ?>" 
                                                            <?php echo ($lugar['id'] == $atleta['lugar_id']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($lugar['nombre']); ?>
                                                        <?php if ($lugar['zona']): ?>
                                                            - <?php echo htmlspecialchars($lugar['zona']); ?>
                                                        <?php endif; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="form-text text-muted">
                                                Lugar donde se realizará la evaluación
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="clima" class="form-label fw-semibold">
                                                <i class="fas fa-cloud-sun me-1"></i> Condiciones Climáticas
                                            </label>
                                            <select class="form-control form-control-sm" id="clima" name="clima">
                                                <option value="">Seleccionar...</option>
                                                <option value="soleado">☀️ Soleado</option>
                                                <option value="nublado">☁️ Nublado</option>
                                                <option value="parcialmente_nublado">⛅ Parcialmente Nublado</option>
                                                <option value="lluvioso">🌧️ Lluvioso</option>
                                                <option value="ventoso">💨 Ventoso</option>
                                            </select>
                                            <small class="form-text text-muted">
                                                Condiciones climáticas del día
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tercera fila: Temperatura y Observaciones -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="temperatura_ambiente" class="form-label fw-semibold">
                                                <i class="fas fa-thermometer-half me-1"></i> Temperatura Ambiente (°C)
                                            </label>
                                            <input type="number" 
                                                   class="form-control form-control-sm" 
                                                   id="temperatura_ambiente" 
                                                   name="temperatura_ambiente" 
                                                   min="-10" 
                                                   max="50" 
                                                   step="0.1"
                                                   placeholder="Ej: 22.5">
                                            <small class="form-text text-muted">
                                                Temperatura en grados Celsius
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="observaciones" class="form-label fw-semibold">
                                                <i class="fas fa-sticky-note me-1"></i> Observaciones Iniciales
                                            </label>
                                            <textarea class="form-control form-control-sm" 
                                                      id="observaciones" 
                                                      name="observaciones" 
                                                      rows="3" 
                                                      placeholder="Observaciones sobre el estado del atleta, condiciones especiales, etc."></textarea>
                                            <small class="form-text text-muted">
                                                Notas adicionales sobre la evaluación
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tests Disponibles -->
                        <div class="form-section mb-4">
                            <div class="section-header mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="section-title mb-0">
                                        <i class="fas fa-clipboard-list text-success me-2"></i>
                                        Tests Disponibles para la Evaluación
                                    </h6>
                                    <div class="progress-indicator">
                                        <span class="badge bg-info" id="progress-badge">
                                            <i class="fas fa-tasks me-1"></i>
                                            <span id="tests-completados">0</span> / <span id="tests-totales">0</span> completados
                                        </span>
                                    </div>
                                </div>
                                <p class="text-muted mb-0">
                                    Complete directamente los tests que considere necesarios. Cada test se guardará automáticamente al hacer clic en "Guardar Test".
                                </p>
                                <div class="mt-2">
                                    <small class="text-info">
                                        <i class="fas fa-keyboard me-1"></i> 
                                        <strong>Atajo:</strong> Presiona <kbd>Enter</kbd> en el campo "Resultado" para guardar rápidamente el test.
                                        <br>
                                        <i class="fas fa-keyboard me-1"></i> 
                                        Presiona <kbd>Ctrl + Enter</kbd> en campos de tiempo u observaciones para guardar.
                                    </small>
                                </div>
                            </div>
                            
                            <?php if (!empty($tests)): ?>
                                <?php foreach ($tests as $categoria => $testList): ?>
                                    <div class="category-section mb-4">
                                        <h6 class="category-header">
                                            <i class="fas fa-folder-open text-primary me-2"></i>
                                            <?php echo ucfirst(str_replace('_', ' ', $categoria)); ?>
                                        </h6>
                                        
                                        <div class="form-row">
                                            <?php foreach ($testList as $test): ?>
                                                <?php 
                                                // Tests que NO requieren tiempo (mediciones estáticas)
                                                $testsSinTiempo = [
                                                    'Envergadura', 'Talla Sentado', 'Salto Vertical', 
                                                    'Flexibilidad de Hombros', 'Sit and Reach',
                                                    'Altura', 'Peso', 'Perímetro', 'Diámetro',
                                                    'Pliegue', 'Longitud', 'Ancho'
                                                ];
                                                $nombreTestLower = strtolower($test['nombre']);
                                                $requiereTiempo = true;
                                                
                                                foreach ($testsSinTiempo as $testSinTiempo) {
                                                    if (stripos($test['nombre'], $testSinTiempo) !== false) {
                                                        $requiereTiempo = false;
                                                        break;
                                                    }
                                                }
                                                
                                                $colClass = $requiereTiempo ? 'col-md-6' : 'col-12';
                                                ?>
                                                <div class="form-field">
                                                    <div class="field-card test-card border-2" id="test-card-<?php echo $test['id']; ?>" data-test-id="<?php echo $test['id']; ?>">
                                                        <div class="test-header d-flex align-items-center mb-3">
                                                            <div class="test-icon me-3">
                                                                <i class="fas fa-<?php echo $test['icono']; ?> text-success"></i>
                                                            </div>
                                                            <div class="test-info flex-grow-1">
                                                                <h6 class="test-title mb-1"><?php echo htmlspecialchars($test['nombre']); ?></h6>
                                                                <p class="test-desc text-muted mb-0 small">
                                                                    <?php echo htmlspecialchars($test['descripcion']); ?>
                                                                </p>
                                                                <small class="text-info">
                                                                    <i class="fas fa-info-circle me-1"></i>
                                                                    Unidad: <?php echo htmlspecialchars($test['unidad_medida']); ?>
                                                                    <?php if (!$requiereTiempo): ?>
                                                                        <span class="badge bg-light text-dark ms-2">
                                                                            <i class="fas fa-clock-o me-1" style="text-decoration: line-through;"></i>
                                                                            Sin tiempo
                                                                        </span>
                                                                    <?php endif; ?>
                                                                </small>
                                                            </div>
                                                            <div class="test-status">
                                                                <span class="badge bg-secondary" id="status-<?php echo $test['id']; ?>">
                                                                    <i class="fas fa-clock me-1"></i> Pendiente
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Campos del Test -->
                                                        <div class="test-inputs">
                                                            <div class="row g-2 mb-3">
                                                                
                                                                <div class="<?php echo $colClass; ?>">
                                                                    <label for="resultado-<?php echo $test['id']; ?>" class="form-label fw-semibold">
                                                                        <i class="fas fa-chart-line me-1"></i> Resultado *
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <input type="number" 
                                                                               class="form-control form-control-sm test-resultado" 
                                                                               id="resultado-<?php echo $test['id']; ?>" 
                                                                               data-test-id="<?php echo $test['id']; ?>"
                                                                               data-requiere-tiempo="<?php echo $requiereTiempo ? 'true' : 'false'; ?>"
                                                                               step="0.01" 
                                                                               placeholder="Ingresa el resultado">
                                                                        <span class="input-group-text small"><?php echo htmlspecialchars($test['unidad_medida']); ?></span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <?php if ($requiereTiempo): ?>
                                                                <div class="col-md-6">
                                                                    <label for="tiempo-<?php echo $test['id']; ?>" class="form-label fw-semibold">
                                                                        <i class="fas fa-stopwatch me-1"></i> Tiempo
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <input type="number" 
                                                                               class="form-control form-control-sm test-tiempo" 
                                                                               id="tiempo-<?php echo $test['id']; ?>" 
                                                                               data-test-id="<?php echo $test['id']; ?>"
                                                                               step="0.01" 
                                                                               placeholder="Tiempo">
                                                                        <span class="input-group-text small">seg</span>
                                                                    </div>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            
                                                            <div class="row g-2">
                                                                <div class="col-12">
                                                                    <label for="observaciones-<?php echo $test['id']; ?>" class="form-label fw-semibold">
                                                                        <i class="fas fa-sticky-note me-1"></i> Observaciones del Test
                                                                    </label>
                                                                    <textarea class="form-control form-control-sm test-observaciones" 
                                                                              id="observaciones-<?php echo $test['id']; ?>" 
                                                                              data-test-id="<?php echo $test['id']; ?>"
                                                                              rows="2" 
                                                                              placeholder="Observaciones específicas de este test..."></textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                                <button type="button" 
                                                                        class="btn btn-success btn-sm save-test-btn" 
                                                                        data-test-id="<?php echo $test['id']; ?>"
                                                                        onclick="guardarTest(<?php echo $test['id']; ?>)">
                                                                    <i class="fas fa-save me-1"></i> Guardar Test
                                                                </button>
                                                                <button type="button" 
                                                                        class="btn btn-outline-warning btn-sm" 
                                                                        onclick="limpiarTest(<?php echo $test['id']; ?>)">
                                                                    <i class="fas fa-eraser me-1"></i> Limpiar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No hay tests disponibles en este momento.
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-center align-items-center pt-3 border-top gap-3">
                            <div class="d-flex gap-2">
                                <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                                <button type="reset" class="btn btn-outline-warning" onclick="resetForm()">
                                    <i class="fas fa-undo me-1"></i> Restablecer
                                </button>
                            </div>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-check me-1"></i> Crear Evaluación
                            </button>
                        </div>
                    </form>
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
    padding: 2rem;
    border-left: 5px solid #28a745;
    margin-bottom: 2rem;
}

.section-header {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.section-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* Layout flexbox para formularios */
.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-field {
    flex: 1;
    min-width: 280px;
}

.field-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.field-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: #28a745;
    transform: translateY(-2px);
}

/* Test cards específicas */
.test-card {
    min-height: 120px;
}

.test-header {
    padding: 0.75rem 0;
}

.test-icon {
    width: 40px;
    height: 40px;
    background: #e9f5ee;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.test-title {
    color: #495057;
    font-weight: 600;
    font-size: 0.9rem;
}

.test-desc {
    font-size: 0.8rem;
    line-height: 1.3;
}

/* Category headers */
.category-header {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #dee2e6;
}

/* Controles de formulario */
.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
    border-radius: 6px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

.form-control-sm:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

/* Validación */
.was-validated .form-control:valid {
    border-color: #28a745;
}

.was-validated .form-control:invalid {
    border-color: #dc3545;
}

/* Responsive */
@media (max-width: 768px) {
    .form-field {
        min-width: 100%;
    }
    
    .field-card {
        padding: 1rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
}

/* Estados de Tests */
.test-card {
    transition: all 0.3s ease;
    position: relative;
}

.test-card.border-success {
    background: linear-gradient(135deg, #f8fff9 0%, #ffffff 100%);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.15);
}

.test-inputs {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.test-status {
    display: flex;
    align-items: center;
}

.test-status .badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 20px;
    font-weight: 500;
}

/* Input groups para tests */
.input-group-text {
    background-color: #e9ecef;
    border-color: #ced4da;
    color: #6c757d;
    font-size: 0.8rem;
    font-weight: 500;
}

/* Animaciones para test completado */
@keyframes testCompletado {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.test-card.completado {
    animation: testCompletado 0.6s ease-in-out;
}

/* Mensajes de test */
.test-message {
    border-radius: 6px;
    font-size: 0.85rem;
    padding: 0.5rem 0.75rem;
}

.test-message .btn-close-sm {
    font-size: 0.7rem;
    padding: 0.25rem;
}

/* Responsive para campos de test */
@media (max-width: 768px) {
    .test-inputs .col-md-6 {
        margin-bottom: 1rem;
    }
    
    .test-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .test-status {
        align-self: flex-end;
    }
}

/* Validación visual para tests */
.test-resultado.is-valid {
    border-color: #28a745;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.195-.174 3.062-2.742-1.31-1.174-1.756 1.566-.724-.646-1.31 1.174z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.test-resultado.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.5 5.5 5 5m0-5-5 5'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* Botones */
.btn {
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.save-test-btn:disabled {
    transform: none;
    box-shadow: none;
}

/* Progress indicator */
.progress-indicator .badge {
    font-size: 0.8rem;
    padding: 0.5rem 1rem;
}

/* Keyboard shortcuts styling */
kbd {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 3px;
    padding: 0.2rem 0.4rem;
    font-size: 0.75rem;
    color: #495057;
}

/* Section title spacing */
.section-title {
    font-weight: 600;
    color: #495057;
}

/* Tests sin tiempo */
.test-card[data-test-id] .test-inputs .col-12 {
    position: relative;
}

/* Badge sin tiempo */
.badge.bg-light {
    border: 1px solid #dee2e6;
}

.badge.bg-light .fa-clock-o {
    opacity: 0.6;
}
</style>

<script>
// Validación simple del formulario
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Aplicar animaciones a las cards
    const fieldCards = document.querySelectorAll('.field-card');
    fieldCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);
    });

    // Validación del formulario
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Función para reset del formulario
    window.resetForm = function() {
        if (confirm('¿Está seguro de que desea restablecer el formulario? Se perderán todos los datos ingresados.')) {
            const form = document.querySelector('.needs-validation');
            form.reset();
            form.classList.remove('was-validated');
            
            // Limpiar validaciones visuales
            const inputs = form.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.classList.remove('is-valid', 'is-invalid');
            });
        }
    };

    // Validación en tiempo real
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });

    // ===============================
    // FUNCIONES PARA MANEJO DE TESTS
    // ===============================
    
    // Variables globales para tracking de tests completados
    window.testsCompletados = new Set();
    window.totalTests = 0;
    
    // Función para actualizar el contador de progreso
    window.actualizarProgreso = function() {
        const completados = window.testsCompletados.size;
        const total = window.totalTests;
        
        document.getElementById('tests-completados').textContent = completados;
        document.getElementById('tests-totales').textContent = total;
        
        const progressBadge = document.getElementById('progress-badge');
        
        if (completados === 0) {
            progressBadge.className = 'badge bg-info';
        } else if (completados < total) {
            progressBadge.className = 'badge bg-warning';
        } else {
            progressBadge.className = 'badge bg-success';
            progressBadge.innerHTML = `<i class="fas fa-check-circle me-1"></i> ${completados} / ${total} completados ✅`;
        }
    };
    
    // Función para guardar un test específico
    window.guardarTest = async function(testId) {
        console.log('🧪 Guardando test ID:', testId);
        
        const resultadoInput = document.getElementById(`resultado-${testId}`);
        const tiempoInput = document.getElementById(`tiempo-${testId}`);
        const observacionesInput = document.getElementById(`observaciones-${testId}`);
        
        const resultado = resultadoInput.value;
        const tiempo = tiempoInput ? tiempoInput.value : null; // Solo si existe el campo
        const observaciones = observacionesInput.value;
        const requiereTiempo = resultadoInput.dataset.requiereTiempo === 'true';
        
        // Validar que al menos el resultado esté completo
        if (!resultado || resultado.trim() === '') {
            alert('⚠️ Por favor, ingresa un resultado para el test.');
            document.getElementById(`resultado-${testId}`).focus();
            return;
        }
        
        // Obtener datos de la evaluación
        const atletaId = <?php echo $atleta['id']; ?>;
        const fechaEvaluacion = document.getElementById('fecha_evaluacion').value;
        const horaInicio = document.getElementById('hora_inicio').value || '<?php echo date('H:i'); ?>';
        const clima = document.getElementById('clima').value;
        const temperatura = document.getElementById('temperatura_ambiente').value;
        const observacionesGenerales = document.getElementById('observaciones').value;
        
        // Preparar datos para envío
        const datosTest = {
            test_id: testId,
            atleta_id: atletaId,
            resultado: parseFloat(resultado),
            tiempo: (tiempo && tiempo.trim() !== '') ? parseFloat(tiempo) : null,
            observaciones: observaciones,
            fecha_evaluacion: fechaEvaluacion,
            hora_inicio: horaInicio,
            clima: clima,
            temperatura_ambiente: temperatura ? parseFloat(temperatura) : null,
            observaciones_generales: observacionesGenerales,
            requiere_tiempo: requiereTiempo
        };
        
        console.log('📤 Enviando datos:', datosTest);
        
        try {
            // Mostrar loading en el botón
            const botonGuardar = document.querySelector(`[data-test-id="${testId}"].save-test-btn`);
            const textoOriginal = botonGuardar.innerHTML;
            botonGuardar.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Guardando...';
            botonGuardar.disabled = true;
            
            // Enviar datos vía AJAX
            const response = await fetch('index.php?controller=Evaluacion&action=guardarTestAjax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(datosTest)
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Marcar test como completado
                marcarTestCompletado(testId);
                
                // Mostrar mensaje de éxito
                mostrarMensajeTest(testId, 'success', '✅ Test guardado exitosamente');
                
                console.log('✅ Test guardado:', result);
            } else {
                mostrarMensajeTest(testId, 'error', '❌ Error: ' + (result.message || 'No se pudo guardar el test'));
                console.error('❌ Error al guardar:', result);
            }
            
        } catch (error) {
            mostrarMensajeTest(testId, 'error', '❌ Error de conexión: ' + error.message);
            console.error('❌ Error de red:', error);
        } finally {
            // Restaurar botón
            const botonGuardar = document.querySelector(`[data-test-id="${testId}"].save-test-btn`);
            botonGuardar.innerHTML = textoOriginal;
            botonGuardar.disabled = false;
        }
    };
    
    // Función para marcar test como completado visualmente
    window.marcarTestCompletado = function(testId) {
        const testCard = document.getElementById(`test-card-${testId}`);
        const statusBadge = document.getElementById(`status-${testId}`);
        
        // Cambiar borde a verde
        testCard.classList.remove('border-secondary', 'border-warning');
        testCard.classList.add('border-success', 'border-3');
        
        // Actualizar badge de estado
        statusBadge.className = 'badge bg-success';
        statusBadge.innerHTML = '<i class="fas fa-check me-1"></i> Completado';
        
        // Agregar a la lista de tests completados
        window.testsCompletados.add(testId);
        
        // Actualizar el contador de progreso
        actualizarProgreso();
        
        // Animación de éxito
        testCard.style.transition = 'all 0.5s ease';
        testCard.style.transform = 'scale(1.02)';
        
        setTimeout(() => {
            testCard.style.transform = 'scale(1)';
        }, 500);
        
        console.log('✅ Test', testId, 'marcado como completado');
    };
    
    // Función para limpiar un test
    window.limpiarTest = function(testId) {
        if (confirm('¿Está seguro de que desea limpiar este test?')) {
            document.getElementById(`resultado-${testId}`).value = '';
            
            // Solo limpiar tiempo si el campo existe
            const tiempoInput = document.getElementById(`tiempo-${testId}`);
            if (tiempoInput) {
                tiempoInput.value = '';
            }
            
            document.getElementById(`observaciones-${testId}`).value = '';
            
            // Quitar marcado de completado
            const testCard = document.getElementById(`test-card-${testId}`);
            const statusBadge = document.getElementById(`status-${testId}`);
            
            testCard.classList.remove('border-success', 'border-3');
            testCard.classList.add('border-secondary');
            
            statusBadge.className = 'badge bg-secondary';
            statusBadge.innerHTML = '<i class="fas fa-clock me-1"></i> Pendiente';
            
            // Remover de tests completados
            window.testsCompletados.delete(testId);
            
            // Actualizar el contador de progreso
            actualizarProgreso();
            
            // Limpiar mensajes
            const mensaje = testCard.querySelector('.test-message');
            if (mensaje) {
                mensaje.remove();
            }
            
            console.log('🧹 Test', testId, 'limpiado');
        }
    };
    
    // Función para mostrar mensajes en el test
    window.mostrarMensajeTest = function(testId, tipo, mensaje) {
        const testCard = document.getElementById(`test-card-${testId}`);
        
        // Remover mensaje anterior si existe
        const mensajeAnterior = testCard.querySelector('.test-message');
        if (mensajeAnterior) {
            mensajeAnterior.remove();
        }
        
        // Crear nuevo mensaje
        const alertClass = tipo === 'success' ? 'alert-success' : 'alert-danger';
        const mensajeDiv = document.createElement('div');
        mensajeDiv.className = `alert ${alertClass} alert-dismissible fade show test-message mt-2 mb-0`;
        mensajeDiv.innerHTML = `
            <small>${mensaje}</small>
            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
        `;
        
        // Insertar mensaje
        const testInputs = testCard.querySelector('.test-inputs');
        testInputs.appendChild(mensajeDiv);
        
        // Auto-ocultar después de 5 segundos
        setTimeout(() => {
            if (mensajeDiv && mensajeDiv.parentNode) {
                mensajeDiv.remove();
            }
        }, 5000);
    };
    
    // Event listeners para auto-validación de campos
    document.querySelectorAll('.test-resultado').forEach(input => {
        input.addEventListener('input', function() {
            const testId = this.dataset.testId;
            if (this.value && this.value.trim() !== '') {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
        
        // Guardar test automáticamente al presionar Enter
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const testId = this.dataset.testId;
                if (this.value && this.value.trim() !== '') {
                    guardarTest(testId);
                }
            }
        });
    });
    
    // Event listeners para tiempo y observaciones
    document.querySelectorAll('.test-tiempo, .test-observaciones').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.ctrlKey) {
                e.preventDefault();
                const testId = this.dataset.testId;
                const resultadoInput = document.getElementById(`resultado-${testId}`);
                if (resultadoInput && resultadoInput.value && resultadoInput.value.trim() !== '') {
                    guardarTest(testId);
                }
            }
        });
    });
    
    // Mostrar información sobre tests sin tiempo en consola
    document.querySelectorAll('.test-resultado[data-requiere-tiempo="false"]').forEach(input => {
        const testId = input.dataset.testId;
        const testCard = document.getElementById(`test-card-${testId}`);
        const testTitle = testCard.querySelector('.test-title').textContent;
        console.log(`ℹ️ Test "${testTitle}" (ID: ${testId}) configurado SIN campo de tiempo`);
    });
    
    // Mostrar resumen de configuración
    const testsConTiempo = document.querySelectorAll('.test-resultado[data-requiere-tiempo="true"]').length;
    const testsSinTiempo = document.querySelectorAll('.test-resultado[data-requiere-tiempo="false"]').length;
    console.log(`📊 Configuración de tests: ${testsConTiempo} con tiempo, ${testsSinTiempo} sin tiempo`);
    
    // Inicializar contador de tests
    window.totalTests = document.querySelectorAll('.test-card').length;
    actualizarProgreso();
    
    console.log('🧪 Sistema de tests inicializado correctamente');
    console.log('📊 Total de tests disponibles:', window.totalTests);
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 