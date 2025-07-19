<?php
    session_start();
    require_once("include/conexion.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $nombre = $_POST['nombre'];
        $fecha_nam = $_POST['fecha_nam'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];

        //Validar datos
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            echo "<div class='alert alert-danger'>Correo invalido</div>";
        }elseif($password !== $confirm){
            echo "<div class='alert alert-danger'>Contraseñas no coinciden</div>";
        }else {

            $stmt = $mysqli->prepare("INSERT INTO usuarios (Nombre,Email,Fecha_Nacimiento,Contrasenia) VALUES(?,?,?,?)");

            $hash_pass = password_hash($password,PASSWORD_DEFAULT);

            //s = string / i=integer / d=double-decimal / b=blob (binario)
            $stmt->bind_param("ssss",$nombre,$email,$fecha_nam,$hash_pass);
            $stmt->execute();

            if($stmt->sqlstate ==  '00000'){
                echo "<div class='alert alert-success'>Usuario creado correctamente</div>";
            }elseif($stmt->sqlstate > 0) {
                echo "<div class='alert alert-warning'>Advertencia, usuario creado correctamente, código de advertencia: ". $stmt->sqlstate ."</div>";
            }else {
                echo "<div class='alert alert-danger'>Error, usuario no creado, código de error: ".$stmt->sqlstate."</div>";
            }
            $stmt->close();
            $mysqli->close();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <title>Registro Usuario</title>
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-lg w-100" style="max-width: 600px">
         <div class=card-header>
            <h3 class="card-title">Registro Usuario</h3>
         </div>   
         <div class="card-body">
            <form id="registro" method="post">
                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="fecha_nam">Fecha nacimiento:</label>
                    <input type="date" class="form-control" id="fecha_nam" name="fecha_nam" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Correo electronico:</label>
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
                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                <p class="text-center mt-3">Si ya se encuentra registrado <a href="index.php">Iniciar Sesión aquí</a></p>
            </form>
         </div>   
        </div>
    </div>    
</body>
</html>