<?php
  require_once("include/conexion.php");

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['usuarioIndex'];
    $nombre = $_POST['nombre'];
    $fecha_nam = $_POST['fecha_nam'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      echo "Email invalido";
      exit();
    }elseif($password !== $confirm){
      echo "Contraseñas no coinciden";
      exit();
    }else {
      
      $pass_hash = password_hash($password, PASSWORD_DEFAULT);

      if(!empty($id)){
        //update 
        $sql = "UPDATE usuarios 
              SET Nombre = ?, Fecha_Nacimiento = ?, Email = ?" .
              (!empty($password) ? ", Contrasenia= ?" : "") . "
              WHERE Id_usuario = ?";
        $stmt = $mysqli->prepare($sql);
        if(!empty($password)){
          $stmt->bind_param("ssssi",$nombre, $fecha_nam, $email, $pass_hash, $id);
        }else {
          $stmt->bind_param("sssi",$nombre, $fecha_nam, $email, $id);
        } 
        $stmt->execute();
        if($stmt->sqlstate == '00000'){
          echo "Usuario actualizado correctamente";
        }elseif($stmt->sqlstate > 0){
          echo "Advertencia, usuario actualizado con el código de advertencia: " . $stmt->sqlstate;
        }else{
          echo "Error, usuario no actualizado, código de error: " . $stmt->sqlstate;
        }
        $stmt->close();
      }else{
        //insert
        $sql = 'INSERT INTO usuarios (Nombre, Fecha_Nacimiento, Email, Contrasenia) VALUES (?,?,?,?)';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssss',$nombre, $fecha_nam, $email, $pass_hash);
        $stmt->execute();
        if($stmt->sqlstate == '00000'){
          echo "Usuario creado correctamente";
        }elseif($stmt->sqlstate > 0){
          echo "Advertencia, usuario creado con el código de advertencia: " . $stmt->sqlstate;
        }else{
          echo "Error, usuario no se creo, código de error: " . $stmt->sqlstate;
        }
        $stmt->close();
      }
      
    }
    $mysqli->close();
    exit();
  }

  if(isset($_GET['eliminar'])){
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM usuarios WHERE Id_usuario = ?";
    $stmt= $mysqli->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    if($stmt->sqlstate < 0){
        echo "Error, usuario: ".$id." no se elimino, código de error: " . $stmt->sqlstate;
    }else{
        echo "Usuario: ".$id." eliminado correctamente ";
    }
    
    $stmt->close();
    $mysqli->close();
    
    exit();
  }
?>