document.addEventListener('DOMContentLoaded', function () {
    const btnsEditar = document.querySelectorAll('.btnEditar');
    const modal = new bootstrap.Modal(document.getElementById('usuarioModal'));
    const modalTitle = document.getElementById('usuarioModalLabel');
    const form = document.getElementById('formUsuario');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm');

    btnsEditar.forEach(btn => {
        btn.addEventListener('click', function () {
            const id =  this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre'); 
            const fecha = this.getAttribute('data-fecha'); 
            const email = this.getAttribute('data-email'); 

            //cambiar el titulo del modal
            modalTitle.textContent = 'Editar Usuario';

            //Precargar los datos del usuario en el formulario
            document.getElementById('usuarioIndex').value = id;
            document.getElementById('nombre').value = nombre;
            document.getElementById('fecha_nam').value = fecha;
            document.getElementById('email').value = email;

            //Contraseña queda en blanco por seguridad
            document.getElementById('password').value = '';
            document.getElementById('confirm').value = '';

            //Quitar required para edicion
            passwordInput.removeAttribute('required');
            confirmInput.removeAttribute('required');

            //Mostrar el modal
            modal.show();
        })
    });

    //Limpiar formulario del modal al cerrarlo, para el uso de agregar
    document.getElementById('usuarioModal').addEventListener('hidden.bs.modal', () => {
        form.reset();
        document.getElementById('usuarioIndex').value = '';
        modalTitle.textContent = 'Agregar Usuario';

        //Restaurar required para agregar usuario
        passwordInput.setAttribute('required', '');
        confirmInput.setAttribute('required', '');
    });

});