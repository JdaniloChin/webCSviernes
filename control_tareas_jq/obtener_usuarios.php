<?php
  require_once("include/conexion.php");

  //CRUD de usuarios

  //Read->Select de todos los usuarios
  
  $resultado =  $stmt = $mysqli->query("SELECT Id_usuario,Nombre, Fecha_Nacimiento, Email FROM usuarios");
  if($resultado && $resultado->num_rows > 0){
    while($usuario = $resultado->fetch_assoc()){
      echo "<tr>
                <td>" . htmlspecialchars($usuario['Nombre']) . "</td>
                <td>" . htmlspecialchars($usuario['Fecha_Nacimiento']) . "</td>
                <td>" . htmlspecialchars($usuario['Email']) . "</td>
                <td>
                  <a href='#'
                  data-id='{$usuario['Id_usuario']}'
                  data-nombre='{$usuario['Nombre']}'
                  data-fecha='{$usuario['Fecha_Nacimiento']}'
                  data-email='{$usuario['Email']}' 
                  data-bs-toggle='modal'
                  data-bs-target='#usuarioModal'
                  class='btn btn-warning btn-sm btnEditar'>Editar</a>
                  <a href='#' data-id='{$usuario['Id_usuario']}' class='btn btn-danger btn-sm btnEliminar'>Eliminar</a>
                </td>
             </tr>";
    }
  }
  $stmt->close();
  $mysqli->close();
?>