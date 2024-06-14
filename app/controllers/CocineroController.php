<?php

class CocineroController extends UsuarioController implements IController {
    
    public function crearUno($request, $response, $args) {
        $parametros = $request->getParsedBody();
        $nombre = $parametros["nombreUsuario"];
        $clave = $parametros["clave"];

        $cocinero = new Cocinero($nombre, $clave);
        $id = $this->usuarioService->crearUsuario($cocinero);
        return $this->setearResponse($response, $id);
    }
    public function leerTodos($request, $response, $args) {

    }
    public function leerUno($request, $response, $args) {

    }
    public function actualizar($request, $response, $args) {

    }
    public function eliminar($request, $response, $args) {

    }

}