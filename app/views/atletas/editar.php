<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-user-edit text-primary"></i> Editar Atleta
                    </h1>
                    <p class="text-muted mb-0">Modifica los datos del atleta <?php echo htmlspecialchars(($atleta['nombre'] ?? '') . ' ' . ($atleta['apellido'] ?? '')); ?></p>
                </div>
                <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <!-- Mensajes -->
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-lg me-3"></i>
                        <div>
                            <strong>⚠️ Error:</strong> Ha ocurrido un error al actualizar el atleta. Verifica los datos e intenta nuevamente.
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-lg me-3"></i>
                        <div>
                            <strong>✅ Éxito:</strong> El atleta ha sido actualizado correctamente.
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Formulario Principal -->
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i> Información del Atleta
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    <form method="POST" action="index.php?controller=Atleta&action=editar&id=<?php echo $atleta['id']; ?>" class="needs-validation" novalidate id="atletaForm">
                        
                        <!-- Información Personal -->
                        <div class="form-section mb-4">
                            <div class="section-header">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="step-number me-3">1</div>
                                    <h5 class="mb-0">👤 Información Personal</h5>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="nombre" class="form-label">
                                                <i class="fas fa-user"></i> Nombre *
                                            </label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" 
                                                   required maxlength="100" placeholder="Ingresa el nombre"
                                                   value="<?php echo htmlspecialchars($atleta['nombre'] ?? ''); ?>">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="apellido" class="form-label">
                                                <i class="fas fa-user"></i> Apellido *
                                            </label>
                                            <input type="text" name="apellido" id="apellido" class="form-control" 
                                                   required maxlength="100" placeholder="Ingresa el apellido"
                                                   value="<?php echo htmlspecialchars($atleta['apellido'] ?? ''); ?>">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="dni" class="form-label">
                                                <i class="fas fa-id-card"></i> DNI *
                                            </label>
                                            <input type="text" name="dni" id="dni" class="form-control" 
                                                   required maxlength="20" placeholder="Ej: 12345678"
                                                   value="<?php echo htmlspecialchars($atleta['dni'] ?? ''); ?>">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="edad" class="form-label">
                                                <i class="fas fa-calendar-alt"></i> Edad *
                                            </label>
                                            <input type="number" name="edad" id="edad" class="form-control" 
                                                   required min="5" max="100" placeholder="Ej: 25"
                                                   value="<?php echo htmlspecialchars($atleta['edad'] ?? ''); ?>">
                                              
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="sexo" class="form-label">
                                                <i class="fas fa-venus-mars"></i> Sexo *
                                            </label>
                                            <select name="sexo" id="sexo" class="form-control" required>
                                                <option value="">Seleccionar...</option>
                                                <?php 
                                                // Convertir formato de BD (M/F) a formato de formulario
                                                $sexo_atleta = $atleta['sexo'] ?? '';
                                                if ($sexo_atleta === 'M') $sexo_atleta = 'masculino';
                                                if ($sexo_atleta === 'F') $sexo_atleta = 'femenino';
                                                ?>
                                                <option value="masculino" <?php echo ($sexo_atleta == 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                                                <option value="femenino" <?php echo ($sexo_atleta == 'femenino') ? 'selected' : ''; ?>>Femenino</option>
                                                <option value="otro" <?php echo ($sexo_atleta == 'otro') ? 'selected' : ''; ?>>Otro</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="nacionalidad" class="form-label">
                                                <i class="fas fa-flag"></i> Nacionalidad
                                            </label>
                                            <select name="nacionalidad" id="nacionalidad" class="form-control">
                                                <option value="">Seleccionar país...</option>
                                                
                                                <!-- Países Miembros del Mercosur -->
                                                <optgroup label="🏛️ Países Miembros del Mercosur">
                                                    <option value="Argentina" <?php echo (($atleta['nacionalidad'] ?? '') == 'Argentina') ? 'selected' : ''; ?>>🇦🇷 Argentina</option>
                                                    <option value="Brasil" <?php echo (($atleta['nacionalidad'] ?? '') == 'Brasil') ? 'selected' : ''; ?>>🇧🇷 Brasil</option>
                                                    <option value="Paraguay" <?php echo (($atleta['nacionalidad'] ?? '') == 'Paraguay') ? 'selected' : ''; ?>>🇵🇾 Paraguay</option>
                                                    <option value="Uruguay" <?php echo (($atleta['nacionalidad'] ?? '') == 'Uruguay') ? 'selected' : ''; ?>>🇺🇾 Uruguay</option>
                                                    <option value="Venezuela" <?php echo (($atleta['nacionalidad'] ?? '') == 'Venezuela') ? 'selected' : ''; ?>>🇻🇪 Venezuela</option>
                                                </optgroup>
                                                
                                                <!-- País en Proceso de Adhesión -->
                                                <optgroup label="⏳ En Proceso de Adhesión">
                                                    <option value="Bolivia" <?php echo (($atleta['nacionalidad'] ?? '') == 'Bolivia') ? 'selected' : ''; ?>>🇧🇴 Bolivia</option>
                                                </optgroup>
                                                
                                                <!-- Países Asociados -->
                                                <optgroup label="🤝 Países Asociados">
                                                    <option value="Chile" <?php echo (($atleta['nacionalidad'] ?? '') == 'Chile') ? 'selected' : ''; ?>>🇨🇱 Chile</option>
                                                    <option value="Colombia" <?php echo (($atleta['nacionalidad'] ?? '') == 'Colombia') ? 'selected' : ''; ?>>🇨🇴 Colombia</option>
                                                    <option value="Ecuador" <?php echo (($atleta['nacionalidad'] ?? '') == 'Ecuador') ? 'selected' : ''; ?>>🇪🇨 Ecuador</option>
                                                    <option value="Guyana" <?php echo (($atleta['nacionalidad'] ?? '') == 'Guyana') ? 'selected' : ''; ?>>🇬🇾 Guyana</option>
                                                    <option value="Perú" <?php echo (($atleta['nacionalidad'] ?? '') == 'Perú') ? 'selected' : ''; ?>>🇵🇪 Perú</option>
                                                    <option value="Suriname" <?php echo (($atleta['nacionalidad'] ?? '') == 'Suriname') ? 'selected' : ''; ?>>🇸🇷 Suriname</option>
                                                </optgroup>
                                                
                                                <!-- Otros Países -->
                                                <optgroup label="🌎 Otros Países">
                                                    <option value="México" <?php echo (($atleta['nacionalidad'] ?? '') == 'México') ? 'selected' : ''; ?>>🇲🇽 México</option>
                                                    <option value="Estados Unidos" <?php echo (($atleta['nacionalidad'] ?? '') == 'Estados Unidos') ? 'selected' : ''; ?>>🇺🇸 Estados Unidos</option>
                                                    <option value="Canadá" <?php echo (($atleta['nacionalidad'] ?? '') == 'Canadá') ? 'selected' : ''; ?>>🇨🇦 Canadá</option>
                                                    <option value="España" <?php echo (($atleta['nacionalidad'] ?? '') == 'España') ? 'selected' : ''; ?>>🇪🇸 España</option>
                                                    <option value="Italia" <?php echo (($atleta['nacionalidad'] ?? '') == 'Italia') ? 'selected' : ''; ?>>🇮🇹 Italia</option>
                                                    <option value="Francia" <?php echo (($atleta['nacionalidad'] ?? '') == 'Francia') ? 'selected' : ''; ?>>🇫🇷 Francia</option>
                                                    <option value="Alemania" <?php echo (($atleta['nacionalidad'] ?? '') == 'Alemania') ? 'selected' : ''; ?>>🇩🇪 Alemania</option>
                                                    <option value="Reino Unido" <?php echo (($atleta['nacionalidad'] ?? '') == 'Reino Unido') ? 'selected' : ''; ?>>🇬🇧 Reino Unido</option>
                                                    <option value="Portugal" <?php echo (($atleta['nacionalidad'] ?? '') == 'Portugal') ? 'selected' : ''; ?>>🇵🇹 Portugal</option>
                                                    <option value="Japón" <?php echo (($atleta['nacionalidad'] ?? '') == 'Japón') ? 'selected' : ''; ?>>🇯🇵 Japón</option>
                                                    <option value="China" <?php echo (($atleta['nacionalidad'] ?? '') == 'China') ? 'selected' : ''; ?>>🇨🇳 China</option>
                                                    <option value="Corea del Sur" <?php echo (($atleta['nacionalidad'] ?? '') == 'Corea del Sur') ? 'selected' : ''; ?>>🇰🇷 Corea del Sur</option>
                                                    <option value="Australia" <?php echo (($atleta['nacionalidad'] ?? '') == 'Australia') ? 'selected' : ''; ?>>🇦🇺 Australia</option>
                                                    <option value="Otro" <?php echo (($atleta['nacionalidad'] ?? '') == 'Otro') ? 'selected' : ''; ?>>🌍 Otro</option>
                                                </optgroup>
                                            </select>
                                            <small class="text-muted">
                                                Prioridad a países del Mercosur y asociados
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Física -->
                        <div class="form-section mb-4">
                            <div class="section-header">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="step-number me-3">2</div>
                                    <h5 class="mb-0">📏 Información Física</h5>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="altura" class="form-label">
                                                <i class="fas fa-ruler-vertical"></i> Altura (cm) *
                                            </label>
                                            <input type="number" name="altura" id="altura" class="form-control" 
                                                   required min="50" max="250" step="0.1" placeholder="Ej: 175.5"
                                                   value="<?php echo htmlspecialchars($atleta['altura'] ?? ''); ?>">
                                           
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="peso" class="form-label">
                                                <i class="fas fa-weight"></i> Peso (kg) *
                                            </label>
                                            <input type="number" name="peso" id="peso" class="form-control" 
                                                   required min="20" max="300" step="0.1" placeholder="Ej: 70.5"
                                                   value="<?php echo htmlspecialchars($atleta['peso'] ?? ''); ?>">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-calculator"></i> IMC Calculado
                                            </label>
                                            <div class="form-control bg-light" id="imc-display">
                                                Calculando...
                                            </div>
                                            <small class="text-muted">Se calcula automáticamente</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ubicación y Discapacidad -->
                        <div class="form-section mb-4">
                            <div class="section-header">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="step-number me-3">3</div>
                                    <h5 class="mb-0">📍 Ubicación y Condición</h5>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="lugar_id" class="form-label">
                                                <i class="fas fa-map-marker-alt"></i> Lugar
                                            </label>
                                            <select name="lugar_id" id="lugar_id" class="form-control">
                                                <option value="">Sin lugar específico</option>
                                                <?php 
                                                require_once __DIR__ . '/../../models/Lugar.php';
                                                $lugares = Lugar::todos();
                                                foreach ($lugares as $lugar): ?>
                                                    <option value="<?php echo $lugar['id']; ?>" 
                                                            <?php echo ($lugar['id'] == ($atleta['lugar_id'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($lugar['nombre']); ?>
                                                        <?php if ($lugar['zona']): ?>
                                                            - <?php echo htmlspecialchars($lugar['zona']); ?>
                                                        <?php endif; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="text-muted">Opcional: selecciona el lugar de entrenamiento principal</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="discapacidad_id" class="form-label">
                                                <i class="fas fa-wheelchair"></i> Discapacidad
                                            </label>
                                            <select name="discapacidad_id" id="discapacidad_id" class="form-control">
                                                <option value="">Sin discapacidad</option>
                                                <?php 
                                                require_once __DIR__ . '/../../models/Discapacidad.php';
                                                $discapacidades = Discapacidad::todos();
                                                foreach ($discapacidades as $discapacidad): ?>
                                                    <option value="<?php echo $discapacidad['id']; ?>" 
                                                            <?php echo ($discapacidad['id'] == ($atleta['discapacidad_id'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($discapacidad['nombre']); ?>
                                                        (<?php echo htmlspecialchars($discapacidad['tipo']); ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="evaluador_id" class="form-label">
                                                <i class="fas fa-user-md"></i> Evaluador Asignado
                                            </label>
                                            <select name="evaluador_id" id="evaluador_id" class="form-control">
                                                <option value="">Sin evaluador asignado</option>
                                                <?php 
                                                require_once __DIR__ . '/../../models/Evaluador.php';
                                                $evaluadores = Evaluador::todos();
                                                foreach ($evaluadores as $evaluador): ?>
                                                    <option value="<?php echo $evaluador['id']; ?>" 
                                                            <?php echo ($evaluador['id'] == ($atleta['evaluador_id'] ?? '')) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($evaluador['nombre'] . ' ' . $evaluador['apellido']); ?>
                                                        (<?php echo htmlspecialchars($evaluador['email']); ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lateralidad -->
                        <div class="form-section mb-4">
                            <div class="section-header">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <div class="step-number me-3">4</div>
                                    <h5 class="mb-0">👁️ Lateralidad</h5>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="lateralidad_visual" class="form-label">
                                                <i class="fas fa-eye"></i> Lateralidad Visual *
                                            </label>
                                            <select name="lateralidad_visual" id="lateralidad_visual" class="form-control" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="Derecho" <?php echo (($atleta['lateralidad_visual'] ?? '') == 'Derecho') ? 'selected' : ''; ?>>👁️ Derecha</option>
                                                <option value="Izquierdo" <?php echo (($atleta['lateralidad_visual'] ?? '') == 'Izquierdo') ? 'selected' : ''; ?>>👁️ Izquierda</option>
                                                <option value="Ambidiestro" <?php echo (($atleta['lateralidad_visual'] ?? '') == 'Ambidiestro') ? 'selected' : ''; ?>>👀 Ambos</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Selecciona la lateralidad visual
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-field">
                                    <div class="field-card">
                                        <div class="form-group">
                                            <label for="lateralidad_podal" class="form-label">
                                                <i class="fas fa-shoe-prints"></i> Lateralidad Podal *
                                            </label>
                                            <select name="lateralidad_podal" id="lateralidad_podal" class="form-control" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="Derecho" <?php echo (($atleta['lateralidad_podal'] ?? '') == 'Derecho') ? 'selected' : ''; ?>>🦶 Derecha</option>
                                                <option value="Izquierdo" <?php echo (($atleta['lateralidad_podal'] ?? '') == 'Izquierdo') ? 'selected' : ''; ?>>🦶 Izquierda</option>
                                                <option value="Ambidiestro" <?php echo (($atleta['lateralidad_podal'] ?? '') == 'Ambidiestro') ? 'selected' : ''; ?>>👣 Ambos</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Selecciona la lateralidad podal
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="form-section">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                                <button type="reset" class="btn btn-outline-warning btn-lg px-4" onclick="return confirm('¿Estás seguro de que quieres restablecer todos los campos?')">
                                    <i class="fas fa-undo me-2"></i> Restablecer
                                </button>
                                <button type="submit" class="btn btn-success btn-lg px-4" id="btnGuardar">
                                    <i class="fas fa-save me-2"></i> Actualizar Atleta
                                </button>
                            </div>
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
    font-weight: 600;
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

/* Form Controls */
.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 0.75rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    transform: none;
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

/* Botones */
.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
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
    
    .d-flex.justify-content-center > .btn {
        width: 100%;
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
    
    .step-number {
        width: 2.5rem;
        height: 2.5rem;
        font-size: 0.9rem;
    }
}

/* Select de nacionalidad con banderas */
select#nacionalidad {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif;
}

select#nacionalidad optgroup {
    font-weight: 600;
    font-size: 0.9rem;
    color: #495057;
    background-color: #f8f9fa;
    padding: 0.5rem;
}

select#nacionalidad option {
    padding: 0.5rem;
    font-size: 0.9rem;
}

select#nacionalidad option:hover {
    background-color: #e9ecef;
}

/* Efectos hover */
.form-section:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
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

    // Efectos hover mejorados para las cards
    fieldCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.1)';
        });
    });

    // Cálculo automático del IMC
    function calcularIMC() {
        console.log('🧮 Ejecutando calcularIMC...');
        
        const alturaInput = document.getElementById('altura');
        const pesoInput = document.getElementById('peso');
        const imcDisplay = document.getElementById('imc-display');
        
        if (!alturaInput || !pesoInput || !imcDisplay) {
            console.log('❌ No se encontraron los elementos para calcular IMC');
            console.log('Altura:', alturaInput);
            console.log('Peso:', pesoInput);
            console.log('Display:', imcDisplay);
            return;
        }
        
        const altura = parseFloat(alturaInput.value) || 0;
        const peso = parseFloat(pesoInput.value) || 0;
        
        console.log('📏 Valores:', { altura, peso });
        
        if (altura > 0 && peso > 0) {
            const alturaMetros = altura / 100;
            const imc = peso / (alturaMetros * alturaMetros);
            
            console.log('📊 IMC calculado:', imc);
            
            let categoria = '';
            let color = '';
            
            if (imc < 18.5) {
                categoria = 'Bajo peso';
                color = 'text-info';
            } else if (imc < 25) {
                categoria = 'Peso normal';
                color = 'text-success';
            } else if (imc < 30) {
                categoria = 'Sobrepeso';
                color = 'text-warning';
            } else {
                categoria = 'Obesidad';
                color = 'text-danger';
            }
            
            const resultado = `<span class="${color}"><strong>${imc.toFixed(1)}</strong> - ${categoria}</span>`;
            imcDisplay.innerHTML = resultado;
            console.log('✅ IMC actualizado:', resultado);
        } else {
            const mensaje = '<span class="text-muted">Ingresa altura y peso válidos</span>';
            imcDisplay.innerHTML = mensaje;
            console.log('⚠️ Valores insuficientes para calcular IMC');
        }
    }
    
    // Event listeners para el cálculo del IMC con verificación
    setTimeout(() => {
        const alturaInput = document.getElementById('altura');
        const pesoInput = document.getElementById('peso');
        const imcDisplay = document.getElementById('imc-display');
        
        console.log('Buscando elementos IMC...');
        console.log('alturaInput:', alturaInput);
        console.log('pesoInput:', pesoInput);
        console.log('imcDisplay:', imcDisplay);
        
        if (alturaInput && pesoInput && imcDisplay) {
            alturaInput.addEventListener('input', calcularIMC);
            pesoInput.addEventListener('input', calcularIMC);
            
            // Calcular IMC inicial
            calcularIMC();
            console.log('✅ IMC listeners configurados correctamente');
            
            // Agregar eventos adicionales para debugging
            alturaInput.addEventListener('input', () => {
                console.log('Altura cambió:', alturaInput.value);
            });
            pesoInput.addEventListener('input', () => {
                console.log('Peso cambió:', pesoInput.value);
            });
        } else {
            console.log('❌ Error: No se encontraron todos los elementos necesarios');
            console.log('Altura encontrado:', !!alturaInput);
            console.log('Peso encontrado:', !!pesoInput);
            console.log('IMC display encontrado:', !!imcDisplay);
        }
    }, 500);

    // Validación del formulario
    const form = document.getElementById('atletaForm');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                // Mostrar loading en el botón
                const btnGuardar = document.getElementById('btnGuardar');
                btnGuardar.classList.add('loading');
                btnGuardar.disabled = true;
                btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Guardando...';
            }
            form.classList.add('was-validated');
        });
    }

    // Contador de caracteres para campos de texto
    const inputs = document.querySelectorAll('input[type="text"], textarea');
    inputs.forEach(input => {
        const maxLength = input.getAttribute('maxlength');
        if (maxLength) {
            const counter = document.createElement('small');
            counter.className = 'text-muted';
            counter.style.float = 'right';
            input.parentNode.appendChild(counter);
            
            function updateCounter() {
                const remaining = maxLength - input.value.length;
                counter.textContent = `${input.value.length}/${maxLength}`;
                counter.style.color = remaining < 10 ? '#dc3545' : '#6c757d';
            }
            
            input.addEventListener('input', updateCounter);
            updateCounter();
        }
    });
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 