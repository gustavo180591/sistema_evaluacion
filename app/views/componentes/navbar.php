<?php
session_start();
$usuario_rol = $_SESSION['rol'] ?? null;
$usuario_id = $_SESSION['usuario_id'] ?? null;
?>

<nav class="navbar">
  <div class="logo">
    <a href="index.php?controller=Dashboard" style="color: white; font-weight: bold;">🏛 Sistema de Captación</a>
  </div>
  <div class="nav-items">
    <?php if ($usuario_id): ?>
      <span style="margin-right: 20px;">👤 <?php echo strtoupper($usuario_rol); ?></span>
      <a href="index.php?controller=Auth&action=logout"><button style="background-color: #E53935;">Cerrar sesión</button></a>
    <?php endif; ?>
  </div>
</nav>
