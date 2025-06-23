<?php require_once __DIR__ . '/../layout/header.php'; ?>
<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="max-width: 500px; margin: 50px auto; padding: 30px;">
  <div class="card" style="border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <div class="card-body">
      <h2 class="text-center mb-4" style="color: #004080;">Registro de Evaluador</h2>

      <form method="POST" action="index.php?controller=Auth&action=register" class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="mb-3">
          <label for="apellido" class="form-label">Apellido</label>
          <input type="text" class="form-control" name="apellido" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
  <label for="password" class="form-label">Contraseña</label>
  <div class="input-group">
    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
    <span class="input-group-text">
      <input type="checkbox" id="togglePassword" title="Mostrar contraseña">
    </span>
  </div>
</div>

<div class="mb-3">
  <label for="password_confirm" class="form-label">Confirmar contraseña</label>
  <div class="input-group">
    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirmar contraseña" required>
    <span class="input-group-text">
      <input type="checkbox" id="togglePasswordConfirm" title="Mostrar contraseña">
    </span>
  </div>
</div>


        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Registrarse</button>
        </div>
      </form>

      <hr class="my-4">
      
      <div class="text-center">
        <a href="index.php?controller=Auth&action=login" class="text-decoration-none">
          ¿Ya tienes cuenta? Inicia sesión aquí
        </a>
      </div>
    </div>
  </div>
</div>
<script>
  document.getElementById('togglePassword').addEventListener('change', function () {
    const password = document.getElementById('password');
    password.type = this.checked ? 'text' : 'password';
  });

  document.getElementById('togglePasswordConfirm').addEventListener('change', function () {
    const confirm = document.getElementById('password_confirm');
    confirm.type = this.checked ? 'text' : 'password';
  });
</script>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>
