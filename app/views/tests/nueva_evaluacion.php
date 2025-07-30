<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
  <div class="mb-3">
    <h2>➕ Nueva Evaluación</h2>
    <p class="text-muted">Crea una nueva sesión de evaluación para un atleta de tu establecimiento</p>
  </div>

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
      <?php if ($_GET['error'] === 'atleta_no_autorizado'): ?>
        <strong>⚠️ Error:</strong> No tienes autorización para evaluar atletas de otros establecimientos.
      <?php else: ?>
        <strong>⚠️ Error:</strong> Ha ocurrido un error inesperado.
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if (empty($atletas)): ?>
    <div class="alert alert-warning">
      <h5>⚠️ Sin atletas asignados</h5>
      <p>No tienes atletas asignados a tu establecimiento. Contacta al administrador para que te asigne atletas.</p>
      <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                </a>
      <style>
        .btn:hover {
          transform: translateY(-2px);
          box-shadow: 0 7px 20px rgba(106, 17, 203, 0.4);
          text-decoration: none;
        }
        .btn:active {
          transform: translateY(0);
        }
      </style>
    </div>
  <?php else: ?>
    <div class="form-container">
      <form method="POST" action="index.php?controller=Test&action=nuevaEvaluacion">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="atleta_id" class="form-label">👤 Atleta *</label>
              <select name="atleta_id" id="atleta_id" class="form-control" required>
                <option value="">Seleccionar atleta...</option>
                <?php foreach ($atletas as $atleta): ?>
                  <option value="<?php echo $atleta['id']; ?>">
                    <?php echo htmlspecialchars($atleta['apellido'] . ', ' . $atleta['nombre']); ?>
                    <?php if (isset($atleta['lugar_nombre'])): ?>
                      - <?php echo htmlspecialchars($atleta['lugar_nombre']); ?>
                    <?php endif; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <small class="text-muted">Solo puedes evaluar atletas de tu establecimiento</small>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="lugar_id" class="form-label">📍 Lugar</label>
              <select name="lugar_id" id="lugar_id" class="form-control">
                <option value="">Seleccionar lugar...</option>
                <?php foreach ($lugares as $lugar): ?>
                  <option value="<?php echo $lugar['id']; ?>">
                    <?php echo htmlspecialchars($lugar['nombre']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <small class="text-muted">Lugar donde se realizará la evaluación</small>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="fecha_evaluacion" class="form-label">📅 Fecha de Evaluación *</label>
              <input type="date" name="fecha_evaluacion" id="fecha_evaluacion" 
                     class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="hora_inicio" class="form-label">⏰ Hora de Inicio</label>
              <input type="time" name="hora_inicio" id="hora_inicio" 
                     class="form-control" value="<?php echo date('H:i'); ?>">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="clima" class="form-label">🌤️ Clima</label>
              <select name="clima" id="clima" class="form-control">
                <option value="">Seleccionar...</option>
                <option value="Soleado">☀️ Soleado</option>
                <option value="Nublado">☁️ Nublado</option>
                <option value="Lluvia ligera">🌦️ Lluvia ligera</option>
                <option value="Lluvia">🌧️ Lluvia</option>
                <option value="Viento">💨 Viento</option>
                <option value="Despejado">🌤️ Despejado</option>
              </select>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group">
              <label for="temperatura_ambiente" class="form-label">🌡️ Temperatura (°C)</label>
              <input type="number" name="temperatura_ambiente" id="temperatura_ambiente" 
                     class="form-control" step="0.1" min="-10" max="50" 
                     placeholder="Ej: 22.5">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="observaciones" class="form-label">📝 Observaciones</label>
          <textarea name="observaciones" id="observaciones" class="form-control" 
                    rows="3" placeholder="Notas adicionales sobre la evaluación..."></textarea>
        </div>

        <div class="d-flex justify-content-between">
          <a href="index.php?controller=Test&action=resultados" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver
          </a>
          <button type="submit" class="btn btn-success">
            ✅ Crear Evaluación
          </button>
        </div>
      </form>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 