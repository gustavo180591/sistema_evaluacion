<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="max-width: 700px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
  <h2 style="color: #004080; text-align: center;">Nuevo Atleta</h2>

  <form method="POST" action="index.php?controller=Atleta&action=crear" class="needs-validation" novalidate>
    <label>Nombre</label>
    <input type="text" name="nombre" required>

    <label>Apellido</label>
    <input type="text" name="apellido" required>

    <label>DNI</label>
    <input type="text" name="dni" required>

    <label>Sexo</label>
    <select name="sexo" required>
      <option value="">Seleccionar</option>
      <option value="M">Masculino</option>
      <option value="F">Femenino</option>
      <option value="Otro">Otro</option>
    </select>

    <label>Fecha de nacimiento</label>
    <input type="date" name="fecha_nacimiento" required>

    <label>Altura (cm)</label>
    <input type="number" name="altura_cm" step="0.01" required>

    <label>Peso (kg)</label>
    <input type="number" name="peso_kg" step="0.01" required>

    <label>Envergadura (cm)</label>
    <input type="number" name="envergadura_cm" step="0.01" required>

    <label>Altura sentado (cm)</label>
    <input type="number" name="altura_sentado_cm" step="0.01" required>

    <label>Lateralidad visual</label>
    <select name="lateralidad_visual" required>
      <option value="">Seleccionar</option>
      <option value="Izquierdo">Izquierdo</option>
      <option value="Derecho">Derecho</option>
      <option value="Ambidiestro">Ambidiestro</option>
    </select>

    <label>Lateralidad podal</label>
    <select name="lateralidad_podal" required>
      <option value="">Seleccionar</option>
      <option value="Izquierdo">Izquierdo</option>
      <option value="Derecho">Derecho</option>
      <option value="Ambidiestro">Ambidiestro</option>
    </select>

    <button type="submit">Guardar atleta</button>
  </form>
</div>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
