<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle"></i> Nueva Evaluación
                    </h4>
                    <small>Atleta: <?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></small>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fecha_evaluacion">
                                    <i class="fas fa-calendar"></i> Fecha de Evaluación *
                                </label>
                                <input type="date" 
                                       class="form-control" 
                                       id="fecha_evaluacion" 
                                       name="fecha_evaluacion" 
                                       value="<?php echo date('Y-m-d'); ?>" 
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hora_inicio">
                                    <i class="fas fa-clock"></i> Hora de Inicio
                                </label>
                                <input type="time" 
                                       class="form-control" 
                                       id="hora_inicio" 
                                       name="hora_inicio" 
                                       value="<?php echo date('H:i'); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lugar_id">
                                        <i class="fas fa-map-marker-alt"></i> Lugar de Evaluación
                                    </label>
                                    <select class="form-control" id="lugar_id" name="lugar_id">
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
                                        Por defecto se selecciona el lugar asociado al atleta, pero puedes cambiarlo si es necesario.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clima">
                                        <i class="fas fa-cloud-sun"></i> Condiciones Climáticas
                                    </label>
                                    <select class="form-control" id="clima" name="clima">
                                        <option value="">Seleccionar...</option>
                                        <option value="soleado">☀️ Soleado</option>
                                        <option value="nublado">☁️ Nublado</option>
                                        <option value="parcialmente_nublado">⛅ Parcialmente Nublado</option>
                                        <option value="lluvioso">🌧️ Lluvioso</option>
                                        <option value="ventoso">💨 Ventoso</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="temperatura_ambiente">
                                        <i class="fas fa-thermometer-half"></i> Temperatura Ambiente (°C)
                                    </label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="temperatura_ambiente" 
                                           name="temperatura_ambiente" 
                                           min="-10" 
                                           max="50" 
                                           step="0.1"
                                           placeholder="Ej: 22.5">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">
                                <i class="fas fa-sticky-note"></i> Observaciones Iniciales
                            </label>
                            <textarea class="form-control" 
                                      id="observaciones" 
                                      name="observaciones" 
                                      rows="3" 
                                      placeholder="Observaciones sobre el estado del atleta, condiciones especiales, etc."></textarea>
                        </div>

                        <!-- Sección de Tests Disponibles -->
                        <div class="form-group">
                            <label class="d-block mb-3">
                                <i class="fas fa-clipboard-list text-success"></i> Tests Disponibles
                                <small class="text-muted">Haz clic en un test para completarlo directamente</small>
                            </label>
                            
                            <?php if (isset($_GET['success']) && $_GET['success'] === 'test_completado'): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle"></i> Test completado exitosamente.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            
                            <div class="tests-container">
                                <?php if (!empty($tests)): ?>
                                    <!-- Debug: Mostrar información de tests -->
                                    <div style="background: #f0f0f0; padding: 10px; margin-bottom: 10px; font-size: 12px;">
                                        <strong>Debug - Tests disponibles:</strong><br>
                                        <?php 
                                        $total_tests = 0;
                                        foreach ($tests as $categoria => $testList): 
                                            echo "<strong>{$categoria}:</strong> ";
                                            foreach ($testList as $test): 
                                                echo "ID: {$test['id']} ({$test['nombre']}), ";
                                                $total_tests++;
                                            endforeach; 
                                            echo "<br>";
                                        endforeach; 
                                        echo "<br><strong>Total de tests: {$total_tests}</strong>";
                                        
                                        // Verificación específica para Talla Sentado
                                        $talla_sentado_encontrado = false;
                                        foreach ($tests as $categoria => $testList) {
                                            foreach ($testList as $test) {
                                                if ($test['id'] == 6) {
                                                    $talla_sentado_encontrado = true;
                                                    echo "<br><strong style='color: green;'>✓ Talla Sentado (ID: 6) encontrado en categoría: {$categoria}</strong>";
                                                    break 2;
                                                }
                                            }
                                        }
                                        if (!$talla_sentado_encontrado) {
                                            echo "<br><strong style='color: red;'>✗ Talla Sentado (ID: 6) NO encontrado en la lista</strong>";
                                        }
                                        ?>
                                    </div>
                                    
                                    <?php foreach ($tests as $categoria => $testList): ?>
                                        <div class="test-category mb-4">
                                            <h6 class="category-title">
                                                <i class="fas fa-folder-open text-muted mr-2"></i>
                                                <?php echo ucfirst($categoria); ?>
                                            </h6>
                                            <div class="test-list">
                                                <?php foreach ($testList as $test): ?>
                                                    <!-- Debug: Mostrar información de cada test -->
                                                    <div style="background: #f0f0f0; padding: 2px; margin: 2px; font-size: 10px; border: 1px solid #ccc;">
                                                        <strong>DEBUG TEST:</strong> ID=<?php echo $test['id']; ?>, Nombre=<?php echo $test['nombre']; ?>, Estado=<?php echo $test['estado']; ?>
                                                    </div>
                                                    <?php 
                                                    $estado_class = '';
                                                    $estado_icon = '';
                                                    $estado_text = '';
                                                    
                                                    switch ($test['estado']) {
                                                        case 'completado':
                                                            $estado_class = 'test-completed';
                                                            $estado_icon = 'check-circle';
                                                            $estado_text = 'Completado';
                                                            break;
                                                        case 'incompleto':
                                                            $estado_class = 'test-incomplete';
                                                            $estado_icon = 'exclamation-circle';
                                                            $estado_text = 'Incompleto';
                                                            break;
                                                        default:
                                                            $estado_class = 'test-not-done';
                                                            $estado_icon = 'times-circle';
                                                            $estado_text = 'Sin realizar';
                                                    }
                                                    ?>
                                                    <div class="test-item <?php echo $estado_class; ?>" id="test-<?php echo $test['id']; ?>">
                                                        <!-- Debug: Mostrar información del test -->
                                                        <?php if ($test['id'] == 6): ?>
                                                            <div style="background: #ffe6e6; padding: 5px; margin: 5px; font-size: 10px; border: 1px solid red;">
                                                                <strong>DEBUG TALLA SENTADO:</strong> ID=<?php echo $test['id']; ?>, Nombre=<?php echo $test['nombre']; ?>, Estado=<?php echo $test['estado']; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="test-content">
                                                            <div class="test-icon">
                                                                <i class="fas fa-<?php echo $test['icono']; ?>"></i>
                                                            </div>
                                                            <div class="test-details">
                                                                <div class="test-name"><?php echo $test['nombre']; ?></div>
                                                                <div class="test-desc"><?php echo $test['descripcion']; ?></div>
                                                            </div>
                                                            <div class="test-status">
                                                                <span class="status-badge">
                                                                    <i class="fas fa-<?php echo $estado_icon; ?>"></i>
                                                                    <?php echo $estado_text; ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Formulario integrado del test -->
                                                        <div class="test-form-integrated" id="form-<?php echo $test['id']; ?>">
                                                            <div class="test-form-content">
                                                                <form class="test-form needs-validation" novalidate>
                                                                    <input type="hidden" name="test_id" value="<?php echo $test['id']; ?>">
                                                                    <input type="hidden" name="evaluacion_id" value="<?php echo $evaluacion_id; ?>">
                                                                    <input type="hidden" name="atleta_id" value="<?php echo $atleta_id; ?>">
                                                                    
                                                                    <div class="form-row" id="fields-<?php echo $test['id']; ?>">
                                                                        <!-- Los campos se generarán dinámicamente -->
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> No hay tests disponibles en este momento.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="button" class="btn btn-success btn-lg" onclick="guardarTodosLosTests()">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-primary btn-lg ml-2" onclick="finalizarTest()">
                                <i class="fas fa-check-circle"></i> Finalizar Test
                            </button>
                            <a href="index.php?controller=Atleta&action=listado" class="btn btn-secondary btn-lg ml-2">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
