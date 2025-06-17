<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="padding: 30px;">
  <h2 style="color: #004080;">Mis Atletas</h2>

  <a href="index.php?controller=Atleta&action=crear">
    <button style="margin-bottom: 20px;">+ Nuevo Atleta</button>
  </a>

  <table style="width: 100%; background: #fff; border-radius: 12px; padding: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <thead>
      <tr style="background: #f1f1f1;">
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Edad</th>
        <th>Sexo</th>
        <th>DNI</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($atletas as $a): ?>
        <tr>
          <td><?php echo htmlspecialchars($a['nombre']); ?></td>
          <td><?php echo htmlspecialchars($a['apellido']); ?></td>
          <td><?php echo date_diff(date_create($a['fecha_nacimiento']), date_create('today'))->y; ?> años</td>
          <td><?php echo htmlspecialchars($a['sexo']); ?></td>
          <td><?php echo htmlspecialchars($a['dni']); ?></td>
          <td>
            <a href="index.php?controller=Atleta&action=historial&id=<?php echo $a['id']; ?>">
              <button>Historial</button>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
