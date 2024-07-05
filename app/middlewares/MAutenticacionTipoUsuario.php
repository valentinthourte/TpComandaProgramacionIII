<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;

require_once("jwt/JWTHelper.php");
require_once("enums/TipoUsuario.php");

class MAutenticacionTipoUsuario {
    private $tipos;

    public function __construct($tipos) {
        $this->tipos = $tipos;
    }

    public function __invoke($request, $handler): Response {
        try {
            $token = $this->obtenerToken($request);
            JWTHelper::verificarToken($token);
            if ($this->tipoUsuarioEsValido($token)) {
                $datos = $this->obtenerTipoUsuarioYUsuarioId($token);
                $request = $request->withAttribute('tipoUsuario', $datos['tipoUsuario']);
                $request = $request->withAttribute('usuarioId', $datos['usuarioId']);
            }
            else {
                throw new Exception("Tipo de usuario no valido");
            }
            $response = $handler->handle($request);
            return $response->withHeader('Content-Type', 'application/json');
        }
        catch (Exception $ex) {
            throw new Exception("Se produjo un error: " . $ex->getMessage());
        }
    }

    private function obtenerToken(Request $request): string {
        $header = $request->getHeaderLine('Authorization');

        if (!$header) {
            throw new Exception('No se recibio el token');
        }

        $partes = explode("Bearer", $header);
        if (count($partes) < 2) {
            throw new Exception('Formato de token invalido');
        }

        return trim($partes[1]);
    }

    private function obtenerTipoUsuarioYUsuarioId($token) {
        $data = JWTHelper::obtenerData($token);
        $tipoUsuario = $data->tipoUsuario;
        $usuarioId = $data->usuarioId;

        try {
            $tipo = TipoUsuario::from($tipoUsuario);
            return array("tipoUsuario"=>$tipo, "usuarioId"=>$usuarioId);
        }
        catch (ValueError $ex) {
            throw new Exception("El tipo de usuario ingresado no existe");
        }
    }

    private function tipoUsuarioEsValido($token) {
        try {

            $datos = $this->obtenerTipoUsuarioYUsuarioId($token);
            $tipo = $datos['tipoUsuario'];
            return in_array($tipo->getNombre(), $this->tipos);
        }
        catch (ValueError $ex) {
            return false;
        }
    }

}