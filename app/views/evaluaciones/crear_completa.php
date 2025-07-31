<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-plus-circle text-success"></i> Nueva Evaluación Completa
                    </h1>
                    <p class="text-muted mb-0">
                        Crea una evaluación completa: selecciona o registra atleta y configura los parámetros de evaluación
                    </p>
                </div>
                <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>

            <!-- Alertas -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-<?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
                        <div>
                            <strong><?php echo ($_SESSION['tipo_mensaje'] === 'success') ? 'Éxito:' : 'Error:'; ?></strong>
                            <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php 
                unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); 
                ?>
            <?php endif; ?>

            <!-- Formulario Principal -->
            <form method="POST" class="needs-validation" novalidate id="evaluacionCompletaForm">
                
                <!-- PASO 1: Selección de Atleta -->
                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-primary text-white py-4">
                        <h5 class="card-title mb-0">
                            <span class="step-number">1</span>
                            <i class="fas fa-user-plus me-2"></i> Seleccionar o Registrar Atleta
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Opción: Atleta Existente o Nuevo -->
                        <div class="form-section mb-4">
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_atleta" id="atleta_existente_radio" value="existente" checked>
                                            <label class="form-check-label fw-semibold" for="atleta_existente_radio">
                                                <i class="fas fa-search me-2"></i> Seleccionar Atleta Existente
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_atleta" id="atleta_nuevo_radio" value="nuevo">
                                            <label class="form-check-label fw-semibold" for="atleta_nuevo_radio">
                                                <i class="fas fa-user-plus me-2"></i> Registrar Nuevo Atleta
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Atleta Existente -->
                        <div id="seccion_atleta_existente" class="atleta-section">
                            <div class="form-section">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-list text-primary me-2"></i>
                                        Seleccionar Atleta del Sistema
                                    </h6>
                                </div>
                                <div class="form-row">
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="atleta_existente" class="form-label fw-semibold">
                                                    <i class="fas fa-user me-1"></i> Atleta <span class="text-danger">*</span>
                                                </label>
                                                <select name="atleta_existente" id="atleta_existente" class="form-control">
                                                    <option value="">Seleccionar atleta...</option>
                                                    <?php foreach ($atletas as $atleta): ?>
                                                        <option value="<?php echo $atleta['id']; ?>">
                                                            <?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?>
                                                            - DNI: <?php echo htmlspecialchars($atleta['dni']); ?>
                                                            <?php if ($atleta['evaluador_nombre']): ?>
                                                                (Evaluador: <?php echo htmlspecialchars($atleta['evaluador_nombre']); ?>)
                                                            <?php endif; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Selecciona un atleta del sistema
                                                </div>
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Elige un atleta ya registrado en el sistema
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Nuevo Atleta -->
                        <div id="seccion_atleta_nuevo" class="atleta-section" style="display: none;">
                            
                            <!-- Información Personal -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-id-card text-success me-2"></i>
                                        Información Personal del Atleta
                                    </h6>
                                </div>
                                <div class="form-row">
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="nombre_atleta" class="form-label fw-semibold">
                                                    <i class="fas fa-user me-1"></i> Nombre <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="nombre_atleta" name="nombre_atleta" 
                                                       placeholder="Nombre del atleta">
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="apellido_atleta" class="form-label fw-semibold">
                                                    <i class="fas fa-user me-1"></i> Apellido <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="apellido_atleta" name="apellido_atleta" 
                                                       placeholder="Apellido del atleta">
                                                <div class="invalid-feedback">
                                                    El apellido es obligatorio
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="dni_atleta" class="form-label fw-semibold">
                                                    <i class="fas fa-id-card me-1"></i> DNI <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="dni_atleta" name="dni_atleta" 
                                                       placeholder="Número de documento">
                                                <div class="invalid-feedback">
                                                    El DNI es obligatorio
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="edad_atleta" class="form-label fw-semibold">
                                                    <i class="fas fa-birthday-cake me-1"></i> Edad <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control" id="edad_atleta" name="edad_atleta" 
                                                       min="5" max="100" placeholder="Años">
                                                <div class="invalid-feedback">
                                                    La edad es obligatoria
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="sexo_atleta" class="form-label fw-semibold">
                                                    <i class="fas fa-venus-mars me-1"></i> Sexo <span class="text-danger">*</span>
                                                </label>
                                                <select name="sexo_atleta" id="sexo_atleta" class="form-control">
                                                    <option value="">Seleccionar...</option>
                                                    <option value="masculino">Masculino</option>
                                                    <option value="femenino">Femenino</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Selecciona el sexo
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="nacionalidad_atleta" class="form-label fw-semibold">
                                                    <i class="fas fa-flag me-1"></i> Nacionalidad
                                                </label>
                                                <select name="nacionalidad_atleta" id="nacionalidad_atleta" class="form-control">
                                                    <option value="">Seleccionar...</option>
                                                    <optgroup label="Países Miembros del Mercosur">
                                                        <option value="Argentina">🇦🇷 Argentina</option>
                                                        <option value="Brasil">🇧🇷 Brasil</option>
                                                        <option value="Paraguay">🇵🇾 Paraguay</option>
                                                        <option value="Uruguay">🇺🇾 Uruguay</option>
                                                    </optgroup>
                                                    <optgroup label="En Proceso de Adhesión">
                                                        <option value="Venezuela">🇻🇪 Venezuela</option>
                                                    </optgroup>
                                                    <optgroup label="Países Asociados">
                                                        <option value="Bolivia">🇧🇴 Bolivia</option>
                                                        <option value="Chile">🇨🇱 Chile</option>
                                                        <option value="Colombia">🇨🇴 Colombia</option>
                                                        <option value="Ecuador">🇪🇨 Ecuador</option>
                                                        <option value="Perú">🇵🇪 Perú</option>
                                                        <option value="Guyana">🇬🇾 Guyana</option>
                                                        <option value="Suriname">🇸🇷 Suriname</option>
                                                    </optgroup>
                                                    <optgroup label="Otros Países">
                                                        <option value="España">🇪🇸 España</option>
                                                        <option value="Italia">🇮🇹 Italia</option>
                                                        <option value="Francia">🇫🇷 Francia</option>
                                                        <option value="Alemania">🇩🇪 Alemania</option>
                                                        <option value="Estados Unidos">🇺🇸 Estados Unidos</option>
                                                        <option value="México">🇲🇽 México</option>
                                                        <option value="Otro">🌍 Otro</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información Física -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-ruler text-warning me-2"></i>
                                        Información Física (Opcional)
                                    </h6>
                                </div>
                                <div class="form-row">
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="altura_atleta" class="form-label fw-semibold">
                                                    <i class="fas fa-arrows-alt-v me-1"></i> Altura (cm)
                                                </label>
                                                <input type="number" class="form-control" id="altura_atleta" name="altura_atleta" 
                                                       step="0.1" min="50" max="250" placeholder="Ej: 175">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="peso_atleta" class="form-label fw-semibold">
                                                    <i class="fas fa-weight me-1"></i> Peso (kg)
                                                </label>
                                                <input type="number" class="form-control" id="peso_atleta" name="peso_atleta" 
                                                       step="0.1" min="20" max="200" placeholder="Ej: 70.5">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lateralidad -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-hand-paper text-info me-2"></i>
                                        Lateralidad (Opcional)
                                    </h6>
                                </div>
                                <div class="form-row">
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="lateralidad_visual" class="form-label fw-semibold">
                                                    <i class="fas fa-eye me-1"></i> Lateralidad Visual
                                                </label>
                                                <select name="lateralidad_visual" id="lateralidad_visual" class="form-control">
                                                    <option value="">Seleccionar...</option>
                                                    <option value="Derecho">👁️ Derecha</option>
                                                    <option value="Izquierdo">👁️ Izquierda</option>
                                                    <option value="Ambidiestro">👀 Ambos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-field">
                                        <div class="field-card">
                                            <div class="form-group">
                                                <label for="lateralidad_podal" class="form-label fw-semibold">
                                                    <i class="fas fa-running me-1"></i> Lateralidad Podal
                                                </label>
                                                <select name="lateralidad_podal" id="lateralidad_podal" class="form-control">
                                                    <option value="">Seleccionar...</option>
                                                    <option value="Derecho">🦶 Derecha</option>
                                                    <option value="Izquierdo">🦶 Izquierda</option>
                                                    <option value="Ambidiestro">👣 Ambos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- PASO 2: Configuración de la Evaluación -->
                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-success text-white py-4">
                        <h5 class="card-title mb-0">
                            <span class="step-number">2</span>
                            <i class="fas fa-cogs me-2"></i> Configuración de la Evaluación
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        
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

                            <!-- Segunda fila: Lugar y Discapacidad -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="lugar_id" class="form-label fw-semibold">
                                                <i class="fas fa-map-marker-alt me-1"></i> Lugar
                                            </label>
                                            <select name="lugar_id" id="lugar_id" class="form-control">
                                                <option value="">Sin lugar específico</option>
                                                <?php foreach ($lugares as $lugar): ?>
                                                    <option value="<?php echo $lugar['id']; ?>">
                                                        <?php echo htmlspecialchars($lugar['nombre']); ?>
                                                        <?php if ($lugar['zona']): ?>
                                                            - <?php echo htmlspecialchars($lugar['zona']); ?>
                                                        <?php endif; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="text-muted">Opcional: selecciona el lugar de entrenamiento</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="discapacidad_id" class="form-label fw-semibold">
                                                <i class="fas fa-wheelchair me-1"></i> Discapacidad
                                            </label>
                                            <select name="discapacidad_id" id="discapacidad_id" class="form-control">
                                                <option value="">Sin discapacidad</option>
                                                <?php foreach ($discapacidades as $discapacidad): ?>
                                                    <option value="<?php echo $discapacidad['id']; ?>">
                                                        <?php echo htmlspecialchars($discapacidad['nombre']); ?>
                                                        (<?php echo htmlspecialchars($discapacidad['tipo']); ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tercera fila: Clima y Temperatura -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="clima" class="form-label fw-semibold">
                                                <i class="fas fa-cloud me-1"></i> Clima
                                            </label>
                                            <select name="clima" id="clima" class="form-control">
                                                <option value="">Seleccionar clima...</option>
                                                <option value="soleado">☀️ Soleado</option>
                                                <option value="nublado">☁️ Nublado</option>
                                                <option value="lluvioso">🌧️ Lluvioso</option>
                                                <option value="ventoso">💨 Ventoso</option>
                                                <option value="caluroso">🔥 Caluroso</option>
                                                <option value="frio">❄️ Frío</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

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
                            </div>

                            <!-- Cuarta fila: Observaciones -->
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="observaciones_generales" class="form-label fw-semibold">
                                                <i class="fas fa-sticky-note me-1"></i> Observaciones Generales
                                            </label>
                                            <textarea class="form-control form-control-sm" 
                                                      id="observaciones_generales" 
                                                      name="observaciones_generales" 
                                                      rows="3" 
                                                      placeholder="Observaciones sobre el estado del atleta, condiciones especiales, objetivos de la evaluación, etc."></textarea>
                                            <small class="form-text text-muted">
                                                Notas adicionales sobre la evaluación
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Al crear la evaluación, serás redirigido a la página de tests para comenzar las mediciones.
                                </small>
                            </div>
                            <div class="d-flex gap-3">
                                <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-success btn-lg" id="btnCrearEvaluacion">
                                    <i class="fas fa-rocket me-1"></i> Crear Evaluación
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<style>
/* Estilos específicos para el formulario de evaluación completa */
.step-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    font-weight: bold;
    margin-right: 0.5rem;
}

