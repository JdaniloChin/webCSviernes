<?php
require_once("include/conexion.php");

$sql = "SELECT Id_usuario, Nombre FROM usuarios ORDER BY Nombre";
$resultado = $mysqli->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo '<option value="' . $row['Id_usuario'] . '">' . htmlspecialchars($row['Nombre']) . '</option>';
    }
}

$mysqli->close();
?>
