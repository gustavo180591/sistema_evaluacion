<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="padding: 30px;">
  <h2 style="color: #004080;">Panel del Evaluador</h2>

  <div class="card-grid">
    <div class="card">
      <h3>Mis atletas</h3>
      <p>Gestioná los atletas asignados.</p>
      <a href="index.php?controller=Atleta&action=listado"><button>Ver atletas</button></a>
    </div>
    <div class="card">
      <h3>Asignar pruebas</h3>
      <p>Seleccioná atletas y registrá tests.</p>
      <a href="index.php?controller=Test&action=asignar"><button>Asignar</button></a>
    </div>
    <div class="card">
      <h3>Resultados</h3>
      <p>Visualizá resultados previos de evaluaciones.</p>
      <a href="index.php?controller=Test&action=resultados"><button>Ver resultados</button></a>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
