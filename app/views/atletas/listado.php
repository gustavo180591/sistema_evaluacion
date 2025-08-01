<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2>👥 Todos los Atletas</h2>
      <p class="text-muted">Listado completo de atletas registrados en el sistema. Puedes <strong>evaluar</strong>, <strong>editar información</strong> y <strong>ver historial</strong> de cualquier atleta.</p>
      
      <?php 
      // Verificar si se necesita ejecutar migración
      global $pdo;
      $stmt = $pdo->query("SHOW COLUMNS FROM atletas LIKE 'activo'");
      $campoActivoExiste = $stmt->rowCount() > 0;
      
      if (!$campoActivoExiste): ?>
        <div class="alert alert-warning mt-2">
          <strong><i class="fas fa-exclamation-triangle"></i> Migración Pendiente:</strong> 
          Para habilitar la función de ocultar atletas, ejecute la migración: 
          <a href="ejecutar_migracion_web.php" target="_blank" class="btn btn-sm btn-warning ms-2">
            <i class="fas fa-database"></i> Ejecutar Migración
          </a>
        </div>
      <?php endif; ?>
      
      <div class="mt-3">
        <a href="index.php?controller=Atleta&action=adaptados" class="btn btn-primary">
          <i class="fas fa-wheelchair"></i> Ver Atletas Adaptados
        </a>
      </div>
    </div>
    <div class="d-flex gap-2">
      <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
      </a>
      <a href="index.php?controller=Atleta&action=crear" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> Nuevo Atleta
      </a>
    </div>
  </div>

  <?php if (empty($atletas)): ?>
    <div class="card text-center">
      <div class="card-body py-5">
        <div class="mb-3">
          <i class="fas fa-users fa-3x text-muted"></i>
        </div>
        <h4 class="text-muted">No hay atletas registrados</h4>
        <p class="text-muted">No hay atletas registrados en el sistema</p>
        <a href="index.php?controller=Atleta&action=crear" class="btn btn-primary">
          <i class="fas fa-plus"></i> Registrar Primer Atleta
        </a>
      </div>
    </div>
  <?php else: ?>
    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php if ($_GET['success'] === 'hidden' && isset($_GET['nombre'])): ?>
          <strong>✅ Éxito:</strong> El atleta "<?php echo htmlspecialchars(urldecode($_GET['nombre'])); ?>" ha sido ocultado correctamente y ya no aparece en el listado.
        <?php elseif ($_GET['success'] === 'deleted' && isset($_GET['nombre'])): ?>
          <strong>✅ Éxito:</strong> El atleta "<?php echo htmlspecialchars(urldecode($_GET['nombre'])); ?>" ha sido ocultado correctamente.
        <?php else: ?>
          <strong>✅ Éxito:</strong> El atleta ha sido creado correctamente.
        <?php endif; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>⚠️ Error:</strong> 
        <?php 
          switch($_GET['error']) {
            case 'invalid_request':
              echo 'Petición inválida. La acción debe confirmarse correctamente.';
              break;
            case 'missing_id':
              echo 'No se especificó el atleta a ocultar.';
              break;
            case 'not_authorized':
            case 'atleta_no_autorizado':
              echo 'No tienes permisos para realizar esta acción.';
              break;
            case 'not_found':
              echo 'El atleta especificado no existe.';
              break;
            case 'delete_failed':
            case 'hide_failed':
              echo 'No se pudo ocultar el atleta. Inténtalo nuevamente.';
              break;
            default:
              echo 'Ha ocurrido un error inesperado.';
          }
        ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    
    <div class="card">
      <div class="card-header" style="background: linear-gradient(135deg, var(--color-azul) 0%, #0056b3 100%); color: white;">
        
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">👤 Atleta</th>
                <th scope="col">📅 Edad</th>
                <th scope="col">⚧️ Sexo</th>
                <th scope="col">🆔 DNI</th>
                <th scope="col">📏 Medidas</th>
                <th scope="col">👨‍💼 Evaluador</th>
                <th scope="col">🎯 Lateralidad</th>
                <th scope="col" class="text-center" style="min-width: 220px;">⚙️ Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($atletas as $a): ?>
                <?php 
                  $edad = date_diff(date_create($a['fecha_nacimiento']), date_create('today'))->y;
                  $imc = 0;
                  if ($a['altura_cm'] > 0 && $a['peso_kg'] > 0) {
                    $alturaM = $a['altura_cm'] / 100;
                    $imc = $a['peso_kg'] / ($alturaM * $alturaM);
                  }
                ?>
                <tr>
                  <td>
                    <div>
                      <strong><?php echo htmlspecialchars($a['nombre'] . ' ' . $a['apellido']); ?></strong>
                      <br>
                      <small class="text-muted">
                        Registrado: 
                        <?php 
                          if (isset($a['fecha_registro']) && $a['fecha_registro']) {
                            echo date('d/m/Y', strtotime($a['fecha_registro']));
                          } else {
                            echo 'Fecha no disponible';
                          }
                        ?>
                      </small>
                    </div>
                  </td>
                  <td>
                    <span class="badge badge-info"><?php echo $edad; ?> años</span>
                    <br>
                    <small class="text-muted">
                        <?php 
                        if (!empty($a['fecha_nacimiento'])) {
                            echo date('d/m/Y', strtotime($a['fecha_nacimiento']));
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </small>
                  </td>
                  <td>
                    <?php 
                      $sexoIcon = $a['sexo'] === 'M' ? '👨' : ($a['sexo'] === 'F' ? '👩' : '⚧️');
                      $sexoText = $a['sexo'] === 'M' ? 'Masculino' : ($a['sexo'] === 'F' ? 'Femenino' : 'Otro');
                    ?>
                    <span class="badge badge-secondary">
                      <?php echo $sexoIcon . ' ' . $sexoText; ?>
                    </span>
                  </td>
                  <td>
                    <code><?php echo htmlspecialchars($a['dni']); ?></code>
                  </td>
                  <td>
                    <small class="text-muted">
                      <strong>Altura:</strong> <?php echo $a['altura_cm']; ?> cm<br>
                      <strong>Peso:</strong> <?php echo $a['peso_kg']; ?> kg<br>
                      <?php if ($imc > 0): ?>
                        <strong>IMC:</strong> 
                        <span class="badge badge-<?php 
                          echo $imc < 18.5 ? 'warning' : ($imc < 25 ? 'success' : ($imc < 30 ? 'warning' : 'danger')); 
                        ?>">
                          <?php echo number_format($imc, 1); ?>
                        </span>
                      <?php endif; ?>
                    </small>
                  </td>
                  <td>
                    <small class="text-muted">
                      <?php if (!empty($a['evaluador_nombre'])): ?>
                        <strong><?php echo htmlspecialchars($a['evaluador_nombre']); ?></strong><br>
                        <span class="text-muted"><?php echo htmlspecialchars($a['evaluador_email']); ?></span>
                      <?php else: ?>
                        <span class="text-warning">Sin evaluador asignado</span>
                      <?php endif; ?>
                    </small>
                  </td>
                  <td>
                    <small class="text-muted">
                      <?php 
                      // Convertir formato de BD a formato de visualización más amigable
                      $visual = $a['lateralidad_visual'] ?? '';
                      $podal = $a['lateralidad_podal'] ?? '';
                      
                      // Conversión visual
                      if ($visual === 'Derecho') $visual = 'Derecha';
                      if ($visual === 'Izquierdo') $visual = 'Izquierda';
                      if ($visual === 'Ambidiestro') $visual = 'Ambas';
                      
                      // Conversión podal
                      if ($podal === 'Derecho') $podal = 'Derecha';
                      if ($podal === 'Izquierdo') $podal = 'Izquierda';
                      if ($podal === 'Ambidiestro') $podal = 'Ambas';
                      ?>
                      <strong>👁️ Visual:</strong> <?php echo htmlspecialchars($visual); ?><br>
                      <strong>🦶 Podal:</strong> <?php echo htmlspecialchars($podal); ?>
                    </small>
                  </td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm d-flex flex-wrap justify-content-center" role="group" aria-label="Acciones del atleta">
                      <a href="index.php?controller=Evaluacion&action=nueva&atleta_id=<?php echo $a['id']; ?>" 
                         class="btn btn-success btn-sm mb-1" title="Nueva Evaluación">
                        <i class="fas fa-plus-circle"></i> Evaluar
                      </a>
                      <a href="index.php?controller=Atleta&action=historial&id=<?php echo $a['id']; ?>" 
                         class="btn btn-primary btn-sm mb-1" title="Ver Historial">
                        <i class="fas fa-history"></i> Historial
                      </a>
                      <a href="index.php?controller=Atleta&action=editar&id=<?php echo $a['id']; ?>" 
                         class="btn btn-warning btn-sm mb-1" title="Editar Atleta">
                        <i class="fas fa-edit"></i> Editar
                      </a>
                      <?php if ($campoActivoExiste): ?>
                        <button type="button" class="btn btn-warning btn-sm mb-1" 
                                title="Ocultar Atleta"
                                onclick="confirmarOcultacion(<?php echo $a['id']; ?>, '<?php echo htmlspecialchars($a['nombre'] . ' ' . $a['apellido']); ?>')">
                          <i class="fas fa-eye-slash"></i> Ocultar
                        </button>
                      <?php else: ?>
                        <span class="btn btn-secondary btn-sm mb-1 disabled" title="Ejecute la migración para habilitar">
                          <i class="fas fa-database"></i> Migración Requerida
                        </span>
                      <?php endif; ?>
                    </div>
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
              <i class="fas fa-info-circle"></i> 
              Total de atletas registrados: <strong><?php echo count($atletas); ?></strong>
            </small>
          </div>
          <div class="col-md-6 text-right">
            <small>
              <i class="fas fa-clock"></i> 
              Última actualización: <?php echo date('d/m/Y H:i'); ?>
            </small>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<style>
.table td {
  vertical-align: middle;
}

.btn-group .btn {
  margin: 2px;
  min-width: 80px;
  white-space: nowrap;
}

.btn-group .btn i {
  font-size: 0.875rem;
  margin-right: 4px;
}

.card-header h5 {
  display: flex;
  align-items: center;
}

/* Mejorar visibilidad de los botones */
.btn-group .btn-success {
  background-color: #28a745;
  border-color: #28a745;
  color: white;
}

.btn-group .btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  color: white;
}

