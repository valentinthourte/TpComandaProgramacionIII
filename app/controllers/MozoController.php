<?php

require_once("services/UsuarioService.php");
require_once("model/Mozo.php");
require_once("interface/IController.php");
require_once("UsuarioController.php");
class MozoController extends UsuarioController implements IController {
    public function crearUno($request, $response, $args) {
        $parametros = $request->getParsedBody();
        $nombre = $parametros['nombreUsuario'];
        $clave = $parametros['clave'];

        $usuario = new Mozo($nombre, $clave);
        try {
            $id = $this->usuarioService->crearUsuario($usuario);
            $payload = json_encode(array("id"=> $id, "mensaje" => "Usuario creado con exito"));
    
            return $this->setearResponse($response, $payload);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function leerTodos($request, $response, $args){
        try {

            $usuarios = $this->usuarioService->obtenerUsuariosPorTipo("Mozo");
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
    public function eliminar($request, $response, $args){
        try {
            $idEliminar = $args["id"];
    
            $this->usuarioService->desactivarUsuario($idEliminar);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }


}
