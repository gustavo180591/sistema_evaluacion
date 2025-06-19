<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh; padding: 20px 0;">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="display-4 mb-2" style="color: #2c3e50; font-weight: 700;">
          🏃‍♂️ Catálogo de Tests
        </h1>
        <p class="lead text-muted mb-0">Tests físicos disponibles para evaluaciones deportivas</p>
      </div>
      <div>
        <a href="index.php?controller=Dashboard&action=index" class="btn btn-outline-secondary btn-lg">
          <i class="fas fa-arrow-left"></i> Volver al Dashboard
        </a>
      </div>
    </div>

    <?php if (empty($tests)): ?>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow-lg border-0" style="border-radius: 20px;">
            <div class="card-body text-center py-5">
              <div class="mb-4">
                <i class="fas fa-clipboard-list fa-4x text-muted"></i>
              </div>
              <h3 class="text-muted mb-3">No hay tests disponibles</h3>
              <p class="text-muted">Contacta al administrador para agregar tests al sistema.</p>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="row">
        <?php foreach ($tests as $index => $test): ?>
          <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
            <div class="test-card" style="
              background: white;
              border-radius: 20px;
              box-shadow: 0 8px 25px rgba(0,0,0,0.1);
              border: none;
              height: 100%;
              transition: all 0.3s ease;
              overflow: hidden;
              margin-bottom: 30px;
            " onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.15)'" 
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'">
              
              <!-- Header con gradiente dinámico -->
              <div class="card-header border-0 text-white position-relative" style="
                background: linear-gradient(135deg, 
                  <?php 
                    $colors = [
                      'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                      'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                      'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                      'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                      'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                      'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                      'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)',
                      'linear-gradient(135deg, #ff8a80 0%, #ea4c89 100%)',
                      'linear-gradient(135deg, #8fd3f4 0%, #84fab0 100%)'
                    ];
                    echo $colors[$index % count($colors)];
                  ?>
                );
                padding: 25px 20px;
                border-radius: 20px 20px 0 0;
              ">
                <div class="d-flex align-items-center">
                  <div class="test-icon" style="
                    background: rgba(255,255,255,0.2);
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-right: 15px;
                    font-size: 24px;
                  ">
                    🏃‍♂️
                  </div>
                  <div>
                    <h5 class="mb-1 font-weight-bold" style="font-size: 1.3rem;">
                      <?php echo htmlspecialchars($test['nombre_test']); ?>
                    </h5>
                    <?php if ($test['formato_test']): ?>
                      <?php $formato = json_decode($test['formato_test'], true); ?>
                      <?php if ($formato && isset($formato['tipo'])): ?>
                        <span class="badge" style="background: rgba(255,255,255,0.3); color: white; font-size: 0.8rem;">
                          <?php echo strtoupper($formato['tipo']); ?>
                        </span>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <div class="card-body d-flex flex-column" style="padding: 25px;">
                <!-- Descripción -->
                <?php if ($test['descripcion']): ?>
                  <div class="mb-4">
                    <p class="text-muted mb-0" style="line-height: 1.6; font-size: 0.95rem;">
                      <?php echo nl2br(htmlspecialchars($test['descripcion'])); ?>
                    </p>
                  </div>
                <?php else: ?>
                  <div class="mb-4">
                    <p class="text-muted mb-0 font-italic" style="line-height: 1.6; font-size: 0.95rem;">
                      Test de evaluación física disponible para realizar mediciones específicas.
                    </p>
                  </div>
                <?php endif; ?>
                
                <!-- Botón de acción -->
                <div class="mt-auto">
                  <button class="btn btn-primary btn-lg w-100" style="
                    border-radius: 12px;
                    font-weight: 600;
                    padding: 12px;
                    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
                    border: none;
                    transition: all 0.3s ease;
                  " onclick="verDetalleTest(<?php echo htmlspecialchars(json_encode($test)); ?>)"
                     onmouseover="this.style.transform='scale(1.02)'"
                     onmouseout="this.style.transform='scale(1)'">
                    <i class="fas fa-eye"></i> Ver Detalles Completos
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- Modal para ver detalle completo del test -->
<div id="modalDetalleTest" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; backdrop-filter: blur(5px);">
  <div style="
    position: absolute; 
    top: 50%; 
    left: 50%; 
    transform: translate(-50%, -50%); 
    background: white; 
    border-radius: 20px;
    max-width: 800px; 
    width: 90%; 
    max-height: 85vh; 
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    animation: modalFadeIn 0.3s ease;
  ">
    <div style="
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 25px 30px;
      border-radius: 20px 20px 0 0;
      position: sticky;
      top: 0;
      z-index: 10;
    ">
      <div class="d-flex justify-content-between align-items-center">
        <h4 id="modalTituloTest" class="mb-0 font-weight-bold"></h4>
        <button onclick="document.getElementById('modalDetalleTest').style.display='none'" 
                style="
                  background: rgba(255,255,255,0.2);
                  border: none;
                  color: white;
                  border-radius: 50%;
                  width: 40px;
                  height: 40px;
                  font-size: 18px;
                  cursor: pointer;
                  transition: all 0.3s ease;
                "
                onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                onmouseout="this.style.background='rgba(255,255,255,0.2)'">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    
    <div id="modalContenidoTest" style="padding: 30px;"></div>
    
    <div style="
      padding: 20px 30px;
      border-top: 1px solid #e9ecef;
      background: #f8f9fa;
      border-radius: 0 0 20px 20px;
      text-align: center;
    ">
      <button onclick="document.getElementById('modalDetalleTest').style.display='none'" 
              class="btn btn-secondary btn-lg" style="
                border-radius: 12px;
                padding: 12px 30px;
                font-weight: 600;
              ">
        <i class="fas fa-times"></i> Cerrar
      </button>
    </div>
  </div>
