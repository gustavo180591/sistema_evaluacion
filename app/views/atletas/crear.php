<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-user-plus text-primary"></i> 
                        <?php if (isset($_GET['adaptado'])): ?>
                            Nuevo Atleta Adaptado
                        <?php else: ?>
                            Nuevo Atleta
                        <?php endif; ?>
                    </h1>
                    <p class="text-muted mb-0">
                        <?php if (isset($_GET['adaptado'])): ?>
                            Complete la información para registrar un nuevo atleta adaptado en el sistema
                        <?php else: ?>
                            Complete la información para registrar un nuevo atleta en el sistema
                        <?php endif; ?>
                    </p>
                </div>
                <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <!-- Alertas -->
            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Error:</strong>
                            <ul class="mb-0 mt-1">
                                <?php foreach ($errores as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    ¡Excelente! El atleta ha sido registrado correctamente en el sistema.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Formulario Principal -->
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-plus me-2"></i> 
                        <?php if (isset($_GET['adaptado'])): ?>
                            Datos del Nuevo Atleta Adaptado
                        <?php else: ?>
                            Datos del Nuevo Atleta
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="index.php?controller=Atleta&action=crear<?php echo isset($_GET['adaptado']) ? '&adaptado=1' : ''; ?>" class="needs-validation" novalidate id="formAtleta">
                        
                        <!-- Información Personal -->
                        <div class="form-section mb-4">
                            
                            <!-- Primera fila: Nombre, Apellido y DNI -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="nombre" class="form-label fw-semibold">
                                                <i class="fas fa-user me-1"></i> Nombre <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   id="nombre" 
                                                   name="nombre" 
                                                   required 
                                                   maxlength="100"
                                                   value="<?php echo htmlspecialchars($formData['nombre'] ?? ''); ?>"
                                                   placeholder="Ingrese nombre">
                                            <div class="invalid-feedback">
                                                El nombre es obligatorio
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="apellido" class="form-label fw-semibold">
                                                <i class="fas fa-user me-1"></i> Apellido <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   id="apellido" 
                                                   name="apellido" 
                                                   required 
                                                   maxlength="100"
                                                   value="<?php echo htmlspecialchars($formData['apellido'] ?? ''); ?>"
                                                   placeholder="Ingrese apellido">
                                            <div class="invalid-feedback">
                                                El apellido es obligatorio
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="dni" class="form-label fw-semibold">
                                                <i class="fas fa-id-card me-1"></i> DNI <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   id="dni" 
                                                   name="dni" 
                                                   required 
                                                   maxlength="20"
                                                   value="<?php echo htmlspecialchars($formData['dni'] ?? ''); ?>"
                                                   placeholder="Ej: 12.345.678-9">
                                            <div class="invalid-feedback">
                                                El DNI es obligatorio
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda fila: Sexo, Fecha Nacimiento y Discapacidad -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="sexo" class="form-label fw-semibold">
                                                <i class="fas fa-venus-mars me-1"></i> Sexo <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select form-select-sm" 
                                                    id="sexo" 
                                                    name="sexo" 
                                                    required>
                                                <option value="">Seleccionar...</option>
                                                <option value="M" <?php echo (isset($formData['sexo']) && $formData['sexo'] === 'M') ? 'selected' : ''; ?>>👨 Masculino</option>
                                                <option value="F" <?php echo (isset($formData['sexo']) && $formData['sexo'] === 'F') ? 'selected' : ''; ?>>👩 Femenino</option>
                                                <option value="Otro" <?php echo (isset($formData['sexo']) && $formData['sexo'] === 'Otro') ? 'selected' : ''; ?>>⚧️ Otro</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Selecciona el sexo
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="fecha_nacimiento" class="form-label fw-semibold">
                                                <i class="fas fa-calendar me-1"></i> Fecha Nacimiento <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" 
                                                   class="form-control form-control-sm" 
                                                   id="fecha_nacimiento" 
                                                   name="fecha_nacimiento" 
                                                   required 
                                                   max="<?php echo date('Y-m-d'); ?>"
                                                   value="<?php echo htmlspecialchars($formData['fecha_nacimiento'] ?? ''); ?>">
                                            <div class="invalid-feedback">
                                                La fecha de nacimiento es obligatoria
                                            </div>
                                            <small class="text-muted">Edad: <span id="edad-calculada">-</span></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="discapacidad_id" class="form-label fw-semibold">
                                                <i class="fas fa-wheelchair me-1"></i> 
                                                Discapacidad 
                                                <?php if (isset($_GET['adaptado'])): ?>
                                                    <span class="text-danger">*</span>
                                                <?php endif; ?>
                                            </label>
                                            <select class="form-select form-select-sm" 
                                                    id="discapacidad_id" 
                                                    name="discapacidad_id" 
                                                    <?php if (isset($_GET['adaptado'])): ?>required<?php endif; ?>>
                                                <option value="">
                                                    <?php if (isset($_GET['adaptado'])): ?>
                                                        Selecciona una discapacidad
                                                    <?php else: ?>
                                                        No tiene discapacidad
                                                    <?php endif; ?>
                                                </option>
                                                <?php foreach ($discapacidades as $discapacidad): ?>
                                                    <option value="<?php echo $discapacidad['id']; ?>" 
                                                            <?php echo (isset($formData['discapacidad_id']) && $formData['discapacidad_id'] == $discapacidad['id']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($discapacidad['nombre']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php if (isset($_GET['adaptado'])): ?>
                                                    Selecciona una discapacidad para el atleta adaptado
                                                <?php else: ?>
                                                    Selecciona si el atleta tiene alguna discapacidad
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medidas Antropométricas -->
                        <div class="form-section mb-4">
                            
                            <!-- Fila de medidas: Altura, Peso, Envergadura, Altura Sentado -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="altura_cm" class="form-label fw-semibold">
                                                <i class="fas fa-ruler-vertical me-1"></i> Altura (cm) <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="altura_cm" 
                                                       name="altura_cm" 
                                                       required 
                                                       step="0.1" 
                                                       min="50" 
                                                       max="250" 
                                                       value="<?php echo htmlspecialchars($formData['altura_cm'] ?? ''); ?>"
                                                       placeholder="Ej: 175.5">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Ingresa una altura válida (50-250 cm)
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="peso_kg" class="form-label fw-semibold">
                                                <i class="fas fa-weight me-1"></i> Peso (kg) <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="peso_kg" 
                                                       name="peso_kg" 
                                                       required 
                                                       step="0.1" 
                                                       min="20" 
                                                       max="200" 
                                                       value="<?php echo htmlspecialchars($formData['peso_kg'] ?? ''); ?>"
                                                       placeholder="Ej: 70.2">
                                                <span class="input-group-text">kg</span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Ingresa un peso válido (20-200 kg)
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="envergadura_cm" class="form-label fw-semibold">
                                                <i class="fas fa-arrows-alt-h me-1"></i> Envergadura (cm) <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="envergadura_cm" 
                                                       name="envergadura_cm" 
                                                       required 
                                                       step="0.1" 
                                                       min="50" 
                                                       max="250" 
                                                       value="<?php echo htmlspecialchars($formData['envergadura_cm'] ?? ''); ?>"
                                                       placeholder="Ej: 180.0">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Ingresa una envergadura válida (50-250 cm)
                                            </div>
                                            <small class="text-muted">Distancia entre extremos de brazos extendidos</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card field-card-small">
                                        <div class="form-group">
                                            <label for="altura_sentado_cm" class="form-label fw-semibold">
                                                <i class="fas fa-chair me-1"></i> Altura Sentado (cm) <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input type="number" 
                                                       class="form-control" 
                                                       id="altura_sentado_cm" 
                                                       name="altura_sentado_cm" 
                                                       required 
                                                       step="0.1" 
                                                       min="30" 
                                                       max="150" 
                                                       value="<?php echo htmlspecialchars($formData['altura_sentado_cm'] ?? ''); ?>"
                                                       placeholder="Ej: 92.5">
                                                <span class="input-group-text">cm</span>
                                            </div>
                                            <div class="invalid-feedback">
                                                Ingresa una altura sentado válida (30-150 cm)
                                            </div>
                                            <small class="text-muted">Altura desde el asiento hasta la cabeza</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cálculos automáticos -->
                            <div class="alert alert-light mt-3">
                                <h6><strong>📊 Cálculos Automáticos:</strong></h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <small class="text-muted">IMC:</small>
                                        <span id="imc-calculado" class="badge bg-info text-dark">-</span>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Relación Altura/Envergadura:</small>
                                        <span id="relacion-calculada" class="badge bg-info text-dark">-</span>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Proporción Tronco:</small>
                                        <span id="proporcion-calculada" class="badge bg-info text-dark">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lateralidad -->
                        <div class="form-section mb-4">
                            
                            <!-- Fila de lateralidades -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="lateralidad_visual" class="form-label fw-semibold">
                                                <i class="fas fa-eye me-1"></i> Lateralidad Visual <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select form-select-sm" 
                                                    id="lateralidad_visual" 
                                                    name="lateralidad_visual" 
                                                    required>
                                                <option value="">Seleccionar...</option>
                                                <option value="Izquierdo" <?php echo (isset($formData['lateralidad_visual']) && $formData['lateralidad_visual'] === 'Izquierdo') ? 'selected' : ''; ?>>👁️ Ojo Izquierdo Dominante</option>
                                                <option value="Derecho" <?php echo (isset($formData['lateralidad_visual']) && $formData['lateralidad_visual'] === 'Derecho') ? 'selected' : ''; ?>>👁️ Ojo Derecho Dominante</option>
                                                <option value="Ambidiestro" <?php echo (isset($formData['lateralidad_visual']) && $formData['lateralidad_visual'] === 'Ambidiestro') ? 'selected' : ''; ?>>👀 Sin Dominancia Clara</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Selecciona la lateralidad visual
                                            </div>
                                            <small class="text-muted">Ojo dominante para apuntar o mirar por un tubo</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="lateralidad_podal" class="form-label fw-semibold">
                                                <i class="fas fa-running me-1"></i> Lateralidad Podal <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select form-select-sm" 
                                                    id="lateralidad_podal" 
                                                    name="lateralidad_podal" 
                                                    required>
                                                <option value="">Seleccionar...</option>
                                                <option value="Izquierdo" <?php echo (isset($formData['lateralidad_podal']) && $formData['lateralidad_podal'] === 'Izquierdo') ? 'selected' : ''; ?>>🦶 Pie Izquierdo Dominante</option>
                                                <option value="Derecho" <?php echo (isset($formData['lateralidad_podal']) && $formData['lateralidad_podal'] === 'Derecho') ? 'selected' : ''; ?>>🦶 Pie Derecho Dominante</option>
                                                <option value="Ambidiestro" <?php echo (isset($formData['lateralidad_podal']) && $formData['lateralidad_podal'] === 'Ambidiestro') ? 'selected' : ''; ?>>👣 Sin Dominancia Clara</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Selecciona la lateralidad podal
                                            </div>
                                            <small class="text-muted">Pie dominante para patear un balón</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-center align-items-center pt-3 border-top gap-3">
                            <div class="d-flex gap-2">
                                <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                                <button type="reset" class="btn btn-outline-warning" id="btnReset">
                                    <i class="fas fa-undo me-1"></i> Limpiar
                                </button>
                            </div>
                            <button type="submit" class="btn btn-success px-4" id="btnGuardar">
                                <i class="fas fa-user-plus me-1"></i> 
                                <?php if (isset($_GET['adaptado'])): ?>
                                    Crear Atleta Adaptado
                                <?php else: ?>
                                    Crear Atleta
                                <?php endif; ?>
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

.field-card .form-control,
.field-card .form-select {
    border: 1px solid #ced4da;
    border-radius: 6px;
    transition: all 0.15s ease-in-out;
}

.field-card .form-control:focus,
.field-card .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
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

/* Campos pequeños */
.field-card .form-control-sm,
.field-card .form-select-sm {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    border-radius: 6px;
    width: 100%;
}

.field-card .input-group-sm .form-control {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.field-card .btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

/* Input groups compactos */
.field-card .input-group-sm {
    width: 100%;
}

/* Labels más compactos */
.field-card .form-label {
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
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
    
    /* En móviles, mantener la proporción pero apilados */
    .field-card-small,
    .field-card-large {
        background: white;
        border-left: 3px solid #0d6efd;
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
}

/* Efectos hover */
.form-section:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
}

.btn:hover {
    transform: translateY(-1px);
}

/* Estilos para botones dentro de inputs */
.input-group {
    position: relative;
}

.input-group .position-absolute {
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    display: flex;
    align-items: center;
    padding-right: 10px;
    z-index: 10;
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

/* Character counter */
.char-counter {
    font-size: 0.75rem;
    color: #6c757d;
    text-align: right;
    margin-top: 0.25rem;
}

.char-counter.warning {
    color: #f57c00;
}

.char-counter.danger {
    color: #dc3545;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formAtleta');
    const btnSubmit = document.getElementById('btnGuardar');
    const btnReset = document.getElementById('btnReset');
    
    // Validación del formulario
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            // Loading state
            btnSubmit.classList.add('loading');
            btnSubmit.disabled = true;
            
            // Confirmación antes de enviar
            const nombre = document.getElementById('nombre').value;
            const apellido = document.getElementById('apellido').value;
            
            if (!confirm('¿Estás seguro de que deseas registrar a ' + nombre + ' ' + apellido + '?')) {
                event.preventDefault();
                btnSubmit.classList.remove('loading');
                btnSubmit.disabled = false;
                return;
            }
        }
        form.classList.add('was-validated');
    });

    // Reset del formulario con confirmación
    if (btnReset) {
        btnReset.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('¿Está seguro de que desea limpiar todos los campos? Esta acción no se puede deshacer.')) {
                form.reset();
                form.classList.remove('was-validated');
                
                // Limpiar cálculos
                document.getElementById('edad-calculada').textContent = '-';
                document.getElementById('imc-calculado').textContent = '-';
                document.getElementById('relacion-calculada').textContent = '-';
                document.getElementById('proporcion-calculada').textContent = '-';
                
                // Reset badges
                const badges = document.querySelectorAll('.badge');
                badges.forEach(badge => {
                    badge.className = 'badge bg-info text-dark';
                });
                
                // Limpiar validaciones
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.classList.remove('is-valid', 'is-invalid');
                });
            }
        });
    }

    // Validación en tiempo real para todos los campos
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') || this.classList.contains('is-valid')) {
                if (this.checkValidity()) {
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                }
            }
        });
    });

    // Cálculo automático de edad
    document.getElementById('fecha_nacimiento').addEventListener('change', function() {
        if (this.value) {
            const fechaNacimiento = new Date(this.value);
            const hoy = new Date();
            let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            const mes = hoy.getMonth() - fechaNacimiento.getMonth();
            
            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }
            
            document.getElementById('edad-calculada').textContent = edad + ' años';
        } else {
            document.getElementById('edad-calculada').textContent = '-';
        }
    });

    // Cálculos automáticos de medidas
    function calcularMedidas() {
        const altura = parseFloat(document.getElementById('altura_cm').value);
        const peso = parseFloat(document.getElementById('peso_kg').value);
        const envergadura = parseFloat(document.getElementById('envergadura_cm').value);
        const alturaSentado = parseFloat(document.getElementById('altura_sentado_cm').value);
        
        // IMC
        if (altura && peso) {
            const alturaM = altura / 100;
            const imc = peso / (alturaM * alturaM);
            document.getElementById('imc-calculado').textContent = imc.toFixed(1);
            
            // Cambiar color del badge según IMC
            const badge = document.getElementById('imc-calculado');
            badge.className = 'badge ';
            if (imc < 18.5) {
                badge.className += 'bg-warning text-dark';
            } else if (imc < 25) {
                badge.className += 'bg-success text-white';
            } else if (imc < 30) {
                badge.className += 'bg-warning text-dark';
            } else {
                badge.className += 'bg-danger text-white';
            }
        } else {
            document.getElementById('imc-calculado').textContent = '-';
            document.getElementById('imc-calculado').className = 'badge bg-info text-dark';
        }
        
        // Relación altura/envergadura
        if (altura && envergadura) {
            const relacion = altura / envergadura;
            document.getElementById('relacion-calculada').textContent = relacion.toFixed(3);
        } else {
            document.getElementById('relacion-calculada').textContent = '-';
        }
        
        // Proporción del tronco
        if (altura && alturaSentado) {
            const proporcion = (alturaSentado / altura) * 100;
            document.getElementById('proporcion-calculada').textContent = proporcion.toFixed(1) + '%';
        } else {
            document.getElementById('proporcion-calculada').textContent = '-';
        }
    }

    // Event listeners para cálculos automáticos
    ['altura_cm', 'peso_kg', 'envergadura_cm', 'altura_sentado_cm'].forEach(function(id) {
        document.getElementById(id).addEventListener('input', calcularMedidas);
    });

    // Validación del DNI (formato básico)
    document.getElementById('dni').addEventListener('blur', function() {
        const dni = this.value.trim();
        if (dni && dni.length < 7) {
            this.setCustomValidity('El DNI debe tener al menos 7 caracteres');
        } else {
            this.setCustomValidity('');
        }
    });

    // Animaciones de entrada
    const fieldCards = document.querySelectorAll('.field-card');
    fieldCards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
        card.classList.add('fadeInUp');
    });
});

// Animación CSS
const style = document.createElement('style');
style.textContent = `
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
`;
document.head.appendChild(style);
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
