<?php
/**
 * API REST de tareas
 */

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Headers: Content-Type, Access-Control-Headers, Authorization, X-Requested-With");

    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    require_once "database.php";
    require_once "./models/tarea.php";

    function enviarRespuesta($codigo_http, $datos = null, $mensaje = "") {
        $respuesta= [];

        if($mensaje){
            $respuesta['mensaje'] = $mensaje;
        }

        if($datos !== null ){
            $respuesta['datos'] = $datos;
            $respuesta['total'] = is_array($datos) ?  count($datos) : 1;
        }

        $respuesta['timestamp'] = date('Y-m-d H:i:s');

        echo json_encode($respuesta , JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit();
    } 

    function obtenerDatosJson() {
        $json = file_get_contents('php://input');
        return json_decode($json, true);
    }

    function obtenerId($uri) {
        $partes = explode('/', trim($uri,'/'));
        $indice_api = array_search('api_tarea', $partes);

        if($indice_api !== false && isset($partes[$indice_api + 2])) {
            return intval($partes[$indice_api + 2]);

        }

        return null;

    }

    try {
        $database = new Database();
        $db = $database->getConnection();

        $tarea = new Tarea($db);

        $metodo = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        $partes_uri = parse_url($uri);
        $ruta = $partes_uri['path'];
        $parametros = [];

        if(isset($partes_uri['query'])){
            parse_str($partes_uri['query'],$parametros);
        }

        $id = obtenerId($ruta);

        switch($metodo){
            case 'GET':
                if($id) {
                    $resultado = $tarea->obtenerPorId($id);

                    if($resultado){
                        enviarRespuesta(200,$resultado,'Tarea Encontrada');
                    }else {
                        enviarRespuesta(400,null,'Tarea no Encontrada');
                    }
                }else {
                    $resultado = $tarea->obtenerTodos();
                    enviarRespuesta(200,$resultado, "Todos las tareas obtenidas");
                }
                break;
            case 'POST':
            // Crear nueva tarea
            $datos = obtenerDatosJson();
            
            if (!$datos) {
                enviarRespuesta(400, null, 'Datos JSON inválidos');
            }
            
            // Asignar datos a la tarea
            $tarea->id_usuario = $datos['id_usuario'] ?? null;
            $tarea->estado = $datos['estado'] ?? '';
            $tarea->titulo = $datos['titulo'] ?? '';
            $tarea->descripcion = $datos['descripcion'] ?? '';
            
            // Validar datos
            $errores = $tarea->validar();
            if (!empty($errores)) {
                enviarRespuesta(400, $errores, 'Errores de validación');
            }
            
            // Crear tarea
            if ($tarea->crear()) {
                $tarea_creada = $tarea->obtenerPorId($tarea->id_tarea);
                enviarRespuesta(201, $tarea_creada, 'Tarea creada exitosamente');
            } else {
                enviarRespuesta(500, null, 'Error al crear la tarea');
            }
            break;
            
        case 'PUT':
            // Actualizar tarea existente
            if (!$id) {
                enviarRespuesta(400, null, 'ID de tarea requerido para actualizar');
            }
            
            $datos = obtenerDatosJson();
            
            if (!$datos) {
                enviarRespuesta(400, null, 'Datos JSON inválidos');
            }
            
            // Verificar que la tarea existe
            $tarea_existente = $tarea->obtenerPorId($id);
            if (!$tarea_existente) {
                enviarRespuesta(404, null, 'Tarea no encontrada');
            }
            
            // Asignar datos a la tarea
            $tarea->id_tarea = $id;
            $tarea->id_usuario = $datos['id_usuario'] ?? $tarea_existente['id_usuario'];
            $tarea->estado = $datos['estado'] ?? $tarea_existente['estado'];
            $tarea->titulo = $datos['titulo'] ?? $tarea_existente['titulo'];
            $tarea->descripcion = $datos['descripcion'] ?? $tarea_existente['descripcion'];
            
            // Validar datos
            $errores = $tarea->validar();
            if (!empty($errores)) {
                enviarRespuesta(400, $errores, 'Errores de validación');
            }
            
            // Actualizar tarea
            if ($tarea->actualizar()) {
                $tarea_actualizada = $tarea->obtenerPorId($id);
                enviarRespuesta(200, $tarea_actualizada, 'Tarea actualizada exitosamente');
            } else {
                enviarRespuesta(500, null, 'Error al actualizar la tarea');
            }
            break;
            
        case 'DELETE':
            // Eliminar tarea
            if (!$id) {
                enviarRespuesta(400, null, 'ID de tarea requerido para eliminar');
            }
            
            // Verificar que la tarea existe
            $tarea_existente = $tarea->obtenerPorId($id);
            if (!$tarea_existente) {
                enviarRespuesta(404, null, 'Tarea no encontrada');
            }
            
            $tarea->id_tarea = $id;
            
            if ($tarea->eliminar()) {
                enviarRespuesta(200, null, 'Tarea eliminada exitosamente');
            } else {
                enviarRespuesta(500, null, 'Error al eliminar la tarea');
            }
            break;
            
        default:
            enviarRespuesta(405, null, 'Método no permitido');
            break;
        }

    }catch (Exception $e) {
        error_log("Error en API " . $e->getMessage());
        enviarRespuesta(500,null,"Error interno del servidor: " . $e->getMessage());
    }

?>