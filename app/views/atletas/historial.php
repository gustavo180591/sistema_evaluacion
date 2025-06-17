<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="padding: 30px;">
  <h2 style="color: #004080;">Historial de Evaluaciones de <?php echo htmlspecialchars($atleta['nombre'] . ' ' . $atleta['apellido']); ?></h2>

  <?php if (empty($resultados)): ?>
    <p>No se encontraron evaluaciones registradas.</p>
  <?php else: ?>
    <table style="width: 100%; background: #fff; border-radius: 12px; padding: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
      <thead>
        <tr style="background: #f1f1f1;">
          <th>Fecha</th>
          <th>Test</th>
          <th>Lugar</th>
          <th>Resultado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($resultados as $r): ?>
          <tr>
            <td><?php echo htmlspecialchars($r['fecha_test']); ?></td>
            <td><?php echo htmlspecialchars($r['nombre_test']); ?></td>
            <td><?php echo htmlspecialchars($r['lugar']); ?></td>
            <td>
              <pre style="white-space: pre-wrap; font-size: 0.9em;"><?php echo json_encode(json_decode($r['resultado_json']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
