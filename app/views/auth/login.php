<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="max-width: 400px; margin: 50px auto; padding: 30px;">
  <div class="card" style="border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <div class="card-body">
      <h2 class="text-center mb-4" style="color: #004080;">Iniciar sesión</h2>

      <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger" style="margin-bottom: 15px;">
          <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" style="margin-bottom: 15px;">
          <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="index.php?controller=Auth&action=login" class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="email" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" name="email" required>
        </div>

       <!--  <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" class="form-control" name="password" required>
        </div> -->
        <div class="mb-3">
  <label for="password" class="form-label">Contraseña</label>
  <div class="input-group">
    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
    <span class="input-group-text">
      <input type="checkbox" id="togglePassword" title="Mostrar contraseña">
    </span>
  </div>
  <small class="form-text text-muted">Mostrar contraseña</small>
</div>

        <!-- <div>
    <input type="password" id="password" name="password" placeholder="Contraseña">
    <input type="checkbox" id="togglePassword"> Mostrar contraseña
  </div> -->

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Ingresar</button>
        </div>
      </form>

      <hr class="my-4">
      
      <div class="text-center">
        <a href="index.php?controller=Auth&action=register" class="text-decoration-none">
          ¿No tienes cuenta? Regístrate aquí
        </a>
      </div>
    </div>
  </div>
</div>
<script>
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#password');

  togglePassword.addEventListener('change', function (e) {
    // Alternar el tipo de input entre 'password' y 'text'
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
  });
</script>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
