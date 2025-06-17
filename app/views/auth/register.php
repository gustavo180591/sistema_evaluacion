<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="max-width: 500px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
  <h2 style="color: #004080; text-align: center;">Registro de Evaluador</h2>

  <form method="POST" action="index.php?controller=Auth&action=register" class="needs-validation" novalidate>
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required>

    <label for="apellido">Apellido</label>
    <input type="text" name="apellido" required>

    <label for="email">Correo electrónico</label>
    <input type="email" name="email" required>

    <label for="password">Contraseña</label>
    <input type="password" name="password" required>

    <button type="submit">Registrarse</button>
  </form>
</div>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
