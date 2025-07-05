<?php
session_start();
require_once("include/conexion.php");

if($_SERVER['REQUEST_METHOD']== "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    //validar datos
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $mensaje = "Correo invalido";
    }else {
        //buscar si el correo existe en la base de datos
        $stmt = $mysqli->prepare("SELECT Nombre, Contrasenia FROM usuarios WHERE email = ?");
        $stmt->bind_param("s",$email);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if(password_verify($password, $usuario['Contrasenia'])){
                $_SESSION['nombre'] = $usuario['Nombre'];
                $_SESSION['email'] = $email;
                header("Location: home.php");
                exit();
            }else{
                $mensaje = "Contraseña incorrecta";
            }
        }else {
            $mensaje = "Email no registrado.";
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
    <title>Inicio Sesión</title>
</head>
<body class="bg-light">
    <main>
       <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-lg w-100" style="max-width: 400px">
            <h3 class="card-title text-center mb-4">Inicio de sesión</h3>
            <div class="card-body">
            <form id="loginform" method="post">
            <div class="mb-3">
                <label class="form-label" for="email">Usuario</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Contraseña:</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
            <p class="text-center mt-3">Si no tiene cuenta <a href="register.php">Registrarse aquí.</a></p>
        </form>
        </div>
        </div>
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>
       </div> 
    </main>
    <footer class="text-center mt-3">
        Desarrollado por: Jose Danilo Chinchilla
    </footer>
</body>
</html>