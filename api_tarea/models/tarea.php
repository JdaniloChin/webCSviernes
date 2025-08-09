<?php
/**
 * Modelo de la tabla tareas, contiene las operaciones CRUD
 */

class Tarea {
    private $conn;
    private $table_name = "tareas";

    public $id_tarea;
    public $id_usuario;
    public $titulo;
    public $descripcion;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtenerTodos(){
        $query = "Select t.id_tarea, u.Nombre, t.titulo, t.descripcion, t.estado
                FROM " . $this->table_name . " t 
            LEFT JOIN usuarios u ON t.id_usuario = u.Id_usuario";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId($id){
        $query = "Select t.id_tarea, u.Nombre, t.titulo, t.descripcion, t.estado
                FROM " . $this->table_name . " t 
            LEFT JOIN usuarios u ON t.id_usuario = u.Id_usuario
            WHERE t.id_tarea = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function crear() {
        $query = "INSERT INTO " .$this->table_name ." 
        (id_usuario, estado, titulo, descripcion)
        VALUES (:id_usuario, :estado, :titulo, :descripcion)";

        $stmt = $this->conn->prepare($query);

        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        $stmt->bindParam(":id_usuario", $this->id_usuario);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":descripcion", $this->descripcion);

        if($stmt->execute()){
            $this->id_tarea = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function actualizar() {
        $query = "UPDATE " .$this->table_name ." 
        SET id_usuario = :id_usuario,
         estado =  :estado, 
         titulo = :titulo, 
         descripcion = :descripcion
        WHERE id_tarea = :id_tarea";

        $stmt = $this->conn->prepare($query);

        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->id_tarea = htmlspecialchars(strip_tags($this->id_tarea));

        $stmt->bindParam(":id_usuario", $this->id_usuario);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":id_tarea", $this->id_tarea);

        return $stmt->execute();
    }

    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_tarea = :id_tarea";
        $stmt = $this->conn->prepare($query);
        $this->id_tarea = htmlspecialchars(strip_tags($this->id_tarea));
        $stmt->bindParam(":id_tarea", $this->id_tarea);
        return $stmt->execute();
    }

    public function validar() {
        $errors = [];

        if(empty($this->titulo)){
            $errors[] = "El titulo es requerido";
        }elseif(strlen($this->titulo) > 150){
             $errors[] = "El titulo no puede exceder 150 caracteres";
        }

        if(empty($this->estado)){
            $errors[] = "El estado es requerido";
        }elseif(!in_array($this->estado, ['pendiente','en_proceso', 'completado','cancelada'])){
             $errors[] = "El estado es invalido. Valores permitidos: pendiente, en_proceso, completado, cancelada";
        }

        if(!empty($this->descripcion) && strlen($this->descripcion) > 3000){
            $errors[] = "La descripcion no puede exceder 3000 caracteres";
        }

        if(!empty($this->id_usuario) && !is_numeric($this->id_usuario)){
            $errors[] = "El ID de usuario debe ser numerico";
        }

        return $errors;
    }
}
?>