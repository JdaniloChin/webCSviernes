<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas - Kanban</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="Estilos/kanban.css" rel="stylesheet">
    
</head>
<body class="bg-light">
<div class="container-fluid">
<div class="row min-vh-100">
  <?php include 'include/menu.php'; ?>
  <main class="col-md-9 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Gestión de Tareas - Tablero Kanban</h3>
        <button class="btn btn-primary" id="btnNuevaTarea" data-bs-toggle="modal" data-bs-target="#tareaModal">
            <i class="fas fa-plus"></i> Nueva Tarea
        </button>
    </div>
    
    <div class="kanban-board">
        <!-- Columna Backlog -->
        <div class="kanban-column column-backlog">
            <h5>📋 Backlog</h5>
            <div id="backlog-tasks" class="tasks-container">
                <!-- Las tareas se cargarán aquí -->
            </div>
            <button class="btn-nueva-tarea" data-estado="backlog" data-bs-toggle="modal" data-bs-target="#tareaModal">
                + Agregar tarea
            </button>
        </div>
        
        <!-- Columna En Proceso -->
        <div class="kanban-column column-en-proceso">
            <h5>⚡ En Proceso</h5>
            <div id="en-proceso-tasks" class="tasks-container">
                <!-- Las tareas se cargarán aquí -->
            </div>
        </div>
        
        <!-- Columna Completado -->
        <div class="kanban-column column-completado">
            <h5>✅ Completado</h5>
            <div id="completado-tasks" class="tasks-container">
                <!-- Las tareas se cargarán aquí -->
            </div>
        </div>
    </div>
</main>
</div>
</div>

<!-- Modal para crear/editar tarea -->
<div class="modal fade" id="tareaModal" tabindex="-1" aria-labelledby="tareaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formTarea">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tareaModalLabel">Nueva Tarea</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="tareaId" name="tareaId">
            <input type="hidden" id="estadoTarea" name="estado" value="backlog">
            
            <div class="mb-3">
                <label for="titulo" class="form-label">Título de la tarea:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required maxlength="150">
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" maxlength="3000"></textarea>
                <div class="form-text">Máximo 3000 caracteres</div>
            </div>
            
            <div class="mb-3">
                <label for="usuarioAsignado" class="form-label">Asignar a usuario:</label>
                <select class="form-select" id="usuarioAsignado" name="id_usuario">
                    <option value="">Sin asignar</option>
                    <!-- Los usuarios se cargarán aquí -->
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Tarea</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="./javascript/tareas.js"></script>
</body>
</html>