.card-header {
    border-bottom: 3px solid #28a745;
}

.form-group label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

/* Estilos unificados para todos los inputs */
.form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 0.375rem 0.75rem;
    font-size: 0.85rem;
    width: 100%;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    outline: 0;
}

/* Estilos para inputs de tipo number */
input[type="number"] {
    -moz-appearance: textfield;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Estilos para inputs de tipo date y time */
input[type="date"],
input[type="time"] {
    font-family: inherit;
    font-size: 0.85rem;
}

/* Estilos para select */
select.form-control {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    padding-right: 2.5rem;
}

/* Estilos para la lista de tests */
.tests-container {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    overflow: hidden;
}

.test-category {
    padding: 0 1rem;
}

.test-category:not(:last-child) {
    border-bottom: 1px solid #f0f0f0;
}

.category-title {
    color: #495057;
    font-weight: 600;
    padding: 1rem 0 0.5rem;
    margin: 0;
    display: flex;
    align-items: center;
}

.test-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding-bottom: 1rem;
}

.test-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    border-radius: 6px;
    background: #f8f9fa;
    text-decoration: none;
    color: #333;
    border: 1px solid transparent;
}

.test-item:hover {
    background: #fff;
    border-color: #28a745;
    text-decoration: none;
    color: #333;
}

