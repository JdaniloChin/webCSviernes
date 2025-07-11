<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: ../index.php");
    exit();
}else {
  require_once("include/conexion.php");

  //CRUD de usuarios

  //Read->Select de todos los usuarios
  $usuarios_data = [];
  $resultado =  $stmt = $mysqli->query("SELECT Id_usuario,Nombre, Fecha_Nacimiento, Email FROM usuarios");
  if($resultado && $resultado->num_rows > 0){
    while($row = $resultado->fetch_assoc()){
      $usuarios_data[] = $row;
    }
  }
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
             <?php foreach ($usuarios_data as $usuario): ?>
             <tr>
                <td><?= htmlspecialchars($usuario['Nombre'])?></td>
                <td><?= htmlspecialchars($usuario['Fecha_Nacimiento'])?></td>
                <td><?= htmlspecialchars($usuario['Email'])?></td>
                <td>
                  <a href="?editar=<?= $usuario['Id_usuario'] ?>" class="btn btn-warning btn-sm">Editar</a>
                  <a href="?eliminar=<?= $usuario['Id_usuario'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este usuario?')">Eliminar</a>
                </td>
             </tr>
             <?php endforeach; ?>
        </tbody>
    </table>
</main>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formUsuario">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="usuarioModalLabel">Agregar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="usuarioIndex">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" required>
            </div>
            <div class="mb-3">
                <label for="fecha_nam" class="form-label">Fecha nacimiento:</label>
                <input type="date" class="form-control" id="fecha_nam" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico:</label>
                <input type="email" class="form-control" id="email" required>
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
</body>
</html>