.form-section {
    padding: 1rem 0;
}

.section-header {
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
}

.section-title {
    font-weight: 600;
    color: #495057;
    margin: 0;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-field {
    flex: 1;
    min-width: 250px;
}

.field-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    height: 100%;
    transition: all 0.3s ease;
}

.field-card:hover {
    border-color: #28a745;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.1);
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-control {
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
    border-radius: 6px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.atleta-section {
    transition: all 0.5s ease;
}

.form-check-label {
    color: #495057;
    cursor: pointer;
}

.form-check-input:checked + .form-check-label {
    color: #28a745;
    font-weight: 600;
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
        padding: 0.75rem;
    }
    
    .d-flex.gap-3 {
        flex-direction: column;
        gap: 0.5rem;
    }
}

/* Nacionalidad select styling */
#nacionalidad_atleta optgroup {
    font-weight: bold;
    background-color: #f8f9fa;
}

#nacionalidad_atleta option {
    padding: 0.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Control de radio buttons para tipo de atleta
    const atletaExistenteRadio = document.getElementById('atleta_existente_radio');
    const atletaNuevoRadio = document.getElementById('atleta_nuevo_radio');
    const seccionAtletaExistente = document.getElementById('seccion_atleta_existente');
    const seccionAtletaNuevo = document.getElementById('seccion_atleta_nuevo');

    function toggleSeccionesAtleta() {
        if (atletaExistenteRadio.checked) {
            seccionAtletaExistente.style.display = 'block';
            seccionAtletaNuevo.style.display = 'none';
            
            // Hacer campos de atleta existente requeridos
            document.getElementById('atleta_existente').required = true;
            
            // Quitar requerido de campos de atleta nuevo
            document.getElementById('nombre_atleta').required = false;
            document.getElementById('apellido_atleta').required = false;
            document.getElementById('dni_atleta').required = false;
            document.getElementById('edad_atleta').required = false;
            document.getElementById('sexo_atleta').required = false;
        } else {
            seccionAtletaExistente.style.display = 'none';
            seccionAtletaNuevo.style.display = 'block';
            
            // Quitar requerido de atleta existente
            document.getElementById('atleta_existente').required = false;
            
            // Hacer campos de atleta nuevo requeridos
            document.getElementById('nombre_atleta').required = true;
            document.getElementById('apellido_atleta').required = true;
            document.getElementById('dni_atleta').required = true;
            document.getElementById('edad_atleta').required = true;
            document.getElementById('sexo_atleta').required = true;
        }
    }

    atletaExistenteRadio.addEventListener('change', toggleSeccionesAtleta);
    atletaNuevoRadio.addEventListener('change', toggleSeccionesAtleta);

    // Configurar estado inicial
    toggleSeccionesAtleta();

    // Validación del formulario
    const form = document.getElementById('evaluacionCompletaForm');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            // Mostrar loading en el botón
            const btnCrear = document.getElementById('btnCrearEvaluacion');
            btnCrear.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Creando...';
            btnCrear.disabled = true;
        }
        form.classList.add('was-validated');
    }, false);

    // Animaciones para las cards
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
        }, index * 50);
    });

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

    console.log('🏃‍♂️ Formulario de evaluación completa inicializado');
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 