<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h2>📋 Evaluación de <?php echo htmlspecialchars($evaluacion['apellido'] . ', ' . $evaluacion['nombre']); ?></h2>
      <p class="text-muted">
        📅 <?php echo date('d/m/Y', strtotime($evaluacion['fecha_evaluacion'])); ?>
        <?php if ($evaluacion['lugar_nombre']): ?>
          | 📍 <?php echo htmlspecialchars($evaluacion['lugar_nombre']); ?>
        <?php endif; ?>
      </p>
    </div>
    <div>
      <a href="index.php?controller=Test&action=resultados" class="btn-volver">
        <i class="fas fa-arrow-left"></i> Volver
      </a>
    </div>
  </div>

  <!-- Información de la Evaluación -->
  <div class="card mb-4">
    <div class="card-header" style="background: linear-gradient(135deg, var(--color-azul) 0%, #0056b3 100%); color: white;">
      <h5 class="mb-0">ℹ️ Información de la Evaluación</h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
          <strong>Estado:</strong><br>
          <span class="badge <?php 
            echo $evaluacion['estado'] === 'completada' ? 'badge-success' : 
                 ($evaluacion['estado'] === 'en_progreso' ? 'badge-warning' : 'badge-info'); 
          ?>">
            <?php echo strtoupper($evaluacion['estado']); ?>
          </span>
        </div>
        
        <?php if ($evaluacion['hora_inicio']): ?>
        <div class="col-md-3">
          <strong>⏰ Hora Inicio:</strong><br>
          <?php echo $evaluacion['hora_inicio']; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($evaluacion['hora_fin']): ?>
        <div class="col-md-3">
          <strong>⏰ Hora Fin:</strong><br>
          <?php echo $evaluacion['hora_fin']; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($evaluacion['clima']): ?>
        <div class="col-md-3">
          <strong>🌤️ Clima:</strong><br>
          <?php echo htmlspecialchars($evaluacion['clima']); ?>
          <?php if ($evaluacion['temperatura_ambiente']): ?>
            (<?php echo $evaluacion['temperatura_ambiente']; ?>°C)
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
      
      <?php if ($evaluacion['observaciones']): ?>
      <div class="row mt-3">
        <div class="col-12">
          <strong>📝 Observaciones:</strong><br>
          <p><?php echo nl2br(htmlspecialchars($evaluacion['observaciones'])); ?></p>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Tests Realizados -->
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center" 
         style="background: linear-gradient(135deg, var(--color-verde) 0%, #1b5e20 100%); color: white;">
      <h5 class="mb-0">🏃 Tests Realizados (<?php echo count($resultados); ?>)</h5>
      <?php if ($evaluacion['estado'] !== 'completada'): ?>
        <button class="btn btn-light btn-sm" onclick="document.getElementById('agregarTestForm').style.display='block'">
          ➕ Agregar Test
        </button>
      <?php endif; ?>
    </div>
    <div class="card-body">
      <?php if (empty($resultados)): ?>
        <div class="alert alert-info text-center">
          <h6>📝 No se han registrado tests aún</h6>
          <p>Comienza agregando el primer test a esta evaluación.</p>
        </div>
      <?php else: ?>
        <div class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th>Test</th>
                <th>Fecha</th>
                <th>Resultado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($resultados as $resultado): ?>
              <?php 
              $resultadoData = json_decode($resultado['resultado_json'], true);
              $formatoTest = json_decode($resultado['formato_test'], true);
              ?>
              <tr>
                <td>
                  <strong><?php echo htmlspecialchars($resultado['nombre_test']); ?></strong>
                </td>
                <td>
                  <?php echo date('d/m/Y H:i', strtotime($resultado['fecha_test'])); ?>
                </td>
                <td>
                  <div style="max-width: 350px;">
                    <?php if ($resultadoData && is_array($resultadoData)): ?>
                      <div class="d-flex flex-wrap gap-1">
                        <?php foreach ($resultadoData as $key => $value): ?>
                          <?php if ($value !== null && $value !== ''): ?>
                            <div class="mb-1" style="margin-right: 8px;">
                              <small class="text-muted"><?php echo ucfirst(str_replace('_', ' ', $key)); ?>:</small><br>
                              <span class="badge badge-light" style="font-size: 0.85em;">
                                <?php 
                                if (is_numeric($value)) {
                                  // Buscar unidad en el formato del test
                                  $unidad = '';
                                  if ($formatoTest && isset($formatoTest['campos'])) {
                                    foreach ($formatoTest['campos'] as $campo) {
                                      if ($campo['nombre'] === $key && isset($campo['unidad'])) {
                                        $unidad = ' ' . $campo['unidad'];
                                        break;
                                      }
                                    }
                                  }
                                  echo $value . $unidad;
                                } else {
                                  echo htmlspecialchars($value);
                                }
                                ?>
                              </span>
                            </div>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </div>
                    <?php else: ?>
                      <span class="badge badge-light"><?php echo htmlspecialchars($resultado['resultado_json']); ?></span>
                    <?php endif; ?>
                  </div>
                </td>
                <td>
                  <button class="btn btn-info btn-sm" onclick="verResultado(<?php echo htmlspecialchars(json_encode($resultado)); ?>)">
                    👁️ Ver
                  </button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Formulario para Agregar Test -->
  <?php if ($evaluacion['estado'] !== 'completada'): ?>
  <div id="agregarTestForm" class="card" style="display: none;">
    <div class="card-header" style="background: var(--color-naranja); color: white;">
      <h5 class="mb-0">➕ Agregar Nuevo Test</h5>
    </div>
    <div class="card-body">
      <form method="POST" action="index.php?controller=Test&action=agregarTest">
        <input type="hidden" name="evaluacion_id" value="<?php echo $evaluacion['id']; ?>">
        <input type="hidden" name="atleta_id" value="<?php echo $evaluacion['atleta_id']; ?>">
        <input type="hidden" name="lugar_id" value="<?php echo $evaluacion['lugar_id']; ?>">
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="test_id" class="form-label">🏃 Test *</label>
              <select name="test_id" id="test_id" class="form-control" required onchange="cargarFormatoTest()">
                <option value="">Seleccionar test...</option>
                <?php foreach ($tests_disponibles as $test): ?>
                  <option value="<?php echo $test['id']; ?>" 
                          data-formato='<?php echo htmlspecialchars($test['formato_test']); ?>'
                          data-nombre='<?php echo htmlspecialchars($test['nombre_test']); ?>'>
                    <?php echo htmlspecialchars($test['nombre_test']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="fecha_test" class="form-label">📅 Fecha del Test *</label>
              <input type="datetime-local" name="fecha_test" id="fecha_test" 
                     class="form-control" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
            </div>
          </div>
        </div>

        <div id="campos_resultado">
          <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Selecciona un test</strong> para ver los campos de resultado específicos
          </div>
        </div>

        <div class="d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" onclick="document.getElementById('agregarTestForm').style.display='none'">
            ❌ Cancelar
          </button>
          <button type="submit" class="btn btn-success">
            ✅ Guardar Test
          </button>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>
</div>

<!-- Modal para ver resultado detallado -->
<div id="modalResultado" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
  <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; max-width: 600px; width: 90%;">
    <h5 id="modalTitulo"></h5>
    <div id="modalContenido"></div>
    <button onclick="document.getElementById('modalResultado').style.display='none'" class="btn btn-secondary mt-3">Cerrar</button>
  </div>
</div>

<script>
function cargarFormatoTest() {
  const select = document.getElementById('test_id');
  const contenedor = document.getElementById('campos_resultado');
  
  if (!select.value) {
    contenedor.innerHTML = `
      <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <strong>Selecciona un test</strong> para ver los campos de resultado específicos
      </div>`;
    return;
  }
  
  const formatoJson = select.options[select.selectedIndex].dataset.formato || '{}';
  const nombreTest = select.options[select.selectedIndex].dataset.nombre || '';
  
  let formato;
  try {
    formato = JSON.parse(formatoJson);
  } catch (e) {
    console.error('Error parsing formato JSON:', e);
    formato = {};
  }
  
  let html = `
    <div class="card" style="border: 2px solid var(--color-verde); background: #f8fff8;">
      <div class="card-header" style="background: var(--color-verde); color: white;">
        <h6 class="mb-0">📝 Resultado del Test: ${nombreTest}</h6>
      </div>
      <div class="card-body">`;
  
  if (formato.instrucciones && Array.isArray(formato.instrucciones)) {
    html += `
      <div class="alert alert-light mb-3">
        <strong>📋 Instrucciones:</strong>
        <ol class="mb-0 mt-2">`;
    formato.instrucciones.forEach(instruccion => {
      html += `<li>${instruccion}</li>`;
    });
    html += `</ol></div>`;
  }
  
  if (formato.campos && Array.isArray(formato.campos)) {
    html += '<div class="row">';
    
    formato.campos.forEach((campo, index) => {
      // Saltar campos de observaciones ya que no queremos mostrarlos
      if (campo.nombre === 'observaciones') {
        return;
      }
      
      const colClass = formato.campos.length <= 2 ? 'col-md-6' : 
                      formato.campos.length <= 4 ? 'col-md-6 col-lg-3' : 'col-md-4';
      
      html += `<div class="${colClass}">
        <div class="form-group">
          <label for="resultado_${campo.nombre}" class="form-label">
            <strong>${campo.nombre}</strong>
            ${campo.requerido ? '<span class="text-danger">*</span>' : ''}
          </label>`;
      
      if (campo.tipo === 'numerico' || campo.tipo === 'decimal' || campo.tipo === 'entero') {
        html += `
          <div class="input-group">
            <input type="number" 
                   name="resultado[${campo.nombre}]" 
                   id="resultado_${campo.nombre}" 
                   class="form-control" 
                   step="${campo.tipo === 'entero' ? '1' : '0.01'}" 
                   ${campo.requerido ? 'required' : ''} 
                   placeholder="${campo.descripcion || 'Ingresa el valor'}"
                   style="border-color: var(--color-azul);">
            ${campo.unidad ? `<div class="input-group-append">
              <span class="input-group-text" style="background: var(--color-azul); color: white;">${campo.unidad}</span>
            </div>` : ''}
          </div>`;
      } else if (campo.tipo === 'texto') {
        html += `
          <input type="text" 
                 name="resultado[${campo.nombre}]" 
                 id="resultado_${campo.nombre}" 
                 class="form-control" 
                 ${campo.requerido ? 'required' : ''} 
                 placeholder="${campo.descripcion || 'Ingresa texto'}"
                 style="border-color: var(--color-azul);">`;
      } else if (campo.tipo === 'seleccion' && campo.opciones && Array.isArray(campo.opciones)) {
        html += `
          <select name="resultado[${campo.nombre}]" 
                  id="resultado_${campo.nombre}" 
                  class="form-control" 
                  ${campo.requerido ? 'required' : ''}
                  style="border-color: var(--color-azul);">
            <option value="">Seleccionar...</option>`;
        campo.opciones.forEach(opcion => {
          html += `<option value="${opcion}">${opcion}</option>`;
        });
        html += '</select>';
      } else if (campo.tipo === 'textarea') {
        html += `
          <textarea name="resultado[${campo.nombre}]" 
                    id="resultado_${campo.nombre}" 
                    class="form-control" 
                    rows="2"
                    ${campo.requerido ? 'required' : ''} 
                    placeholder="${campo.descripcion || 'Ingresa observaciones'}"
                    style="border-color: var(--color-azul);"></textarea>`;
      } else {
        // Campo genérico
        html += `
          <input type="text" 
                 name="resultado[${campo.nombre}]" 
                 id="resultado_${campo.nombre}" 
                 class="form-control" 
                 ${campo.requerido ? 'required' : ''} 
                 placeholder="${campo.descripcion || campo.nombre}"
                 style="border-color: var(--color-azul);">`;
      }
      
      if (campo.descripcion && campo.tipo !== 'numerico' && campo.tipo !== 'decimal' && campo.tipo !== 'entero') {
        html += `<small class="text-muted">${campo.descripcion}</small>`;
      }
      
      html += '</div></div>';
    });
    
    html += '</div>';
  } else {
    // Fallback para tests sin formato específico
    html += `
      <div class="form-group">
        <label for="resultado_valor" class="form-label">
          <strong>Resultado del Test</strong> <span class="text-danger">*</span>
        </label>
        <textarea name="resultado[valor]" 
                  id="resultado_valor" 
                  class="form-control" 
                  rows="3" 
                  required 
                  placeholder="Describe el resultado del test..."
                  style="border-color: var(--color-azul);"></textarea>
        <small class="text-muted">Ingresa el resultado en formato libre</small>
      </div>`;
  }
  
  html += '</div></div>';
  
  contenedor.innerHTML = html;
  
  // Agregar validación visual a los campos
  setTimeout(() => {
    const inputs = contenedor.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.style.boxShadow = '0 0 0 0.2rem rgba(0, 123, 255, 0.25)';
      });
      input.addEventListener('blur', function() {
        this.style.boxShadow = '';
      });
    });
  }, 100);
}

