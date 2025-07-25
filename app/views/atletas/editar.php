<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h2>✏️ Editar Atleta</h2>
      <p class="text-muted">Modifica los datos del atleta <?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></p>
    </div>
    <div>
      <a href="index.php?controller=Atleta&action=listado" class="btn-volver">
        <i class="fas fa-arrow-left"></i> Volver al Listado
      </a>
    </div>
  </div>

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
      <strong>⚠️ Error:</strong> Ha ocurrido un error al actualizar el atleta. Verifica los datos e intenta nuevamente.
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
      <strong>✅ Éxito:</strong> El atleta ha sido actualizado correctamente.
    </div>
  <?php endif; ?>

  <div class="form-container">
    <form method="POST" action="index.php?controller=Atleta&action=editar&id=<?php echo $atleta['id']; ?>" class="needs-validation" novalidate id="atletaForm">
      
      <!-- Información Personal -->
      <div class="card mb-4">
        <div class="card-header" style="background: linear-gradient(135deg, var(--color-azul) 0%, #0056b3 100%); color: white;">
          <h5 class="mb-0">👤 Información Personal</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre" class="form-label">
                  <strong>Nombre *</strong>
                </label>
                <input type="text" name="nombre" id="nombre" class="form-control" 
                       required maxlength="100" placeholder="Ingresa el nombre"
                       value="<?php echo htmlspecialchars($atleta['nombre']); ?>">
                <div class="invalid-feedback">
                  El nombre es obligatorio
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="apellido" class="form-label">
                  <strong>Apellido *</strong>
                </label>
                <input type="text" name="apellido" id="apellido" class="form-control" 
                       required maxlength="100" placeholder="Ingresa el apellido"
                       value="<?php echo htmlspecialchars($atleta['apellido']); ?>">
                <div class="invalid-feedback">
                  El apellido es obligatorio
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="dni" class="form-label">
                  <strong>DNI/RUT *</strong>
                </label>
                <input type="text" name="dni" id="dni" class="form-control" 
                       required maxlength="20" placeholder="Ej: 12.345.678-9"
                       value="<?php echo htmlspecialchars($atleta['dni']); ?>">
                <div class="invalid-feedback">
                  El DNI/RUT es obligatorio
                </div>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="sexo" class="form-label">
                  <strong>Sexo *</strong>
                </label>
                <select name="sexo" id="sexo" class="form-control" required>
                  <option value="">Seleccionar...</option>
                  <option value="M" <?php echo $atleta['sexo'] === 'M' ? 'selected' : ''; ?>>👨 Masculino</option>
                  <option value="F" <?php echo $atleta['sexo'] === 'F' ? 'selected' : ''; ?>>👩 Femenino</option>
                  <option value="Otro" <?php echo $atleta['sexo'] === 'Otro' ? 'selected' : ''; ?>>⚧️ Otro</option>
                </select>
                <div class="invalid-feedback">
                  Selecciona el sexo
                </div>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="fecha_nacimiento" class="form-label">
                  <strong>Fecha de Nacimiento *</strong>
                </label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                       class="form-control" required max="<?php echo date('Y-m-d'); ?>"
                       value="<?php echo $atleta['fecha_nacimiento']; ?>">
                <div class="invalid-feedback">
                  La fecha de nacimiento es obligatoria
                </div>
                <small class="text-muted">Edad: <span id="edad-calculada">-</span></small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Medidas Antropométricas -->
      <div class="card mb-4">
        <div class="card-header" style="background: linear-gradient(135deg, var(--color-verde) 0%, #1b5e20 100%); color: white;">
          <h5 class="mb-0">📏 Medidas Antropométricas</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="altura_cm" class="form-label">
                  <strong>Altura (cm) *</strong>
                </label>
                <div class="input-group">
                  <input type="number" name="altura_cm" id="altura_cm" class="form-control" 
                         required step="0.1" min="50" max="250" placeholder="Ej: 175.5"
                         value="<?php echo $atleta['altura_cm']; ?>">
                  <div class="input-group-append">
                    <span class="input-group-text">cm</span>
                  </div>
                </div>
                <div class="invalid-feedback">
                  Ingresa una altura válida (50-250 cm)
                </div>
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label for="peso_kg" class="form-label">
                  <strong>Peso (kg) *</strong>
                </label>
                <div class="input-group">
                  <input type="number" name="peso_kg" id="peso_kg" class="form-control" 
                         required step="0.1" min="20" max="200" placeholder="Ej: 70.2"
                         value="<?php echo $atleta['peso_kg']; ?>">
                  <div class="input-group-append">
                    <span class="input-group-text">kg</span>
                  </div>
                </div>
                <div class="invalid-feedback">
                  Ingresa un peso válido (20-200 kg)
                </div>
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label for="envergadura_cm" class="form-label">
                  <strong>Envergadura (cm) *</strong>
                </label>
                <div class="input-group">
                  <input type="number" name="envergadura_cm" id="envergadura_cm" class="form-control" 
                         required step="0.1" min="50" max="250" placeholder="Ej: 180.0"
                         value="<?php echo $atleta['envergadura_cm']; ?>">
                  <div class="input-group-append">
                    <span class="input-group-text">cm</span>
                  </div>
                </div>
                <div class="invalid-feedback">
                  Ingresa una envergadura válida (50-250 cm)
                </div>
                <small class="text-muted">Distancia entre extremos de brazos extendidos</small>
              </div>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label for="altura_sentado_cm" class="form-label">
                  <strong>Altura Sentado (cm) *</strong>
                </label>
                <div class="input-group">
                  <input type="number" name="altura_sentado_cm" id="altura_sentado_cm" class="form-control" 
                         required step="0.1" min="30" max="150" placeholder="Ej: 92.5"
                         value="<?php echo $atleta['altura_sentado_cm']; ?>">
                  <div class="input-group-append">
                    <span class="input-group-text">cm</span>
                  </div>
                </div>
                <div class="invalid-feedback">
                  Ingresa una altura sentado válida (30-150 cm)
                </div>
                <small class="text-muted">Altura desde el asiento hasta la cabeza</small>
              </div>
            </div>
          </div>

          <!-- Cálculos automáticos -->
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="alert alert-light">
                <h6><strong>📊 Cálculos Automáticos:</strong></h6>
                <div class="row">
                  <div class="col-md-4">
                    <small class="text-muted">IMC:</small>
                    <span id="imc-calculado" class="badge badge-info">-</span>
                  </div>
                  <div class="col-md-4">
                    <small class="text-muted">Relación Altura/Envergadura:</small>
                    <span id="relacion-calculada" class="badge badge-info">-</span>
                  </div>
                  <div class="col-md-4">
                    <small class="text-muted">Proporción Tronco:</small>
                    <span id="proporcion-calculada" class="badge badge-info">-</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Lateralidad -->
      <div class="card mb-4">
        <div class="card-header" style="background: linear-gradient(135deg, var(--color-naranja) 0%, #e65100 100%); color: white;">
          <h5 class="mb-0">🎯 Evaluación de Lateralidad</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="lateralidad_visual" class="form-label">
                  <strong>Lateralidad Visual *</strong>
                </label>
                <select name="lateralidad_visual" id="lateralidad_visual" class="form-control" required>
                  <option value="">Seleccionar...</option>
                  <option value="Izquierdo" <?php echo $atleta['lateralidad_visual'] === 'Izquierdo' ? 'selected' : ''; ?>>👁️ Ojo Izquierdo Dominante</option>
                  <option value="Derecho" <?php echo $atleta['lateralidad_visual'] === 'Derecho' ? 'selected' : ''; ?>>👁️ Ojo Derecho Dominante</option>
                  <option value="Ambidiestro" <?php echo $atleta['lateralidad_visual'] === 'Ambidiestro' ? 'selected' : ''; ?>>👀 Sin Dominancia Clara</option>
                </select>
                <div class="invalid-feedback">
                  Selecciona la lateralidad visual
                </div>
                <small class="text-muted">Ojo dominante para apuntar o mirar por un tubo</small>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="lateralidad_podal" class="form-label">
                  <strong>Lateralidad Podal *</strong>
                </label>
                <select name="lateralidad_podal" id="lateralidad_podal" class="form-control" required>
                  <option value="">Seleccionar...</option>
                  <option value="Izquierdo" <?php echo $atleta['lateralidad_podal'] === 'Izquierdo' ? 'selected' : ''; ?>>🦶 Pie Izquierdo Dominante</option>
                  <option value="Derecho" <?php echo $atleta['lateralidad_podal'] === 'Derecho' ? 'selected' : ''; ?>>🦶 Pie Derecho Dominante</option>
                  <option value="Ambidiestro" <?php echo $atleta['lateralidad_podal'] === 'Ambidiestro' ? 'selected' : ''; ?>>👣 Sin Dominancia Clara</option>
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

      <!-- Botones de Acción -->
      <div class="d-flex justify-content-between">
        <a href="index.php?controller=Atleta&action=listado" class="btn btn-secondary">
          ❌ Cancelar
        </a>
        <button type="submit" class="btn btn-warning" id="btnGuardar">
          ✅ Actualizar Atleta
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// Validación del formulario
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