.test-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e9f5ee;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: #28a745;
    flex-shrink: 0;
}

.test-details {
    flex-grow: 1;
}

.test-name {
    font-weight: 500;
    margin-bottom: 2px;
}

.test-desc {
    font-size: 0.8rem;
    color: #6c757d;
}

.test-arrow {
    color: #adb5bd;
    padding-left: 0.5rem;
}



/* Estados de los tests */
.test-completed {
    border-color: #28a745 !important;
    background: #f8fff9 !important;
}

.test-completed .test-icon {
    background: #d4edda !important;
    color: #28a745 !important;
}

.test-completed .status-badge {
    background: #28a745 !important;
    color: white !important;
}

.test-incomplete {
    border-color: #fd7e14 !important;
    background: #fff8f3 !important;
}

.test-incomplete .test-icon {
    background: #ffeaa7 !important;
    color: #fd7e14 !important;
}

.test-incomplete .status-badge {
    background: #fd7e14 !important;
    color: white !important;
}

.test-not-done {
    border-color: #dc3545 !important;
    background: #fff5f5 !important;
}

.test-not-done .test-icon {
    background: #f8d7da !important;
    color: #dc3545 !important;
}

.test-not-done .status-badge {
    background: #dc3545 !important;
    color: white !important;
}

.test-status {
    margin-right: 1rem;
}

.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.test-item:hover.test-completed {
    border-color: #218838 !important;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2) !important;
}

.test-item:hover.test-incomplete {
    border-color: #e55a00 !important;
    box-shadow: 0 2px 8px rgba(253, 126, 20, 0.2) !important;
}

.test-item:hover.test-not-done {
    border-color: #c82333 !important;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2) !important;
}

/* Estilos para formularios integrados */
.test-content {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 1rem;
}

.test-details {
    flex-grow: 1;
    margin-left: 1rem;
    text-align: left;
}

.test-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #333;
    font-size: 1rem;
}

.test-desc {
    font-size: 0.85rem;
    color: #666;
    line-height: 1.3;
}

.test-status {
    margin-left: auto;
    margin-right: 1rem;
}

.test-form-integrated {
    padding: 1rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    border-radius: 0 0 8px 8px;
}

.test-form-content {
    background: white;
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

.test-form .form-group {
    margin-bottom: 0.75rem;
}

.test-form .form-group label {
    font-weight: 600;
    color: #495057;
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
    display: block;
}

.test-form .form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 0.375rem 0.75rem;
    font-size: 0.85rem;
    width: 100%;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.test-form .form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    outline: 0;
}

/* Ocultar mensajes de validación por defecto */
.test-form .invalid-feedback {
    display: none;
}

/* Mostrar mensajes de validación solo cuando el formulario está validado y el campo está vacío */
.test-form.was-validated .form-control:invalid ~ .invalid-feedback {
    display: block;
}

.test-form.was-validated .form-control:invalid {
    border-color: #dc3545;
}

.test-form.was-validated .form-control:valid {
    border-color: #28a745;
}

