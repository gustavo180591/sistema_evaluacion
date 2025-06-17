<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="max-width: 400px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
  <h2 style="color: #004080; text-align: center;">Iniciar sesión</h2>

  <?php if (!empty($_SESSION['error'])): ?>
    <div style="color: #e53935; margin-bottom: 15px;">
      <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="index.php?controller=Auth&action=login" class="needs-validation" novalidate>
    <label for="email">Correo electrónico</label>
    <input type="email" name="email" required>

    <label for="password">Contraseña</label>
    <input type="password" name="password" required>

    <button type="submit">Ingresar</button>
  </form>
</div>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
