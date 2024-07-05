<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as SlimResponse;

require_once("jwt/JWTHelper.php");
class MValidacionToken {
    public function __invoke(Request $request, RequestHandler $handler): Response {
        try {
            $token = $this->obtenerToken($request);
            JWTHelper::VerificarToken($token); 
            $response = $handler->handle($request);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    private function obtenerToken(Request $request): string {
        $header = $request->getHeaderLine('Authorization');

        if (!$header) {
            throw new Exception('No se recibió el token');
        }

        $partes = explode("Bearer", $header);
        if (count($partes) < 2) {
            throw new Exception('Formato de token inválido');
        }

        return trim($partes[1]);
    }

    private function errorResponse($mensaje) {
        $response = new SlimResponse();
        $response->getBody()->write(json_encode(array("error"=>"Token invalido: " . $mensaje)));
        return $response->withStatus(401, "Unauthorized")->withHeader("Content-Type", "application/json");
    }
}