/* Ocultar mensajes de validación cuando el campo tiene datos válidos */
.test-form .form-control.is-valid ~ .invalid-feedback {
    display: none !important;
}

.test-form .form-control.is-valid {
    border-color: #28a745;
}

.test-form .form-control.is-invalid {
    border-color: #dc3545;
}

.form-actions {
    margin-top: 0.75rem;
    text-align: right;
}

.form-actions .btn {
    font-size: 0.8rem;
    padding: 0.25rem 0.75rem;
}

/* Ajustes para el layout de los tests */
.test-item {
    cursor: default;
    padding: 0;
    overflow: hidden;
}

.test-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9f5ee;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #28a745;
    flex-shrink: 0;
    margin-left: 0.5rem;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    padding: 12px 30px;
    font-size: 1.1rem;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.btn-secondary {
    padding: 12px 30px;
    font-size: 1.1rem;
}
</style>

<script>
// Configuración de tests
const testsConfig = {
    6: { // Talla Sentado
        nombre: 'Talla Sentado',
        descripcion: 'Mide la altura del tronco en posición sentada',
        icono: 'ruler-vertical',
        campos: [
            { name: 'talla_sentado_cm', label: 'Talla Sentado (cm)', type: 'number', step: '0.1', required: true }
        ]
    },
    7: { // Envergadura
        nombre: 'Envergadura',
        descripcion: 'Mide la distancia entre las puntas de los dedos con brazos extendidos',
        icono: 'arrows-alt-h',
        campos: [
            { name: 'envergadura', label: 'Envergadura (cm)', type: 'number', step: '0.1', required: true }
        ]
    },
    8: { // Fuerza en Prensa
        nombre: 'Fuerza en Prensa',
        descripcion: 'Evalúa la fuerza máxima en piernas',
        icono: 'dumbbell',
        campos: [
            { name: 'peso_maximo', label: 'Peso Máximo (kg)', type: 'number', step: '0.5', required: true },
            { name: 'repeticiones', label: 'Repeticiones', type: 'number', required: true }
        ]
    },
    9: { // Salto Vertical
        nombre: 'Salto Vertical',
        descripcion: 'Mide la potencia de salto vertical',
        icono: 'arrow-up',
        campos: [
            { name: 'altura_salto', label: 'Altura del Salto (cm)', type: 'number', step: '0.1', required: true }
        ]
    },
    10: { // Test de Cooper
        nombre: 'Test de Cooper',
        descripcion: 'Evalúa la resistencia aeróbica',
        icono: 'running',
        campos: [
            { name: 'distancia', label: 'Distancia Recorrida (m)', type: 'number', required: true },
            { name: 'tiempo', label: 'Tiempo (minutos)', type: 'number', step: '0.1', required: true }
        ]
    },
    11: { // Course Navette
        nombre: 'Course Navette',
        descripcion: 'Test de resistencia progresiva',
        icono: 'exchange-alt',
        campos: [
            { name: 'nivel_alcanzado', label: 'Nivel Alcanzado', type: 'number', required: true },
            { name: 'palier', label: 'Palier', type: 'number', required: true },
            { name: 'vma', label: 'VMA (km/h)', type: 'number', step: '0.1', required: true }
        ]
    },
    12: { // Sit and Reach
        nombre: 'Sit and Reach',
        descripcion: 'Evalúa la flexibilidad de la cadena posterior',
        icono: 'hands-helping',
        campos: [
            { name: 'distancia', label: 'Distancia Alcanzada (cm)', type: 'number', step: '0.1', required: true }
        ]
    },
    13: { // Velocidad 30m
        nombre: 'Velocidad 30m',
        descripcion: 'Mide la velocidad en 30 metros',
        icono: 'tachometer-alt',
        campos: [
            { name: 'tiempo', label: 'Tiempo (segundos)', type: 'number', step: '0.01', required: true }
        ]
    }
};