.btn-group .btn-warning {
  background-color: #ffc107;
  border-color: #ffc107;
  color: #212529;
}

.btn-group .btn-warning:hover {
  background-color: #e0a800;
  border-color: #d39e00;
}

.btn-group .btn-danger {
  background-color: #dc3545;
  border-color: #dc3545;
  color: white;
}

.btn-group .btn:hover {
  transform: scale(1.02);
  transition: transform 0.2s ease;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

/* Mejorar la alineación en la columna de acciones */
.btn-group.d-flex {
  gap: 4px;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
}

@media (max-width: 768px) {
  .table-responsive {
    font-size: 0.875rem;
  }
  
  .btn-group {
    flex-direction: column;
    width: 100%;
    gap: 2px;
  }
  
  .btn-group .btn {
    margin: 1px 0;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    min-width: 70px;
  }
  
  .btn-group .btn i {
    font-size: 0.75rem;
    margin-right: 2px;
  }
}

/* Asegurar que la columna de acciones tenga suficiente ancho */
th:last-child, td:last-child {
  min-width: 200px;
}
</style>

<script>
function confirmarOcultacion(atletaId, nombreAtleta) {
  if (confirm('👁️ ¿Estás seguro de que deseas ocultar al atleta "' + nombreAtleta + '"?\n\n🔍 Esta acción:\n• Ocultará al atleta del listado principal\n• Conservará todos sus datos y historial\n• Puede ser revertida si es necesario\n\n✅ Sus datos permanecerán seguros en el sistema')) {
    // Crear un formulario dinámico para enviar la petición
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index.php?controller=Atleta&action=eliminar';
    form.style.display = 'none';
    
    var inputId = document.createElement('input');
    inputId.type = 'hidden';
    inputId.name = 'id';
    inputId.value = atletaId;
    form.appendChild(inputId);
    
    var inputConfirm = document.createElement('input');
    inputConfirm.type = 'hidden';
    inputConfirm.name = 'confirmar';
    inputConfirm.value = '1';
    form.appendChild(inputConfirm);
    
    document.body.appendChild(form);
    form.submit();
  }
}

// Mejorar la experiencia visual de los botones
document.addEventListener('DOMContentLoaded', function() {
  // Inicializar tooltips de Bootstrap si está disponible
  if (typeof $('[data-toggle="tooltip"]').tooltip === 'function') {
    $('[data-toggle="tooltip"]').tooltip();
  }
  
  // Agregar tooltips personalizados
  const botones = document.querySelectorAll('.btn-group .btn');
  botones.forEach(function(btn) {
    // Mejorar los títulos de los tooltips
    const title = btn.getAttribute('title');
    if (title) {
      btn.setAttribute('data-toggle', 'tooltip');
      btn.setAttribute('data-placement', 'top');
      
      // Personalizar mensajes según el tipo de botón
      if (btn.classList.contains('btn-success')) {
        btn.setAttribute('title', '✅ Nueva Evaluación - Crear evaluación completa');
      } else if (btn.classList.contains('btn-primary')) {
        btn.setAttribute('title', '📊 Ver Historial - Resultados anteriores');
      } else if (btn.classList.contains('btn-warning') && btn.textContent.includes('Editar')) {
        btn.setAttribute('title', '✏️ Editar Atleta - Modificar datos');
      } else if (btn.classList.contains('btn-warning') && btn.textContent.includes('Ocultar')) {
        btn.setAttribute('title', '👁️ Ocultar Atleta - Remover del listado');
      } else if (btn.classList.contains('btn-danger')) {
        btn.setAttribute('title', '🗑️ Eliminar - Borrar permanentemente');
      }
    }
  });
  
  // Agregar efectos hover mejorados
  botones.forEach(function(btn) {
    btn.addEventListener('mouseenter', function() {
      this.style.transform = 'scale(1.05)';
      this.style.transition = 'transform 0.2s ease';
      this.style.zIndex = '10';
    });
    
    btn.addEventListener('mouseleave', function() {
      this.style.transform = 'scale(1)';
      this.style.zIndex = '1';
    });
  });
  
  // Verificar que todos los botones estén visibles
  console.log('Botones de acción cargados:', botones.length);
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
