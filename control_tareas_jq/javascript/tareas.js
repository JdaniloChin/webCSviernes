$(document).ready(function() {
    // Cargar datos iniciales
    cargarTareas();
    cargarUsuarios();

    // Evento para crear nueva tarea
    $('#formTarea').on('submit', function(e) {
        e.preventDefault();
        
        const datos = $(this).serialize();
        
        $.post('procesar_tarea.php', datos)
            .done(function(respuesta) {
                mostrarAlerta(respuesta);
                $('#tareaModal').modal('hide');
                cargarTareas();
            })
            .fail(function() {
                mostrarAlerta('Error al procesar la tarea', 'danger');
            });
    });

    // Evento para abrir modal de nueva tarea
    $('#btnNuevaTarea, .btn-nueva-tarea').on('click', function() {
        const estado = $(this).data('estado') || 'backlog';
        $('#estadoTarea').val(estado);
        $('#tareaModalLabel').text('Nueva Tarea');
        $('#formTarea')[0].reset();
        $('#tareaId').val('');
        $('#estadoTarea').val(estado);
    });

    // Limpiar formulario al cerrar modal
    $('#tareaModal').on('hidden.bs.modal', function() {
        $('#formTarea')[0].reset();
        $('#tareaId').val('');
        $('#estadoTarea').val('backlog');
        $('#tareaModalLabel').text('Nueva Tarea');
    });

    // Evento para editar tarea (delegado)
    $(document).on('click', '.task-card', function(e) {
        // No abrir modal si se hizo click en el dropdown o sus elementos
        if ($(e.target).closest('.dropdown').length > 0) {
            return;
        }
        
        const id = $(this).data('id');
        const titulo = $(this).data('titulo');
        const descripcion = $(this).data('descripcion');
        const usuario = $(this).data('usuario');
        const estado = $(this).data('estado');

        $('#tareaId').val(id);
        $('#titulo').val(titulo);
        $('#descripcion').val(descripcion);
        $('#usuarioAsignado').val(usuario);
        $('#estadoTarea').val(estado);
        $('#tareaModalLabel').text('Editar Tarea');
        
        $('#tareaModal').modal('show');
    });

    // Prevenir que el dropdown abra el modal
    $(document).on('click', '.dropdown, .dropdown *', function(e) {
        e.stopPropagation();
    });

    // Función para cargar todas las tareas
    function cargarTareas() {
        $.get('obtener_tareas.php')
            .done(function(data) {
                const tareas = JSON.parse(data);
                
                // Limpiar columnas
                $('#backlog-tasks').empty();
                $('#en-proceso-tasks').empty();
                $('#completado-tasks').empty();
                
                // Distribuir tareas por estado
                tareas.forEach(function(tarea) {
                    const tareaCard = crearTareaCard(tarea);
                    
                    switch(tarea.estado) {
                        case 'backlog':
                            $('#backlog-tasks').append(tareaCard);
                            break;
                        case 'en-proceso':
                            $('#en-proceso-tasks').append(tareaCard);
                            break;
                        case 'completado':
                            $('#completado-tasks').append(tareaCard);
                            break;
                    }
                });
            })
            .fail(function() {
                mostrarAlerta('Error al cargar las tareas', 'danger');
            });
    }

    // Función para crear una tarjeta de tarea
    function crearTareaCard(tarea) {
        const descripcionCorta = tarea.descripcion ? 
            (tarea.descripcion.length > 100 ? tarea.descripcion.substring(0, 100) + '...' : tarea.descripcion) : 
            'Sin descripción';
            
        const usuarioAsignado = tarea.usuario_nombre || 'Sin asignar';
        
        return `
            <div class="task-card" 
                 data-id="${tarea.id_tarea}"
                 data-titulo="${tarea.titulo}"
                 data-descripcion="${tarea.descripcion || ''}"
                 data-usuario="${tarea.id_usuario || ''}"
                 data-estado="${tarea.estado}">
                <div class="task-title">${tarea.titulo}</div>
                <div class="task-description">${descripcionCorta}</div>
                <div class="task-meta">
                    <span>👤 ${usuarioAsignado}</span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" onclick="event.stopPropagation();">
                            Cambiar estado
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item cambiar-estado" href="#" data-id="${tarea.id_tarea}" data-estado="backlog">📋 Backlog</a></li>
                            <li><a class="dropdown-item cambiar-estado" href="#" data-id="${tarea.id_tarea}" data-estado="en-proceso">⚡ En Proceso</a></li>
                            <li><a class="dropdown-item cambiar-estado" href="#" data-id="${tarea.id_tarea}" data-estado="completado">✅ Completado</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item eliminar-tarea text-danger" href="#" data-id="${tarea.id_tarea}">🗑️ Eliminar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        `;
    }

    // Evento para cambiar estado de tarea
    $(document).on('click', '.cambiar-estado', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const id = $(this).data('id');
        const nuevoEstado = $(this).data('estado');
        
        $.post('procesar_tarea.php', {
            tareaId: id,
            estado: nuevoEstado,
            accion: 'cambiar_estado'
        })
        .done(function(respuesta) {
            mostrarAlerta(respuesta);
            cargarTareas();
        })
        .fail(function() {
            mostrarAlerta('Error al cambiar el estado de la tarea', 'danger');
        });
    });

    // Evento para eliminar tarea
    $(document).on('click', '.eliminar-tarea', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (!confirm('¿Está seguro de eliminar esta tarea?')) return;
        
        const id = $(this).data('id');
        
        $.post('procesar_tarea.php', {
            tareaId: id,
            accion: 'eliminar'
        })
        .done(function(respuesta) {
            mostrarAlerta(respuesta);
            cargarTareas();
        })
        .fail(function() {
            mostrarAlerta('Error al eliminar la tarea', 'danger');
        });
    });

    // Función para cargar usuarios en el select
    function cargarUsuarios() {
        $.get('obtener_usuarios_select.php')
            .done(function(data) {
                $('#usuarioAsignado').html('<option value="">Sin asignar</option>' + data);
            })
            .fail(function() {
                console.error('Error al cargar usuarios');
            });
    }

    // Función para mostrar alertas
    function mostrarAlerta(mensaje, tipo = null) {
        $('.alert-temporal').remove();
        
        if (!tipo) {
            if (mensaje.toLowerCase().includes('error')) {
                tipo = 'danger';
            } else if (mensaje.toLowerCase().includes('advertencia')) {
                tipo = 'warning';
            } else if (mensaje.toLowerCase().includes('correctamente') || 
                       mensaje.toLowerCase().includes('eliminad') ||
                       mensaje.toLowerCase().includes('actualiz') ||
                       mensaje.toLowerCase().includes('cread')) {
                tipo = 'success';
            } else {
                tipo = 'info';
            }
        }
        
        const alerta = `<div class="alert alert-${tipo} alert-dismissible fade show alert-temporal" role="alert">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>`;
        
        $('main').prepend(alerta);
        
        setTimeout(() => {
            $('.alert-temporal').fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    }
});
