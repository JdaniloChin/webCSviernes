<?php
require_once("include/conexion.php");

$sql = "SELECT t.id_tarea, t.titulo, t.descripcion, t.estado, t.id_usuario, u.Nombre as usuario_nombre 
        FROM tareas t 
        LEFT JOIN usuarios u ON t.id_usuario = u.Id_usuario 
        ORDER BY t.id_tarea DESC";

$resultado = $mysqli->query($sql);
$tareas = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $tareas[] = $row;
    }
}

$mysqli->close();
echo json_encode($tareas);
?>
