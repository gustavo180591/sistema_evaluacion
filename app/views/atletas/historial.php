<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2><i class="fas fa-history"></i> Historial de Evaluaciones</h2>
      <p class="text-muted">Evaluaciones registradas para <?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></p>
    </div>
    <div>
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
        <h4 class="text-muted">No hay evaluaciones registradas</h4>
        <p class="text-muted">Este atleta aún no tiene evaluaciones registradas</p>
      </div>
    </div>
  <?php else: ?>
    <div class="card">
      <div class="card-header" style="background: linear-gradient(135deg, var(--color-azul) 0%, #0056b3 100%); color: white;">
        <h5 class="mb-0">
          <i class="fas fa-list"></i> Registro de Evaluaciones
        </h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col" style="width: 15%;">📅 Fecha</th>
                <th scope="col" style="width: 25%;">🧪 Test</th>
                <th scope="col" style="width: 20%;">📍 Lugar</th>
                <th scope="col" style="width: 40%;">📊 Resultado</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($resultados as $r): ?>
                <tr>
                  <td class="align-middle">
                    <?php echo date('d/m/Y', strtotime($r['fecha_test'])); ?>
                    <div class="text-muted small">
                      <?php echo date('H:i', strtotime($r['fecha_test'])); ?>
                    </div>
                  </td>
                  <td class="align-middle">
                    <strong><?php echo htmlspecialchars($r['nombre_test']); ?></strong>
                    <?php if (isset($r['categoria'])): ?>
                      <div class="badge badge-info"><?php echo htmlspecialchars($r['categoria']); ?></div>
                    <?php endif; ?>
                  </td>
                  <td class="align-middle">
                    <i class="fas fa-map-marker-alt text-muted"></i> 
                    <?php echo htmlspecialchars($r['lugar']); ?>
                  </td>
                  <td class="align-middle">
                    <?php if (isset($r['valor_resultado'])): ?>
                      <div class="d-flex align-items-center">
                        <span class="badge badge-primary mr-2" style="font-size: 1em;">
                          <?php 
                            $valor = $r['valor_resultado'];
                            $unidad = $r['unidad_medida'] ?? '';
                            echo htmlspecialchars($valor . ' ' . $unidad);
                          ?>
                        </span>
                        <?php if (isset($r['resultado_json'])): ?>
                          <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="collapse" 
                                  data-target="#detalles-<?php echo $r['id']; ?>" aria-expanded="false" 
                                  aria-controls="detalles-<?php echo $r['id']; ?>">
                            <i class="fas fa-ellipsis-h"></i> Detalles
                          </button>
                        <?php endif; ?>
                      </div>
                      <?php if (isset($r['resultado_json'])): ?>
                        <div class="collapse mt-2" id="detalles-<?php echo $r['id']; ?>">
                          <div class="card card-body p-2 bg-light">
                            <pre class="mb-0 small" style="max-height: 200px; overflow-y: auto;"><?php 
                              echo htmlspecialchars(
                                json_encode(
                                  json_decode($r['resultado_json'], true), 
                                  JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                                )
                              );
                            ?></pre>
                          </div>
                        </div>
                      <?php endif; ?>
                    <?php else: ?>
                      <span class="text-muted">Sin datos cuantitativos</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer text-muted">
        <div class="row">
          <div class="col-md-6">
            <small>
              Mostrando <strong><?php echo count($resultados); ?></strong> evaluaciones registradas
            </small>
          </div>
          <div class="col-md-6 text-right">
            <a href="#" class="btn btn-sm btn-outline-primary" onclick="window.print()">
              <i class="fas fa-print"></i> Imprimir
            </a>
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
</style>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
