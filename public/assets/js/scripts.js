// Navbar toggle (modo responsive)
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('#navbar-toggle');
  const menu = document.querySelector('#navbar-menu');

  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      menu.classList.toggle('active');
    });
  }

  // Validación simple de formularios
  const forms = document.querySelectorAll('form.needs-validation');
  forms.forEach(form => {
    form.addEventListener('submit', function (e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        form.classList.add('was-validated');
      }
    }, false);
  });

  // Confirmación antes de eliminar
  const deleteButtons = document.querySelectorAll('[data-confirm]');
  deleteButtons.forEach(btn => {
    btn.addEventListener('click', function (e) {
      const mensaje = btn.getAttribute('data-confirm') || '¿Estás seguro?';
      if (!confirm(mensaje)) {
        e.preventDefault();
      }
    });
  });
});
