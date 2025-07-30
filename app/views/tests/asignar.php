<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh; padding: 20px 0;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-xl-6">
        <!-- Header -->
        <div class="text-center mb-5">
          <div class="mb-3">
            <div style="
              background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
              border-radius: 50%;
              width: 80px;
              height: 80px;
              display: flex;
              align-items: center;
              justify-content: center;
              margin: 0 auto;
              box-shadow: 0 8px 25px rgba(255,107,107,0.3);
            ">
              <i class="fas fa-bolt" style="font-size: 2rem; color: white;"></i>
            </div>
          </div>
          <h1 class="display-4 mb-2" style="color: #2c3e50; font-weight: 700;">
            ⚡ Test Rápido
          </h1>
          <p class="lead text-muted">Registra un test individual de forma rápida y eficiente</p>
        </div>

        <!-- Formulario Principal -->
        <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
          <!-- Header del formulario -->
          <div class="card-header text-white" style="
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            padding: 25px 30px;
            border: none;
          ">
            <h4 class="mb-0 font-weight-bold">
              <i class="fas fa-clipboard-check"></i> Información del Test
            </h4>
            <small style="opacity: 0.9;">Completa todos los campos para registrar el resultado</small>
          </div>

          <div class="card-body" style="padding: 30px;">
            <form method="POST" action="index.php?controller=Test&action=registrar" class="needs-validation" novalidate>
              <!-- Selección de Atleta -->
              <div class="form-group mb-4">
                <label class="form-label font-weight-bold" style="color: #495057; margin-bottom: 10px;">
                  <i class="fas fa-user"></i> Atleta a Evaluar
                </label>
                <select name="atleta_id" class="form-control form-control-lg" required style="
                  border-radius: 12px;
                  border: 2px solid #e9ecef;
                  padding: 15px;
                  font-size: 1rem;
                  transition: all 0.3s ease;
                " onfocus="this.style.borderColor='#ff6b6b'; this.style.boxShadow='0 0 0 0.2rem rgba(255,107,107,0.25)'"
                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                  <option value="">🔍 Seleccionar atleta...</option>
                  <?php foreach ($atletas as $a): ?>
                    <option value="<?php echo $a['id']; ?>">
                      👤 <?php echo htmlspecialchars($a['apellido'] . ', ' . $a['nombre']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                  Por favor selecciona un atleta para evaluar.
                </div>
              </div>

              <!-- Selección de Test -->
              <div class="form-group mb-4">
                <label class="form-label font-weight-bold" style="color: #495057; margin-bottom: 10px;">
                  <i class="fas fa-dumbbell"></i> Test a Realizar
                </label>
                <select name="test_id" class="form-control form-control-lg" required style="
                  border-radius: 12px;
                  border: 2px solid #e9ecef;
                  padding: 15px;
                  font-size: 1rem;
                  transition: all 0.3s ease;
                " onfocus="this.style.borderColor='#ff6b6b'; this.style.boxShadow='0 0 0 0.2rem rgba(255,107,107,0.25)'"
                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                  <option value="">🏃 Seleccionar test...</option>
                  <?php foreach ($tests as $t): ?>
                    <option value="<?php echo $t['id']; ?>">
                      🎯 <?php echo htmlspecialchars($t['nombre_test']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                  Por favor selecciona el test a realizar.
                </div>
              </div>

              <!-- Selección de Lugar -->
              <div class="form-group mb-4">
                <label class="form-label font-weight-bold" style="color: #495057; margin-bottom: 10px;">
                  <i class="fas fa-map-marker-alt"></i> Lugar de Evaluación
                </label>
                <select name="lugar_id" class="form-control form-control-lg" required style="
                  border-radius: 12px;
                  border: 2px solid #e9ecef;
                  padding: 15px;
                  font-size: 1rem;
                  transition: all 0.3s ease;
                " onfocus="this.style.borderColor='#ff6b6b'; this.style.boxShadow='0 0 0 0.2rem rgba(255,107,107,0.25)'"
                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                  <option value="">📍 Seleccionar lugar...</option>
                  <?php foreach ($lugares as $l): ?>
                    <option value="<?php echo $l['id']; ?>">
                      🏢 <?php echo htmlspecialchars($l['nombre']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                  Por favor selecciona el lugar donde se realizará el test.
                </div>
              </div>

              <!-- Fecha del Test -->
              <div class="form-group mb-4">
                <label class="form-label font-weight-bold" style="color: #495057; margin-bottom: 10px;">
                  <i class="fas fa-calendar-alt"></i> Fecha del Test
                </label>
                <input type="date" name="fecha_test" value="<?php echo date('Y-m-d'); ?>" 
                       class="form-control form-control-lg" required style="
                  border-radius: 12px;
                  border: 2px solid #e9ecef;
                  padding: 15px;
                  font-size: 1rem;
                  transition: all 0.3s ease;
                " onfocus="this.style.borderColor='#ff6b6b'; this.style.boxShadow='0 0 0 0.2rem rgba(255,107,107,0.25)'"
                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                <div class="invalid-feedback">
                  Por favor indica la fecha del test.
                </div>
              </div>

              <!-- Resultado JSON -->
              <div class="form-group mb-4">
                <label class="form-label font-weight-bold" style="color: #495057; margin-bottom: 10px;">
                  <i class="fas fa-code"></i> Resultado del Test (Formato JSON)
                </label>
                <div style="
                  background: linear-gradient(135deg, #e8f4f8 0%, #d1ecf1 100%);
                  border-radius: 12px;
                  padding: 15px;
                  margin-bottom: 10px;
                  border-left: 4px solid #17a2b8;
                ">
                  <small style="color: #0c5460;">
                    <strong>💡 Ejemplos de formato:</strong><br>
                    • <code>{"fuerza_mano_derecha": 32.5, "fuerza_mano_izquierda": 31.8}</code><br>
                    • <code>{"altura_salto": 45.2, "tiempo_contacto": 180}</code><br>
                    • <code>{"distancia_alcanzada": 15.5, "flexibilidad": "Buena"}</code>
                  </small>
                </div>
                <textarea name="resultado" rows="6" class="form-control" required style="
                  border-radius: 12px;
                  border: 2px solid #e9ecef;
                  padding: 15px;
                  font-size: 0.95rem;
                  font-family: 'Courier New', monospace;
                  transition: all 0.3s ease;
                  resize: vertical;
                " placeholder='{"campo1": valor1, "campo2": valor2, "observaciones": "texto"}'
                   onfocus="this.style.borderColor='#ff6b6b'; this.style.boxShadow='0 0 0 0.2rem rgba(255,107,107,0.25)'"
                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"></textarea>
                <div class="invalid-feedback">
                  Por favor ingresa el resultado del test en formato JSON válido.
                </div>
              </div>

              <input type="hidden" name="evaluador_id" value="<?php echo $_SESSION['usuario_id']; ?>">

              <!-- Botones de Acción -->
              <div class="row mt-5">
                <div class="col-md-6 mb-3">
                  <a href="index.php?controller=Dashboard" class="btn btn-outline-secondary btn-lg w-100" style="
                    border-radius: 12px;
                    padding: 15px;
                    font-weight: 600;
                    border: 2px solid #6c757d;
                  ">
                    <i class="fas fa-arrow-left"></i> Cancelar
                  </a>
                </div>
                <div class="col-md-6 mb-3">
                  <button type="submit" class="btn btn-lg w-100" style="
                    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
                    border: none;
                    border-radius: 12px;
                    padding: 15px;
                    color: white;
                    font-weight: 600;
                    transition: all 0.3s ease;
                  " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(255,107,107,0.4)'"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <i class="fas fa-save"></i> Registrar Resultado
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<style>
.form-control:focus {
  box-shadow: 0 0 0 0.2rem rgba(255,107,107,0.25) !important;
  border-color: #ff6b6b !important;
}

.btn:focus {
  box-shadow: 0 0 0 0.2rem rgba(255,107,107,0.25) !important;
}

/* Validación personalizada */
.was-validated .form-control:valid {
  border-color: #28a745;
}

.was-validated .form-control:invalid {
  border-color: #dc3545;
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

.card {
  animation: fadeInUp 0.6s ease;
}
</style>

<script>
// Validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.needs-validation');
  const resultadoTextarea = document.querySelector('textarea[name="resultado"]');
  
  // Validación del JSON
  if (resultadoTextarea) {
    resultadoTextarea.addEventListener('blur', function() {
      const valor = this.value.trim();
      if (valor) {
        try {
          JSON.parse(valor);
          this.classList.remove('is-invalid');
          this.classList.add('is-valid');
        } catch (e) {
          this.classList.remove('is-valid');
          this.classList.add('is-invalid');
          this.setCustomValidity('El formato JSON no es válido');
        }
      }
    });
  }
  
  // Validación del formulario
  form.addEventListener('submit', function(event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add('was-validated');
  });
  
  // Efectos visuales
  const selects = document.querySelectorAll('select');
  selects.forEach(select => {
    select.addEventListener('change', function() {
      if (this.value) {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
      }
    });
  });
  
  console.log('✅ Test Rápido cargado correctamente');
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>