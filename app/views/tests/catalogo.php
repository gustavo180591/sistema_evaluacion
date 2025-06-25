<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container-fluid" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh; padding: 32px 0;">
  <div class="container">

    <!-- TÍTULO CATÁLOGO -->
    <div class="row mb-4">
      <div class="col-12 text-center">
        <h1 class="display-4 mb-2" style="color: #2c3e50; font-weight: 700;">
          🏃‍♂️ Catálogo de Tests
        </h1>
        <p class="lead text-muted mb-0">Tests físicos disponibles para evaluaciones deportivas</p>
      </div>
    </div>

    <!-- CARDS DE TESTS SEPARADOS -->
    <div class="row justify-content-center g-4">

      <!-- Test de Fuerza de Agarre -->
      <div class="col-md-6 col-lg-4 d-flex">
        <div class="card shadow h-100 border-0 test-card">
          <div class="card-header bg-primary text-white test-card-header">
            <div class="d-flex align-items-center">
              <span class="test-icon rounded-circle d-flex align-items-center justify-content-center me-3">💪</span>
              <h5 class="mb-0 flex-grow-1">Test de Fuerza de Agarre</h5>
            </div>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="card-text text-muted flex-grow-1">Evalúa la fuerza isométrica de los músculos de la mano y antebrazo.</p>
            <div class="mb-3">
              <span class="badge rounded-pill badge-primary-light me-2 mb-2">Unidad: kg</span>
              <span class="badge rounded-pill badge-primary-light me-2 mb-2">Duración: 5-10 min</span>
            </div>
            <button class="btn btn-outline-primary w-100 mt-auto">Ver Detalles</button>
          </div>
        </div>
      </div>

      <!-- Test de Salto Vertical -->
      <div class="col-md-6 col-lg-4 d-flex">
        <div class="card shadow h-100 border-0 test-card">
          <div class="card-header bg-success text-white test-card-header">
            <div class="d-flex align-items-center">
              <span class="test-icon rounded-circle d-flex align-items-center justify-content-center me-3">⬆️</span>
              <h5 class="mb-0 flex-grow-1">Test de Salto Vertical</h5>
            </div>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="card-text text-muted flex-grow-1">Mide la potencia de las extremidades inferiores mediante salto vertical.</p>
            <div class="mb-3">
              <span class="badge rounded-pill badge-success-light me-2 mb-2">Unidad: cm</span>
              <span class="badge rounded-pill badge-success-light me-2 mb-2">Duración: 5 min</span>
            </div>
            <button class="btn btn-outline-success w-100 mt-auto">Ver Detalles</button>
          </div>
        </div>
      </div>

      <!-- Test de Salto de Longitud -->
      <div class="col-md-6 col-lg-4 d-flex">
        <div class="card shadow h-100 border-0 test-card">
          <div class="card-header text-white test-card-header" style="background-color: #6f42c1;">
            <div class="d-flex align-items-center">
              <span class="test-icon rounded-circle d-flex align-items-center justify-content-center me-3">🦘</span>
              <h5 class="mb-0 flex-grow-1">Test de Salto de Longitud</h5>
            </div>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="card-text text-muted flex-grow-1">Mide la máxima distancia horizontal saltada desde posición estática.</p>
            <div class="mb-3">
              <span class="badge rounded-pill badge-purple-light me-2 mb-2">Unidad: metros</span>
              <span class="badge rounded-pill badge-purple-light me-2 mb-2">Potencia Horizontal</span>
            </div>
            <button class="btn btn-outline-secondary w-100 mt-auto">Ver Detalles</button>
          </div>
        </div>
      </div>

      <!-- Test de Wells -->
      <div class="col-md-6 col-lg-4 d-flex">
        <div class="card shadow h-100 border-0 test-card">
          <div class="card-header bg-info text-white test-card-header">
            <div class="d-flex align-items-center">
              <span class="test-icon rounded-circle d-flex align-items-center justify-content-center me-3">🧘</span>
              <h5 class="mb-0 flex-grow-1">Test de Wells</h5>
            </div>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="card-text text-muted flex-grow-1">Evalúa la flexibilidad de isquiotibiales y zona lumbar.</p>
            <div class="mb-3">
              <span class="badge rounded-pill badge-info-light me-2 mb-2">Unidad: cm</span>
              <span class="badge rounded-pill badge-info-light me-2 mb-2">Flexibilidad</span>
            </div>
            <button class="btn btn-outline-info w-100 mt-auto">Ver Detalles</button>
          </div>
        </div>
      </div>

      <!-- Test de Velocidad 20m -->
      <div class="col-md-6 col-lg-4 d-flex">
        <div class="card shadow h-100 border-0 test-card">
          <div class="card-header bg-danger text-white test-card-header">
            <div class="d-flex align-items-center">
              <span class="test-icon rounded-circle d-flex align-items-center justify-content-center me-3">⚡</span>
              <h5 class="mb-0 flex-grow-1">Test de Velocidad 20m</h5>
            </div>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="card-text text-muted flex-grow-1">Mide la velocidad máxima en 20 metros desde salida estática.</p>
            <div class="mb-3">
              <span class="badge rounded-pill badge-danger-light me-2 mb-2">Unidad: segundos</span>
              <span class="badge rounded-pill badge-danger-light me-2 mb-2">Velocidad</span>
            </div>
            <button class="btn btn-outline-danger w-100 mt-auto">Ver Detalles</button>
          </div>
        </div>
      </div>

      <!-- Test de Preferencia Motriz -->
      <div class="col-md-6 col-lg-4 d-flex">
        <div class="card shadow h-100 border-0 test-card">
          <div class="card-header bg-warning text-dark test-card-header">
            <div class="d-flex align-items-center">
              <span class="test-icon rounded-circle d-flex align-items-center justify-content-center me-3">🦶</span>
              <h5 class="mb-0 flex-grow-1">Test de Preferencia Motriz</h5>
            </div>
          </div>
          <div class="card-body d-flex flex-column">
            <p class="card-text text-muted flex-grow-1">Determina el lado dominante (mano, ojo, pie) en tareas motoras.</p>
            <div class="mb-3">
              <span class="badge rounded-pill badge-warning-light me-2 mb-2">Preferencia Visual</span>
              <span class="badge rounded-pill badge-warning-light me-2 mb-2">Preferencia Podal</span>
            </div>
            <button class="btn btn-outline-warning w-100 mt-auto">Ver Detalles</button>
          </div>
        </div>
      </div>

    </div> <!-- END ROW -->

  </div>