// Función para generar formularios automáticamente
function generarFormulariosTests() {
    console.log('=== GENERANDO FORMULARIOS ===');
    console.log('testsConfig keys:', Object.keys(testsConfig));
    
    Object.keys(testsConfig).forEach(testId => {
        const config = testsConfig[testId];
        const fieldsContainer = document.getElementById(`fields-${testId}`);
        
        console.log(`Test ID ${testId}:`, {
            config: config,
            fieldsContainer: fieldsContainer,
            containerExists: !!fieldsContainer
        });
        
        if (fieldsContainer && config) {
            fieldsContainer.innerHTML = '';

            config.campos.forEach(campo => {
                const fieldHtml = `
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="${campo.name}-${testId}">
                                <i class="fas fa-ruler"></i> ${campo.label}
                            </label>
                            <input type="${campo.type}" 
                                   class="form-control" 
                                   id="${campo.name}-${testId}" 
                                   name="resultados[${campo.name}]" 
                                   ${campo.step ? `step="${campo.step}"` : ''}
                                   ${campo.required ? 'required' : ''}
                                   onchange="actualizarEstadoTest(${testId})"
                                   oninput="actualizarEstadoTest(${testId})">
                            <div class="invalid-feedback">
                                Por favor ingresa un valor válido.
                            </div>
                        </div>
                    </div>
                `;
                fieldsContainer.innerHTML += fieldHtml;
                
                console.log(`Campo generado para test ${testId}:`, campo.name);
            });
            
            // Verificar inmediatamente después de generar
            setTimeout(() => {
                const testElement = document.querySelector(`#test-${testId}`);
                const formElement = document.querySelector(`#form-${testId}`);
                const inputElement = document.querySelector(`#${config.campos[0].name}-${testId}`);
                
                console.log(`Verificación post-generación para test ${testId}:`, {
                    testElement: !!testElement,
                    formElement: !!formElement,
                    inputElement: !!inputElement
                });
            }, 50);
        } else {
            console.error(`No se pudo generar formulario para test ${testId}:`, {
                fieldsContainer: fieldsContainer,
                config: config
            });
        }
    });
}

// Función para guardar todos los tests
function guardarTodosLosTests() {
    console.log('Guardando todos los tests...');
    
    // Obtener todos los formularios de tests
    const forms = document.querySelectorAll('.test-form');
    let formsConDatos = 0;
    let formsGuardados = 0;
    
    // Contar formularios que tienen datos (no necesariamente completos)
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[type="number"], input[type="text"]');
        let tieneDatos = false;
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                tieneDatos = true;
            }
        });
        if (tieneDatos) {
            formsConDatos++;
        }
    });
    
    if (formsConDatos === 0) {
        mostrarMensaje('No hay datos para guardar. Completa al menos un campo en cualquier test.', 'info');
        return;
    }
    
    // Mostrar indicador de carga en el botón principal
    const saveButton = document.querySelector('button[onclick="guardarTodosLosTests()"]');
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    saveButton.disabled = true;
    
    // Guardar solo formularios que tengan datos
    const promises = Array.from(forms).map(form => {
        const inputs = form.querySelectorAll('input[type="number"], input[type="text"]');
        let tieneDatos = false;
        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                tieneDatos = true;
            }
        });
        
        if (!tieneDatos) {
            return Promise.resolve({ success: true, skipped: true });
        }
        
        const formData = new FormData(form);
        formData.append('action', 'guardarTest');
        formData.append('fecha_test', new Date().toISOString().slice(0, 19).replace('T', ' '));
        
        return fetch('index.php?controller=Evaluacion&action=guardarTestAjax', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                formsGuardados++;
                return { success: true };
            } else {
                return { success: false, error: data.error };
            }
        })
        .catch(error => {
            console.error('Error:', error);
            return { success: false, error: 'Error de conexión' };
        });
    });
    
    // Esperar a que todos los guardados se completen
    Promise.all(promises)
        .then(results => {
            const errores = results.filter(r => !r.success);
            
            if (errores.length === 0) {
                mostrarMensaje(`Progreso guardado exitosamente. Puedes continuar completando los tests.`, 'success');
                // No recargar la página para permitir continuar trabajando
            } else {
                mostrarMensaje(`Se guardó el progreso, pero hubo ${errores.length} errores`, 'warning');
            }
        })
        .finally(() => {
            // Restaurar botón
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        });
}