</div>

<style>
@keyframes modalFadeIn {
  from {
    opacity: 0;
    transform: translate(-50%, -60%);
  }
  to {
    opacity: 1;
    transform: translate(-50%, -50%);
  }
}

.test-card {
  position: relative;
}

.test-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
  border-radius: 20px;
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.test-card:hover::before {
  opacity: 1;
}

.campo-item {
  position: relative;
  overflow: hidden;
}

.campo-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
  transition: left 0.5s;
}

.campo-item:hover::before {
  left: 100%;
}

.instrucciones-preview {
  position: relative;
  overflow: hidden;
}

/* Scrollbar personalizado para el modal */
#modalDetalleTest div:first-child {
  scrollbar-width: thin;
  scrollbar-color: #007bff #f1f1f1;
}

#modalDetalleTest div:first-child::-webkit-scrollbar {
  width: 8px;
}

#modalDetalleTest div:first-child::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

#modalDetalleTest div:first-child::-webkit-scrollbar-thumb {
  background: #007bff;
  border-radius: 10px;
}

#modalDetalleTest div:first-child::-webkit-scrollbar-thumb:hover {
  background: #0056b3;
}

/* Responsive improvements */
@media (max-width: 768px) {
  .test-card {
    margin-bottom: 20px !important;
  }
  
  .card-header {
    padding: 20px 15px !important;
  }
  
  .card-body {
    padding: 20px 15px !important;
  }
  
  .test-icon {
    width: 40px !important;
    height: 40px !important;
    font-size: 20px !important;
    margin-right: 10px !important;
  }
  
  h5 {
    font-size: 1.1rem !important;
  }
  
  #modalDetalleTest > div {
    width: 95% !important;
    max-height: 90vh !important;
  }
}

/* Animaciones adicionales */
.btn {
  position: relative;
  overflow: hidden;
}

.btn::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: rgba(255,255,255,0.2);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.btn:active::before {
  width: 300px;
  height: 300px;
}
</style>

