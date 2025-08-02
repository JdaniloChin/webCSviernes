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
    <title>Consumo de API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
<div class="container-fluid">
<div class="row min-vh-100">
  <?php include 'include/menu.php'; ?>
  <main class="col-md-9 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Consumo de API</h3>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>API de Ejemplo</h5>
                </div>
                <div class="card-body">
                    <p>Aquí puedes agregar el consumo de APIs externas.</p>
                    <button class="btn btn-primary" id="btnConsumir">Consumir API</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Resultados</h5>
                </div>
                <div class="card-body" id="resultados">
                    <p class="text-muted">Los resultados aparecerán aquí...</p>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>

<script src="./javascript/consumo_pokeApi.js"></script>
</body>
</html>
