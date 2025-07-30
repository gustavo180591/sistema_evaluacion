<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="padding: 30px;">
  <h2 style="color: #004080;">Panel de Administrador</h2>

  <div class="card-grid">
    <div class="card">
      <h3>Usuarios</h3>
      <p>Gestión de usuarios del sistema.</p>
      <a href="index.php?controller=Admin&action=usuarios"><button>Ver usuarios</button></a>
    </div>
    <div class="card">
      <h3>Evaluadores</h3>
      <p>Administrar cuentas de evaluadores.</p>
      <a href="index.php?controller=Evaluador&action=listado"><button>Ver evaluadores</button></a>
    </div>
    <div class="card">
      <h3>Estadísticas</h3>
      <p>Revisión general de datos del sistema.</p>
      <a href="index.php?controller=Admin&action=estadisticas"><button>Ver estadísticas</button></a>
    </div>
    <div class="card">
      <h3>Tests</h3>
      <p>Gestión de tests disponibles para evaluaciones.</p>
      <a href="index.php?controller=Admin&action=tests"><button>Gestionar tests</button></a>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
