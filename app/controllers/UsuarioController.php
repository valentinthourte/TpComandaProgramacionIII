<?php
require_once("AController.php");
require_once("services/UsuarioService.php");

class UsuarioController extends AController {
    protected UsuarioService $usuarioService;
    public function __construct() {
        $this->usuarioService = new UsuarioService();
    }

    public function crearUno($request, $response, $args) {
        $parametros = $request->getParsedBody();
        $nombre = $parametros['nombreUsuario'];
        $clave = $parametros['clave'];
        $tipoUsuario = $parametros['tipoUsuario'];

        $usuario = new Usuario($nombre, $clave, $tipoUsuario);
        try {
            $id = $this->usuarioService->crearUsuario($usuario);
            $payload = json_encode(array("id"=> $id, "mensaje" => "Usuario creado con exito"));
    
            return $this->setearResponse($response, $payload);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }


    public function logins($request, $response, $args) {
        try {
            $queryParams = $request->getQueryParams();
            $fechaDesde = isset($queryParams['fechaDesde']) ? $queryParams['fechaDesde'] : (new DateTime('-1 week'))->format('Y-m-d H:i:s');
            $fechaHasta = isset($queryParams['fechaHasta']) ? $queryParams['fechaHasta'] : (new DateTime())->format('Y-m-d H:i:s');
    
            $logins = $this->usuarioService->obtenerLogins($fechaDesde, $fechaHasta);
            $content = json_encode($logins);
    
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }

    }
    public function leerTodos($request, $response, $args){
        try {
            $parametros = $request->getParsedBody();
            $tipoUsuario = $parametros["tipoUsuario"] ?? "";
            $soloActivos = empty($parametros['soloActivos']);
            $usuarios = $this->usuarioService->obtenerUsuariosPorTipo($tipoUsuario, $soloActivos);
            $content = json_encode($usuarios);
    
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function leerUno($request, $response, $args){
        try {

            $id = $args["id"];
    
            $usuario = $this->usuarioService->obtenerUsuarioPorId($id);
            $content = json_encode($usuario);
    
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function actualizar($request, $response, $args){
        try {

            $parametros = $request->getParsedBody();
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function darDeBaja($request, $response, $args){
        try {
            $idEliminar = $args["id"];
    
            $mensaje = $this->usuarioService->desactivarUsuario($idEliminar);
            return $this->setearResponse($response, json_encode(array("mensaje"=>$mensaje)));
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
}