// Función para finalizar el test
function finalizarTest() {
    console.log('Finalizando test...');
    
    // Validar que todos los tests estén completos
    const forms = document.querySelectorAll('.test-form');
    let testsCompletados = 0;
    let testsTotales = forms.length;
    let hayErrores = false;
    
    // Validar todos los formularios
    forms.forEach(form => {
        form.classList.remove('was-validated');
        if (form.checkValidity()) {
            testsCompletados++;
        } else {
            form.classList.add('was-validated');
            hayErrores = true;
        }
    });
    
    if (hayErrores) {
        mostrarMensaje('Por favor completa todos los campos requeridos antes de finalizar la evaluación', 'warning');
        return;
    }
    
    if (testsCompletados < testsTotales) {
        const confirmacion = confirm(`Tienes ${testsTotales - testsCompletados} tests sin completar. ¿Estás seguro de que quieres finalizar?`);
        if (!confirmacion) {
            return;
        }
    }
    
    // Guardar primero todos los tests completados
    guardarTodosLosTests();
    
    // Luego finalizar la evaluación
    setTimeout(() => {
        const formData = new FormData();
        formData.append('action', 'finalizarEvaluacion');
        formData.append('evaluacion_id', '<?php echo $evaluacion_id; ?>');
        
        fetch('index.php?controller=Evaluacion&action=finalizarEvaluacionAjax', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarMensaje('Evaluación finalizada exitosamente', 'success');
                setTimeout(() => {
                    window.location.href = 'index.php?controller=Evaluacion&action=listado';
                }, 1500);
            } else {
                mostrarMensaje('Error al finalizar la evaluación: ' + data.error, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error de conexión al finalizar la evaluación', 'danger');
        });
    }, 2000);
}

// Función para actualizar el estado visual del test
function actualizarEstadoTest(testId) {
    console.log(`Actualizando estado para test ID: ${testId}`);
    
    const testItem = document.querySelector(`#test-${testId}`);
    const formContainer = document.querySelector(`#form-${testId}`);
    
    console.log(`testItem encontrado:`, testItem);
    console.log(`formContainer encontrado:`, formContainer);
    
    if (!testItem || !formContainer) {
        console.error('Elementos no encontrados para test ID:', testId);
        console.error('Buscando elementos con IDs:', `#test-${testId}`, `#form-${testId}`);
        
        // Verificar si existen elementos con IDs similares
        const allTestElements = document.querySelectorAll('[id^="test-"]');
        const allFormElements = document.querySelectorAll('[id^="form-"]');
        console.log('Todos los elementos test encontrados:', allTestElements);
        console.log('Todos los elementos form encontrados:', allFormElements);
        
        // Si el elemento no existe, no hacer nada más
        return;
    }
    
    // Obtener todos los inputs del test
    const inputs = formContainer.querySelectorAll('input[type="number"], input[type="text"]');
    let tieneDatos = false;
    let todosLosCamposLlenos = true;
    
    // Verificar si algún input tiene datos y si todos los campos requeridos están llenos
    inputs.forEach(input => {
        if (input.value.trim() !== '') {
            tieneDatos = true;
        } else if (input.hasAttribute('required')) {
            todosLosCamposLlenos = false;
        }
    });
    
    // Obtener elementos del estado (están en el testItem, no en formContainer)
    const statusBadge = testItem.querySelector('.status-badge');
    const testIcon = testItem.querySelector('.test-icon');
    const form = formContainer.querySelector('.test-form');
    
    console.log(`statusBadge encontrado:`, statusBadge);
    console.log(`testIcon encontrado:`, testIcon);
    console.log(`form encontrado:`, form);
    
    // Debug específico para el formContainer
    console.log(`formContainer HTML:`, formContainer.innerHTML);
    console.log(`formContainer children:`, formContainer.children);
    console.log(`formContainer outerHTML:`, formContainer.outerHTML);
    
    // Verificar que todos los elementos necesarios existan
    if (!statusBadge || !testIcon || !form) {
        console.error('Elementos de estado no encontrados para test ID:', testId);
        console.error('statusBadge:', statusBadge);
        console.error('testIcon:', testIcon);
        console.error('form:', form);
        
        // Debug adicional para el formulario
        const allForms = formContainer.querySelectorAll('form');
        console.log('Todos los formularios en formContainer:', allForms);
        console.log('Formularios con clase test-form:', formContainer.querySelectorAll('.test-form'));
        
        return;
    }
    
    // Limpiar mensajes de validación si hay datos
    if (tieneDatos) {
        form.classList.remove('was-validated');
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        });
    }
    
    if (tieneDatos) {
        // Cambiar a estado "Realizado"
        testItem.classList.remove('test-not-done', 'test-incomplete');
        testItem.classList.add('test-completed');
        
        if (statusBadge) {
            statusBadge.innerHTML = '<i class="fas fa-check-circle"></i> Realizado';
            statusBadge.className = 'badge badge-success status-badge';
        }
        
        if (testIcon) {
            testIcon.className = 'test-icon';
            testIcon.innerHTML = '<i class="fas fa-check"></i>';
        }
    } else {
        // Mantener estado "Sin Realizar"
        testItem.classList.remove('test-completed', 'test-incomplete');
        testItem.classList.add('test-not-done');
        
        if (statusBadge) {
            statusBadge.innerHTML = '<i class="fas fa-times-circle"></i> Sin Realizar';
            statusBadge.className = 'badge badge-danger status-badge';
        }
        
        if (testIcon) {
            testIcon.className = 'test-icon';
            // Restaurar el icono original según el test
            const config = testsConfig[testId];
            if (config) {
                testIcon.innerHTML = `<i class="fas fa-${config.icono || 'ruler'}"></i>`;
            }
        }
    }
}