</div>

<style>
.test-card {
  border-radius: 15px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.test-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.test-card-header {
  border-radius: 15px 15px 0 0;
  min-height: 80px;
  padding: 1.25rem;
}

.test-icon {
  width: 50px;
  height: 50px;
  font-size: 1.8rem;
  background: rgba(255,255,255,0.25);
  border: 2px solid rgba(255,255,255,0.3);
}

.badge.rounded-pill {
  font-size: 0.85rem;
  padding: 0.5em 1em;
  font-weight: 500;
}

.badge-primary-light {
  background: #e7f3ff;
  color: #0d6efd;
  border: 1px solid #b6d7ff;
}

.badge-success-light {
  background: #e8f5e8;
  color: #198754;
  border: 1px solid #b3e5b3;
}

.badge-purple-light {
  background: #f3e6ff;
  color: #6f42c1;
  border: 1px solid #d6b3ff;
}

.badge-info-light {
  background: #e6f7ff;
  color: #0dcaf0;
  border: 1px solid #b3ecff;
}

.badge-danger-light {
  background: #ffebee;
  color: #dc3545;
  border: 1px solid #ffb3ba;
}

.badge-warning-light {
  background: #fff8e1;
  color: #fd7e14;
  border: 1px solid #ffe0a3;
}

.btn:hover {
  transform: none;
}

/* Responsive improvements */
@media (max-width: 768px) {
  .container-fluid {
    padding: 20px 0;
  }
  
  .test-card-header {
    min-height: 70px;
    padding: 1rem;
  }
  
  .test-icon {
    width: 45px;
    height: 45px;
    font-size: 1.6rem;
  }
  
  .badge.rounded-pill {
    font-size: 0.8rem;
    padding: 0.4em 0.8em;
  }
  
  .card-title {
    font-size: 1.1rem;
  }
}

@media (max-width: 576px) {
  .test-card-header h5 {
    font-size: 1rem;
  }
  
  .test-icon {
    width: 40px;
    height: 40px;
    font-size: 1.4rem;
  }
  
  .card-text {
    font-size: 0.9rem;
  }
}
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