<script>
function verDetalleTest(test) {
  document.getElementById('modalTituloTest').innerHTML = `
    <div class="d-flex align-items-center">
      <div style="
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 24px;
      ">🏃‍♂️</div>
      <div>
        <div style="font-size: 1.5rem; font-weight: 700;">${test.nombre_test}</div>
        <small style="opacity: 0.9;">Test de Evaluación Física</small>
      </div>
    </div>
  `;
  
  let html = '';
  
  if (test.descripcion) {
    html += `
      <div class="mb-4">
        <div style="
          background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
          border-radius: 15px;
          padding: 20px;
          border-left: 5px solid #2196f3;
        ">
          <h5 style="color: #1976d2; margin-bottom: 15px;">
            <i class="fas fa-info-circle"></i> Descripción del Test
          </h5>
          <p style="margin-bottom: 0; line-height: 1.6; color: #424242;">
            ${test.descripcion.replace(/\n/g, '<br>')}
          </p>
        </div>
      </div>
    `;
  }
  
  if (test.formato_test) {
    try {
      const formato = JSON.parse(test.formato_test);
      
      if (formato.tipo) {
        html += `
          <div class="mb-4">
            <div style="
              background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
              border-radius: 15px;
              padding: 20px;
              border-left: 5px solid #9c27b0;
            ">
              <h5 style="color: #7b1fa2; margin-bottom: 15px;">
                <i class="fas fa-chart-bar"></i> Tipo de Evaluación
              </h5>
              <span class="badge badge-lg" style="
                background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
                color: white;
                font-size: 1rem;
                padding: 8px 16px;
                border-radius: 20px;
              ">
                ${formato.tipo.toUpperCase()}
              </span>
            </div>
          </div>
        `;
      }
      
      if (formato.campos && Array.isArray(formato.campos)) {
        html += `
          <div class="mb-4">
            <div style="
              background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
              border-radius: 15px;
              padding: 20px;
              border-left: 5px solid #4caf50;
            ">
              <h5 style="color: #388e3c; margin-bottom: 20px;">
                <i class="fas fa-clipboard-check"></i> Campos de Evaluación
              </h5>
              <div class="row">
        `;
        
        formato.campos.forEach((campo, index) => {
          const colClass = formato.campos.length <= 2 ? 'col-md-6' : 'col-md-4';
          html += `
            <div class="${colClass} mb-3">
              <div style="
                background: white;
                border-radius: 12px;
                padding: 15px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                border: 1px solid #e0e0e0;
                height: 100%;
              ">
                <div style="
                  background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
                  color: white;
                  padding: 8px 12px;
                  border-radius: 8px;
                  margin-bottom: 10px;
                  font-size: 0.9rem;
                  font-weight: 600;
                ">
                  ${campo.nombre}
                </div>
                
                <div style="font-size: 0.85rem; color: #666;">
                  ${campo.tipo ? `<div><strong>Tipo:</strong> ${campo.tipo}</div>` : ''}
                  ${campo.unidad ? `<div><strong>Unidad:</strong> <span class="badge badge-light">${campo.unidad}</span></div>` : ''}
                  ${campo.requerido ? `<div><span class="text-danger"><i class="fas fa-asterisk"></i> Requerido</span></div>` : ''}
                  ${campo.descripcion ? `<div style="margin-top: 8px; font-style: italic;">${campo.descripcion}</div>` : ''}
                </div>
                
                ${campo.opciones && Array.isArray(campo.opciones) ? `
                  <div style="margin-top: 10px;">
                    <small style="font-weight: 600; color: #333;">Opciones:</small>
                    <div style="margin-top: 5px;">
                      ${campo.opciones.map(opcion => `
                        <span class="badge badge-outline-secondary" style="
                          margin: 2px;
                          padding: 4px 8px;
                          font-size: 0.75rem;
                          border: 1px solid #ddd;
                          background: #f8f9fa;
                          color: #495057;
                        ">${opcion}</span>
                      `).join('')}
                    </div>
                  </div>
                ` : ''}
              </div>
            </div>
          `;
        });
        
        html += `
              </div>
            </div>
          </div>
        `;
      }
      
      if (formato.instrucciones && Array.isArray(formato.instrucciones)) {
        html += `
          <div class="mb-4">
            <div style="
              background: linear-gradient(135deg, #fff3e0 0%, #ffcc02 20%, #fff3e0 100%);
              border-radius: 15px;
              padding: 20px;
              border-left: 5px solid #ff9800;
            ">
              <h5 style="color: #f57c00; margin-bottom: 20px;">
                <i class="fas fa-list-ol"></i> Instrucciones Paso a Paso
              </h5>
              <div style="
                background: white;
                border-radius: 12px;
                padding: 20px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
              ">
                <ol style="margin-bottom: 0; padding-left: 20px;">
        `;
        
        formato.instrucciones.forEach((instruccion, index) => {
          html += `
            <li style="
              margin-bottom: 12px;
              padding: 10px;
              background: ${index % 2 === 0 ? '#f8f9fa' : '#ffffff'};
              border-radius: 8px;
              border-left: 3px solid #ff9800;
              line-height: 1.5;
            ">
              ${instruccion}
            </li>
          `;
        });
        
        html += `
                </ol>
              </div>
            </div>
          </div>
        `;
      }
      
    } catch (e) {
      html += `
        <div class="mb-4">
          <div style="
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            border-radius: 15px;
            padding: 20px;
            border-left: 5px solid #f44336;
          ">
            <h5 style="color: #d32f2f; margin-bottom: 15px;">
              <i class="fas fa-code"></i> Formato Técnico del Test
            </h5>
            <pre style="
              background: white;
              padding: 15px;
              border-radius: 8px;
              font-size: 0.85rem;
              overflow-x: auto;
              border: 1px solid #e0e0e0;
              color: #424242;
            ">${test.formato_test}</pre>
          </div>
        </div>
      `;
    }
  }
  
  if (!html) {
    html = `
      <div class="text-center py-5">
        <div style="
          background: linear-gradient(135deg, #f5f5f5 0%, #eeeeee 100%);
          border-radius: 15px;
          padding: 40px;
        ">
          <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
          <h5 class="text-muted">No hay información adicional disponible</h5>
          <p class="text-muted mb-0">Este test no tiene detalles de configuración específicos.</p>
        </div>
      </div>
    `;
  }
  
  // Agregar información adicional del sistema
  html += `
    <div style="
      background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
      border-radius: 15px;
      padding: 20px;
      margin-top: 20px;
      border: 1px solid #d0d0d0;
    ">
      <h6 style="color: #666; margin-bottom: 15px;">
        <i class="fas fa-info"></i> Información del Sistema
      </h6>
      <div class="row">
        <div class="col-md-6">
          <small style="color: #666;">
            <strong>ID del Test:</strong> #${test.id}<br>
            <strong>Estado:</strong> <span class="badge badge-success">Activo</span>
          </small>
        </div>
        <div class="col-md-6">
          <small style="color: #666;">
            <strong>Categoría:</strong> Evaluación Física<br>
            <strong>Disponible para:</strong> Todos los evaluadores
          </small>
        </div>
      </div>
    </div>
  `;
  
  document.getElementById('modalContenidoTest').innerHTML = html;
  document.getElementById('modalDetalleTest').style.display = 'block';
  
  // Agregar efecto de entrada
  setTimeout(() => {
    document.querySelector('#modalDetalleTest > div').style.animation = 'modalFadeIn 0.3s ease';
  }, 10);
}

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    const modal = document.getElementById('modalDetalleTest');
    if (modal.style.display === 'block') {
      modal.style.display = 'none';
    }
  }
});

// Cerrar modal al hacer clic fuera
document.getElementById('modalDetalleTest').addEventListener('click', function(event) {
  if (event.target === this) {
    this.style.display = 'none';
  }
});

// Mejorar la experiencia de carga
document.addEventListener('DOMContentLoaded', function() {
  // Agregar efecto de carga progresiva a las tarjetas
  const cards = document.querySelectorAll('.test-card');
  cards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
      card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, index * 100);
  });
  
  console.log(`✅ Catálogo de Tests cargado con ${cards.length} tests disponibles`);
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?> 