// Función para mostrar mensajes
function mostrarMensaje(mensaje, tipo) {
    const alertHtml = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i> ${mensaje}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    
    // Insertar al inicio del contenedor de tests
    const testsContainer = document.querySelector('.tests-container');
    testsContainer.insertAdjacentHTML('beforebegin', alertHtml);
}

// Inicialización cuando se carga la página
(function() {
    'use strict';
    
    // Función para inicializar todo
    function inicializarSistema() {
        console.log('=== INICIALIZANDO SISTEMA ===');
        
        // Verificar que el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', inicializarSistema);
            return;
        }
        
        // Generar formularios automáticamente
        console.log('Generando formularios...');
        generarFormulariosTests();
        
        // Esperar un poco más para asegurar que todo esté renderizado
        setTimeout(() => {
            console.log('Inicializando estados de tests...');
            Object.keys(testsConfig).forEach(testId => {
                console.log(`Inicializando test ID: ${testId}`);
                actualizarEstadoTest(testId);
            });
            
            // Limpiar todos los mensajes de validación al cargar
            const forms = document.querySelectorAll('.test-form');
            forms.forEach(form => {
                form.classList.remove('was-validated');
                const inputs = form.querySelectorAll('input');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                    if (input.value.trim() !== '') {
                        input.classList.add('is-valid');
                    }
                });
            });
            
            // Verificación específica para Talla Sentado
            setTimeout(() => {
                const tallaSentadoTest = document.querySelector('#test-6');
                const tallaSentadoForm = document.querySelector('#form-6');
                const tallaSentadoInput = document.querySelector('#talla_sentado_cm-6');
                
                console.log('=== VERIFICACIÓN TALLA SENTADO ===');
                console.log('Test element:', tallaSentadoTest);
                console.log('Form element:', tallaSentadoForm);
                console.log('Input element:', tallaSentadoInput);
                
                if (tallaSentadoInput) {
                    console.log('Input value:', tallaSentadoInput.value);
                    console.log('Input name:', tallaSentadoInput.name);
                    console.log('Input id:', tallaSentadoInput.id);
                }
            }, 200);
        }, 300);
    }
    
    // Inicializar cuando la página esté completamente cargada
    window.addEventListener('load', inicializarSistema);
    
    // Prevenir envío automático de formularios
    var forms = document.getElementsByClassName('test-form');
    Array.prototype.forEach.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            event.stopPropagation();
        }, false);
    });
})();
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 