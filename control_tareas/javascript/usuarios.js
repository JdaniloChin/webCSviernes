document.addEventListener('DOMContentLoaded', function () {
  const btnsEditar = document.querySelectorAll('.btnEditar');
  const modal = new bootstrap.Modal(document.getElementById('usuarioModal'));
  const modalTitle = document.getElementById('usuarioModalLabel');
  const form = document.getElementById('formUsuario');

  btnsEditar.forEach(btn => {
    btn.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      const nombre = this.getAttribute('data-nombre');
      const fecha = this.getAttribute('data-fecha');
      const email = this.getAttribute('data-email');

      // Cambiar título del modal
      modalTitle.textContent = 'Editar Usuario';

      // Precargar datos en el formulario
      document.getElementById('usuarioIndex').value = id;
      document.getElementById('nombre').value = nombre;
      document.getElementById('fecha_nam').value = fecha;
      document.getElementById('email').value = email;

      // Contraseña queda en blanco por seguridad
      document.getElementById('password').value = '';
      document.getElementById('confirm').value = '';

      // Quitar required para edición
      passwordInput.removeAttribute('required');
      confirmInput.removeAttribute('required');
    });
  });

  // Limpiar modal al cerrarlo para uso de "Agregar"
  document.getElementById('usuarioModal').addEventListener('hidden.bs.modal', () => {
    form.reset();
    document.getElementById('usuarioIndex').value = '';
    modalTitle.textContent = 'Agregar Usuario';
  });
});