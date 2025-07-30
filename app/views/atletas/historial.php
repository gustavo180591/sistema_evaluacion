<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2><i class="fas fa-history"></i> Historial de Tests Realizados</h2>
      <p class="text-muted">Evaluaciones registradas para <strong><?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></strong></p>
      <div class="mt-2">
        <span class="badge badge-info">DNI: <?php echo htmlspecialchars($atleta['dni']); ?></span>
        <span class="badge badge-secondary">Edad: <?php echo date_diff(date_create($atleta['fecha_nacimiento']), date_create('today'))->y; ?> años</span>
      </div>
    </div>
    <div class="d-flex flex-column gap-2">
      <div class="btn-group" role="group">
        <a href="index.php?controller=Atleta&action=exportarHistorialPDF&id=<?php echo $atleta['id']; ?>" 
           class="btn btn-danger" title="Exportar a PDF">
          <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
        <a href="index.php?controller=Atleta&action=exportarHistorialExcel&id=<?php echo $atleta['id']; ?>" 
           class="btn btn-success" title="Exportar a Excel">
          <i class="fas fa-file-excel"></i> Exportar Excel
        </a>
      </div>
      <a href="index.php?controller=Atleta&action=listado" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver al Listado
      </a>
    </div>
  </div>

  <?php if (empty($resultados)): ?>
    <div class="card text-center">
      <div class="card-body py-5">
        <div class="mb-3">
          <i class="fas fa-clipboard-list fa-3x text-muted"></i>
        </div>
        <h4 class="text-muted">No hay tests registrados</h4>
        <p class="text-muted">Este atleta aún no tiene tests registrados</p>
        <a href="index.php?controller=Evaluacion&action=nueva&atleta_id=<?php echo $atleta['id']; ?>" class="btn btn-primary">
          <i class="fas fa-plus"></i> Realizar Primer Test
        </a>
      </div>
    </div>
  <?php else: ?>
    <!-- Estadísticas rápidas -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card bg-primary text-white">
          <div class="card-body text-center">
            <h4><?php echo count($resultados); ?></h4>
            <p class="mb-0">Total Tests</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-success text-white">
          <div class="card-body text-center">
            <h4><?php echo count(array_unique(array_column($resultados, 'test_id'))); ?></h4>
            <p class="mb-0">Tipos de Test</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-info text-white">
          <div class="card-body text-center">
            <h4><?php echo count(array_unique(array_column($resultados, 'lugar_id'))); ?></h4>
            <p class="mb-0">Lugares</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card bg-warning text-white">
          <div class="card-body text-center">
            <h4><?php echo date('d/m/Y', strtotime($resultados[0]['fecha_test'])); ?></h4>
            <p class="mb-0">Último Test</p>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header" style="background: linear-gradient(135deg, var(--color-azul) 0%, #0056b3 100%); color: white;">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-list"></i> Lista de Tests Realizados
          </h5>
          <div class="text-white">
            <small>Mostrando <?php echo count($resultados); ?> resultados</small>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col" style="width: 12%;">📅 Fecha</th>
                <th scope="col" style="width: 20%;">🧪 Test</th>
                <th scope="col" style="width: 15%;">📍 Lugar</th>
                <th scope="col" style="width: 25%;">📊 Resultado</th>
                <th scope="col" style="width: 15%;">👨‍⚕️ Evaluador</th>
                <th scope="col" style="width: 13%;">⚙️ Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($resultados as $r): ?>
                <tr>
                  <td class="align-middle">
                    <div class="font-weight-bold"><?php echo date('d/m/Y', strtotime($r['fecha_test'])); ?></div>
                    <div class="text-muted small"><?php echo date('H:i', strtotime($r['fecha_test'])); ?></div>
                  </td>
                  <td class="align-middle">
                    <div class="font-weight-bold"><?php echo htmlspecialchars($r['nombre_test']); ?></div>
                    <?php if (isset($r['descripcion']) && !empty($r['descripcion'])): ?>
                      <span class="badge badge-info"><?php echo htmlspecialchars($r['descripcion']); ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="align-middle">
                    <i class="fas fa-map-marker-alt text-muted"></i> 
                    <?php echo htmlspecialchars($r['lugar']); ?>
                  </td>
                  <td class="align-middle">
                    <?php if (isset($r['resultado_json'])): ?>
                      <?php 
                        $resultadoData = json_decode($r['resultado_json'], true);
                        if (is_array($resultadoData)) {
                          // Mostrar el primer valor numérico encontrado
                          $valorMostrado = false;
                          foreach ($resultadoData as $key => $value) {
                            if (is_numeric($value) && !$valorMostrado) {
                              echo '<span class="badge badge-primary mr-2" style="font-size: 1em;">';
                              echo htmlspecialchars($value);
                              if (isset($resultadoData['unidad'])) {
                                echo ' ' . htmlspecialchars($resultadoData['unidad']);
                              }
                              echo '</span>';
                              $valorMostrado = true;
                              break;
                            }
                          }
                          if (!$valorMostrado) {
                            echo '<span class="badge badge-secondary">Datos completos</span>';
                          }
                        } else {
                          echo '<span class="badge badge-secondary">Datos disponibles</span>';
                        }
                      ?>
                      <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="collapse" 
                              data-target="#detalles-<?php echo $r['id']; ?>" aria-expanded="false" 
                              aria-controls="detalles-<?php echo $r['id']; ?>">
                        <i class="fas fa-eye"></i> Ver
                      </button>
                    <?php else: ?>
                      <span class="text-muted">Sin datos</span>
                    <?php endif; ?>
                  </td>
                  <td class="align-middle">
                    <small class="text-muted">
                      <i class="fas fa-user-md"></i> 
                      <?php echo htmlspecialchars($r['evaluador_nombre'] ?? 'N/A'); ?>
                    </small>
                  </td>
                  <td class="align-middle">
                    <div class="btn-group btn-group-sm" role="group">
                      <button class="btn btn-outline-primary" type="button" data-toggle="collapse" 
                              data-target="#detalles-<?php echo $r['id']; ?>" aria-expanded="false" 
                              aria-controls="detalles-<?php echo $r['id']; ?>" title="Ver Detalles">
                        <i class="fas fa-eye"></i>
                      </button>
                      <a href="index.php?controller=Atleta&action=exportarTestPDF&id=<?php echo $r['id']; ?>" 
                         class="btn btn-outline-danger" title="Exportar Test a PDF">
                        <i class="fas fa-file-pdf"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php if (isset($r['resultado_json'])): ?>
                  <tr>
                    <td colspan="6" class="p-0">
                      <div class="collapse" id="detalles-<?php echo $r['id']; ?>">
                        <div class="card card-body m-2 bg-light">
                          <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Detalles del Test: <?php echo htmlspecialchars($r['nombre_test']); ?></h6>
                            <a href="index.php?controller=Atleta&action=exportarTestPDF&id=<?php echo $r['id']; ?>" 
                               class="btn btn-sm btn-danger">
                              <i class="fas fa-file-pdf"></i> Exportar PDF
                            </a>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <h6>Información General:</h6>
                              <ul class="list-unstyled">
                                <li><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($r['fecha_test'])); ?></li>
                                <li><strong>Lugar:</strong> <?php echo htmlspecialchars($r['lugar']); ?></li>
                                <li><strong>Test:</strong> <?php echo htmlspecialchars($r['nombre_test']); ?></li>
                              </ul>
                            </div>
                            <div class="col-md-6">
                              <h6>Resultados:</h6>
                              <pre class="bg-white p-2 rounded" style="max-height: 200px; overflow-y: auto; font-size: 0.875rem;"><?php 
                                echo htmlspecialchars(
                                  json_encode(
                                    json_decode($r['resultado_json'], true), 
                                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                                  )
                                );
                              ?></pre>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer text-muted">
        <div class="row">
          <div class="col-md-6">
            <small>
              <i class="fas fa-info-circle"></i> 
              Total de tests: <strong><?php echo count($resultados); ?></strong> | 
              Última actualización: <?php echo date('d/m/Y H:i'); ?>
            </small>
          </div>
          <div class="col-md-6 text-right">
            <div class="btn-group btn-group-sm">
              <a href="index.php?controller=Atleta&action=exportarHistorialPDF&id=<?php echo $atleta['id']; ?>" 
                 class="btn btn-outline-danger">
                <i class="fas fa-file-pdf"></i> PDF
              </a>
              <a href="index.php?controller=Atleta&action=exportarHistorialExcel&id=<?php echo $atleta['id']; ?>" 
                 class="btn btn-outline-success">
                <i class="fas fa-file-excel"></i> Excel
              </a>
              <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimir
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<style>
.table td {
  vertical-align: middle !important;
}

.badge {
  font-weight: 500;
  padding: 0.35em 0.65em;
}

.pre-scrollable {
  max-height: 200px;
  overflow-y: auto;
}

.card-header h5 {
  font-size: 1.1rem;
  font-weight: 500;
}

.btn-group .btn {
  margin: 1px;
}

/* Mejorar la visualización de las estadísticas */
.card.bg-primary, .card.bg-success, .card.bg-info, .card.bg-warning {
  border: none;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card.bg-primary h4, .card.bg-success h4, .card.bg-info h4, .card.bg-warning h4 {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
  .btn-group {
    flex-direction: column;
  }
  
  .btn-group .btn {
    margin: 1px 0;
  }
  
  .table-responsive {
    font-size: 0.875rem;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Inicializar tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
  
  // Mejorar la experiencia de los botones de colapso
  const collapseButtons = document.querySelectorAll('[data-toggle="collapse"]');
  collapseButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      const target = this.getAttribute('data-target');
      const targetElement = document.querySelector(target);
      
      if (targetElement) {
        const isExpanded = targetElement.classList.contains('show');
        if (isExpanded) {
          this.innerHTML = '<i class="fas fa-eye"></i> Ver';
        } else {
          this.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar';
        }
      }
    });
  });
});
</script>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
