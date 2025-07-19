<?php 
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: ./index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <title>Inicio</title>
</head>
<body>
  <div class="container-fluid">
    <div class="row min-vh-100">
      <?php include 'include/menu.php'; ?>
      <main class="col-md-9 p-4">
    <?php
      echo "<H1 clasa='text-center'>Bienvenido - " . $_SESSION['nombre'] . "</H1>"; 
    ?>
    </main>
    </div>
  </div>
</body>
</html>