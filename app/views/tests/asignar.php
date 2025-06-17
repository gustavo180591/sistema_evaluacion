<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="max-width: 700px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
  <h2 style="color: #004080; text-align: center;">Asignar Test</h2>

  <form method="POST" action="index.php?controller=Test&action=registrar" class="needs-validation" novalidate>
    <label>Atleta</label>
    <select name="atleta_id" required>
      <option value="">Seleccionar</option>
      <?php foreach ($atletas as $a): ?>
        <option value="<?php echo $a['id']; ?>"><?php echo $a['apellido'] . ', ' . $a['nombre']; ?></option>
      <?php endforeach; ?>
    </select>

    <label>Test</label>
    <select name="test_id" required>
      <option value="">Seleccionar</option>
      <?php foreach ($tests as $t): ?>
        <option value="<?php echo $t['id']; ?>"><?php echo $t['nombre_test']; ?></option>
      <?php endforeach; ?>
    </select>

    <label>Lugar</label>
    <select name="lugar_id" required>
      <option value="">Seleccionar</option>
      <?php foreach ($lugares as $l): ?>
        <option value="<?php echo $l['id']; ?>"><?php echo $l['nombre']; ?></option>
      <?php endforeach; ?>
    </select>

    <label>Fecha</label>
    <input type="date" name="fecha_test" value="<?php echo date('Y-m-d'); ?>" required>

    <label>Resultado (JSON)</label>
    <textarea name="resultado" rows="6" placeholder='{"mano_derecha": 32.5, "mano_izquierda": 31.8}' required></textarea>

    <input type="hidden" name="evaluador_id" value="<?php echo $_SESSION['usuario_id']; ?>">

    <button type="submit">Registrar resultado</button>
  </form>
</div>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>