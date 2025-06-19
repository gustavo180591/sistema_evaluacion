<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h2>📋 Evaluaciones Registradas</h2>
      <p class="text-muted">Gestiona y revisa las evaluaciones realizadas en tu establecimiento</p>
    </div>
    <div>
      <a href="index.php?controller=Test&action=nuevaEvaluacion" class="btn btn-success">
        ➕ Nueva Evaluación
      </a>
    </div>
  </div>

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
      <?php if ($_GET['error'] === 'evaluacion_no_autorizada'): ?>
        <strong>⚠️ Error:</strong> No tienes autorización para acceder a evaluaciones de otros establecimientos.
      <?php elseif ($_GET['error'] === 'atleta_no_autorizado'): ?>
        <strong>⚠️ Error:</strong> No tienes autorización para evaluar atletas de otros establecimientos.
      <?php else: ?>
        <strong>⚠️ Error:</strong> Ha ocurrido un error inesperado.
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if (empty($evaluaciones)): ?>
    <div class="alert alert-info text-center">
      <h4>📝 No hay evaluaciones registradas</h4>
      <p>Comienza creando una nueva evaluación para registrar los tests de tus atletas.</p>
      <a href="index.php?controller=Test&action=nuevaEvaluacion" class="btn btn-primary">
        Crear Primera Evaluación
      </a>
    </div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($evaluaciones as $evaluacion): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card" style="border: none; box-shadow: var(--sombra-suave); border-radius: var(--borde-radius);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--color-azul) 0%, #0056b3 100%); color: white; border-radius: var(--borde-radius) var(--borde-radius) 0 0;">
              <h5 class="mb-0">
                👤 <?php echo htmlspecialchars($evaluacion['apellido'] . ', ' . $evaluacion['nombre']); ?>
              </h5>
              <small style="opacity: 0.9;">
                📅 <?php echo date('d/m/Y', strtotime($evaluacion['fecha_evaluacion'])); ?>
              </small>
            </div>
            <div class="card-body">
              <div class="mb-2">
                <span class="badge <?php 
                  echo $evaluacion['estado'] === 'completada' ? 'badge-success' : 
                       ($evaluacion['estado'] === 'en_progreso' ? 'badge-warning' : 'badge-info'); 
                ?>">
                  <?php echo strtoupper($evaluacion['estado']); ?>
                </span>
              </div>
              
              <?php if ($evaluacion['lugar_nombre']): ?>
                <p class="mb-2">
                  <strong>📍 Lugar:</strong> <?php echo htmlspecialchars($evaluacion['lugar_nombre']); ?>
                </p>
              <?php endif; ?>
              
              <p class="mb-2">
                <strong>🏃 Tests realizados:</strong> 
                <span class="badge badge-primary"><?php echo $evaluacion['total_tests']; ?></span>
              </p>
              
              <?php if ($evaluacion['tests_realizados']): ?>
                <p class="mb-3" style="font-size: 0.9em; color: #666;">
                  <strong>Tests:</strong> <?php echo htmlspecialchars($evaluacion['tests_realizados']); ?>
                </p>
              <?php endif; ?>
              
              <?php if ($evaluacion['observaciones']): ?>
                <p class="mb-3" style="font-size: 0.9em; color: #666;">
                  <strong>📝 Observaciones:</strong> <?php echo htmlspecialchars($evaluacion['observaciones']); ?>
                </p>
              <?php endif; ?>
              
              <div class="d-flex justify-content-between">
                <a href="index.php?controller=Test&action=evaluacion&id=<?php echo $evaluacion['id']; ?>" 
                   class="btn btn-primary btn-sm">
                  👁️ Ver Detalles
                </a>
                <?php if ($evaluacion['estado'] !== 'completada'): ?>
                  <a href="index.php?controller=Test&action=evaluacion&id=<?php echo $evaluacion['id']; ?>" 
                     class="btn btn-success btn-sm">
                    ➕ Agregar Tests
                  </a>
                <?php endif; ?>
              </div>
            </div>
            
            <?php if ($evaluacion['hora_inicio'] || $evaluacion['clima']): ?>
              <div class="card-footer" style="background: #f8f9fa; font-size: 0.85em; color: #666;">
                <?php if ($evaluacion['hora_inicio']): ?>
                  ⏰ Inicio: <?php echo $evaluacion['hora_inicio']; ?>
                <?php endif; ?>
                <?php if ($evaluacion['clima']): ?>
                  | 🌤️ <?php echo htmlspecialchars($evaluacion['clima']); ?>
                <?php endif; ?>
                <?php if ($evaluacion['temperatura_ambiente']): ?>
                  | 🌡️ <?php echo $evaluacion['temperatura_ambiente']; ?>°C
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>