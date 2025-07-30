<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container">
  <div class="text-center mb-3">
    <h1>Panel del Evaluador</h1>
    <p class="text-muted">Gestiona tus atletas y evaluaciones de forma eficiente</p>
  </div>

  <div class="dashboard-grid">
    <!-- Gestión de Atletas -->
    <div class="dashboard-card">
      <div class="icon">👥</div>
      <h3>Gestión de Atletas</h3>
      <p>Administra la información de tus atletas asignados</p>
      <div class="mt-2">
        <a href="index.php?controller=Atleta&action=listado" class="btn btn-primary">Ver Atletas</a>
        <a href="index.php?controller=Atleta&action=crear" class="btn btn-success">+ Nuevo</a>
      </div>
    </div>

    <!-- Nueva Evaluación -->
    <div class="dashboard-card">
      <div class="icon">📋</div>
      <h3>Nueva Evaluación</h3>
      <p>Crea una nueva sesión de evaluación completa</p>
      <div class="mt-2">
        <a href="index.php?controller=Test&action=nuevaEvaluacion" class="btn btn-success">➕ Crear Evaluación</a>
      </div>
    </div>

    <!-- Ver Evaluaciones -->
    <div class="dashboard-card">
      <div class="icon">📊</div>
      <h3>Mis Evaluaciones</h3>
      <p>Revisa y gestiona las evaluaciones realizadas</p>
      <div class="mt-2">
        <a href="index.php?controller=Test&action=resultados" class="btn btn-primary">Ver Evaluaciones</a>
      </div>
    </div>

    <!-- Tests Disponibles -->
    <div class="dashboard-card">
      <div class="icon">🏃</div>
      <h3>Catálogo de Tests</h3>
      <p>Consulta el catálogo de tests físicos disponibles</p>
      <div class="mt-2">
        <a href="index.php?controller=Test&action=catalogo" class="btn btn-primary">Ver Catálogo</a>
      </div>
    </div>

    <!-- Reportes -->
    <div class="dashboard-card">
      <div class="icon">📈</div>
      <h3>Reportes y Análisis</h3>
      <p>Visualiza estadísticas y progreso de atletas</p>
      <div class="mt-2">
        <a href="index.php?controller=Reporte&action=estadisticas" class="btn btn-primary">Estadísticas</a>
        <a href="index.php?controller=Reporte&action=exportar" class="btn btn-success">Exportar</a>
      </div>
    </div>

    <!-- Test Individual (Método Anterior) -->
    <div class="dashboard-card">
      <div class="icon">⚡</div>
      <h3>Test Rápido</h3>
      <p>Registra un test individual fuera de evaluación</p>
      <div class="mt-2">
        <a href="index.php?controller=Test&action=asignar" class="btn btn-warning">Test Individual</a>
      </div>
    </div>
  </div>

  
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