// Cálculo automático de edad
function calcularEdad() {
  const fechaNacimiento = new Date(document.getElementById('fecha_nacimiento').value);
  const hoy = new Date();
  let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
  const mes = hoy.getMonth() - fechaNacimiento.getMonth();
  
  if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
    edad--;
  }
  
  document.getElementById('edad-calculada').textContent = edad + ' años';
}

document.getElementById('fecha_nacimiento').addEventListener('change', calcularEdad);

// Cálculos antropométricos automáticos
function calcularMedidas() {
  const altura = parseFloat(document.getElementById('altura_cm').value);
  const peso = parseFloat(document.getElementById('peso_kg').value);
  const envergadura = parseFloat(document.getElementById('envergadura_cm').value);
  const alturaSentado = parseFloat(document.getElementById('altura_sentado_cm').value);
  
  // Calcular IMC
  if (altura && peso) {
    const alturaM = altura / 100;
    const imc = peso / (alturaM * alturaM);
    let categoriaIMC = '';
    
    if (imc < 18.5) categoriaIMC = 'Bajo peso';
    else if (imc < 25) categoriaIMC = 'Normal';
    else if (imc < 30) categoriaIMC = 'Sobrepeso';
    else categoriaIMC = 'Obesidad';
    
    document.getElementById('imc-calculado').textContent = imc.toFixed(1) + ' (' + categoriaIMC + ')';
  }
  
  // Calcular relación altura/envergadura
  if (altura && envergadura) {
    const relacion = envergadura / altura;
    document.getElementById('relacion-calculada').textContent = relacion.toFixed(2);
  }
  
  // Calcular proporción del tronco
  if (altura && alturaSentado) {
    const proporcion = (alturaSentado / altura) * 100;
    document.getElementById('proporcion-calculada').textContent = proporcion.toFixed(1) + '%';
  }
}

