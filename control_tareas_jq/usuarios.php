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
    <title>CRUD Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
<div class="container-fluid">
<div class="row min-vh-100">
  <?php include 'include/menu.php'; ?>
  <main class="col-md-9 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
          <h3>Usuarios del sistema</h3>
          <button class="btn btn-success mb-3" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#usuarioModal">Agregar Usuario</button>
    </div>
    <table class="table table-bordered table-striped" id="tablaUsuarios">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Fecha Nacimiento</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se agregan los usuarios dinámicamente -->
        </tbody>
    </table>
</main>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formUsuario" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="usuarioModalLabel">Agregar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="usuarioIndex" name="usuarioIndex">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name='nombre' required>
            </div>
            <div class="mb-3">
                <label for="fecha_nam" class="form-label">Fecha nacimiento:</label>
                <input type="date" class="form-control" id="fecha_nam"  name="fecha_nam" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                    <label class="form-label" for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                    <label class="form-label" for="confirm">Confirmar contraseña:</label>
                    <input type="password" class="form-control" id="confirm" name="confirm" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="./javascript/usuarios.js"></script>
</body>
</html>