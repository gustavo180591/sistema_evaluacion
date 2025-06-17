<?php require_once __DIR__ . '/../componentes/navbar.php'; ?>

<div class="container" style="max-width: 700px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
  <h2 style="color: #004080; text-align: center;">Resultado registrado</h2>

  <div style="text-align: center; padding: 20px;">
    <p>El resultado fue guardado correctamente.</p>
    <a href="index.php?controller=Test&action=resultados">
      <button>Ver todos los resultados</button>
    </a>
  </div>
</div>

<?php require_once __DIR__ . '/../componentes/footer.php'; ?>
