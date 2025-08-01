<?php
session_start();
require_once("include/conexion.php");

// Verificar que el usuario esté logueado
if (!isset($_SESSION['nombre'])) {
    echo "Error: Usuario no autenticado";
    exit();
}

// Procesar diferentes acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? 'crear_actualizar';
    
    switch($accion) {
        case 'eliminar':
            $id = $_POST['tareaId'];
            $sql = "DELETE FROM tareas WHERE id_tarea = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                echo "Tarea eliminada correctamente";
            } else {
                echo "Error al eliminar la tarea";
            }
            
            $stmt->close();
            break;
            
        case 'cambiar_estado':
            $id = $_POST['tareaId'];
            $estado = $_POST['estado'];
            
            $sql = "UPDATE tareas SET estado = ? WHERE id_tarea = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("si", $estado, $id);
            
            if ($stmt->execute()) {
                echo "Estado de la tarea actualizado correctamente";
            } else {
                echo "Error al actualizar el estado de la tarea";
            }
            
            $stmt->close();
            break;
            
        case 'crear_actualizar':
        default:
            $id = $_POST['tareaId'] ?? '';
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'] ?? '';
            $estado = $_POST['estado'];
            $id_usuario = $_POST['id_usuario'] ?? null;
            
            // Validaciones
            if (empty($titulo)) {
                echo "El título es requerido";
                exit();
            }
            
            if (strlen($titulo) > 150) {
                echo "El título no puede exceder 150 caracteres";
                exit();
            }
            
            if (strlen($descripcion) > 3000) {
                echo "La descripción no puede exceder 3000 caracteres";
                exit();
            }
            
            if (!in_array($estado, ['backlog', 'en-proceso', 'completado'])) {
                echo "Estado inválido";
                exit();
            }
            
            // Convertir string vacío a null para id_usuario
            if ($id_usuario === '') {
                $id_usuario = null;
            }
            
            if (!empty($id)) {
                // Actualizar tarea existente
                $sql = "UPDATE tareas SET titulo = ?, descripcion = ?, estado = ?, id_usuario = ? WHERE id_tarea = ?";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sssii", $titulo, $descripcion, $estado, $id_usuario, $id);
                
                if ($stmt->execute()) {
                    echo "Tarea actualizada correctamente";
                } else {
                    echo "Error al actualizar la tarea";
                }
            } else {
                // Crear nueva tarea
                $sql = "INSERT INTO tareas (titulo, descripcion, estado, id_usuario) VALUES (?, ?, ?, ?)";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sssi", $titulo, $descripcion, $estado, $id_usuario);
                
                if ($stmt->execute()) {
                    echo "Tarea creada correctamente";
                } else {
                    echo "Error al crear la tarea";
                }
            }
            
            $stmt->close();
            break;
    }
    
    $mysqli->close();
}
?>