// Agregar listeners para cálculos automáticos
['altura_cm', 'peso_kg', 'envergadura_cm', 'altura_sentado_cm'].forEach(function(id) {
  document.getElementById(id).addEventListener('input', calcularMedidas);
});

// Validación del DNI/RUT (formato básico)
document.getElementById('dni').addEventListener('blur', function() {
  const dni = this.value.trim();
  if (dni && dni.length < 7) {
    this.setCustomValidity('El DNI/RUT debe tener al menos 7 caracteres');
  } else {
    this.setCustomValidity('');
  }
});

// Mejorar la experiencia visual
document.querySelectorAll('input, select').forEach(function(element) {
  element.addEventListener('focus', function() {
    this.style.boxShadow = '0 0 0 0.2rem rgba(0, 123, 255, 0.25)';
  });
  
  element.addEventListener('blur', function() {
    this.style.boxShadow = '';
  });
});

// Confirmación antes de enviar
document.getElementById('atletaForm').addEventListener('submit', function(e) {
  const nombre = document.getElementById('nombre').value;
  const apellido = document.getElementById('apellido').value;
  
  if (!confirm('¿Estás seguro de que deseas actualizar los datos de ' + nombre + ' ' + apellido + '?')) {
    e.preventDefault();
  }
});

// Calcular valores iniciales al cargar la página
window.addEventListener('load', function() {
  calcularEdad();
  calcularMedidas();
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 