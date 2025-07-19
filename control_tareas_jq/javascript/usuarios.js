document.addEventListener('DOMContentLoaded', function () {
    const btnsEditar = document.querySelectorAll('.btnEditar');
    const modal = new bootstrap.Modal(document.getElementById('usuarioModal'));
    const modalTitle = document.getElementById('usuarioModalLabel');
    const form = document.getElementById('formUsuario');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm');

    //cargar usuarios al inicio
    cargarUsuarios();

    //delegar evento editar
    $(document).on('click', '.btnEditar', function () {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const fecha = $(this).data('fecha');
        const email = $(this).data('email');

        modalTitle.textContent = 'Editar Usuario';

        $('#usuarioIndex').val(id);
        $('#nombre').val(nombre);
        $('#fecha_nam').val(fecha);
        $('#email').val(email);

        $('#password').val('');
        $('#confirm').val('');

        passwordInput.removeAttribute('required');
        confirmInput.removeAttribute('required');

        modal.show();
    });


    //Limpiar formulario del modal al cerrarlo, para el uso de agregar
    $('#usuarioModal').on('hidden.bs.modal', () => {
        form.reset();
        $('#usuarioIndex').val('');
        modalTitle.textContent = 'Agregar usuario';
        passwordInput.setAttribute('required');
        confirmInput.setAttribute('required');
    });

    //Guardar Usuario AJAX
    $('#formUsuario').on('submit', function (e) {
        e.preventDefault();

        const datos = $(this).serialize();

        $.post('procesar_usuario.php', datos, function (respuesta) {
            const alerta = `<div class="alert alert-info alert-dismissible fade show" role="alert">
                ${respuesta}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>`;

            $('.modal-body').prepend(alerta);

            setTimeout(() =>{
                modal.hide();
                cargarUsuarios();
            }, 2500);
        });
    });

    //Eliminar usuario con AJAXEs
    $(document).on('click', '.btnEliminar', function (e){
        e.preventDefault();
        if(!confirm('¿Está seguro de eliminar este usuario?')) return;
        const id = $(this).data('id');

        $.get(`procesar_usuario.php?eliminar=${id}`, function(respuesta){
            alert(respuesta);
            cargarUsuarios();
        });
    });

    //Carga la lista completa de usuarios
    function cargarUsuarios() {
        $.get('obtener_usuarios.php', function (data) {
            $('#tablaUsuarios tbody').html(data);
        });
    }

});