function verResultado(resultado) {
  document.getElementById('modalTitulo').innerHTML = `🏃 ${resultado.nombre_test}`;
  
  let resultadoObj;
  try {
    resultadoObj = JSON.parse(resultado.resultado_json);
  } catch (e) {
    resultadoObj = { valor: resultado.resultado_json };
  }
  
  let contenidoHtml = `
    <p><strong>📅 Fecha:</strong> ${new Date(resultado.fecha_test).toLocaleString()}</p>
    <div class="card">
      <div class="card-header" style="background: var(--color-verde); color: white;">
        <strong>📊 Resultados</strong>
      </div>
      <div class="card-body">`;
  
  // Mostrar resultados de forma más legible
  for (const [key, value] of Object.entries(resultadoObj)) {
    contenidoHtml += `
      <div class="row mb-2">
        <div class="col-4"><strong>${key.replace(/_/g, ' ').toUpperCase()}:</strong></div>
        <div class="col-8">${value}</div>
      </div>`;
  }
  
  contenidoHtml += `
      </div>
    </div>
    <div class="mt-3">
      <strong>📋 Datos Raw (JSON):</strong>
      <pre style="background: #f8f9fa; padding: 15px; border-radius: 8px; overflow-x: auto; font-size: 0.9em;">${JSON.stringify(resultadoObj, null, 2)}</pre>
    </div>`;
  
  document.getElementById('modalContenido').innerHTML = contenidoHtml;
  document.getElementById('modalResultado').style.display = 'block';
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 