<?php

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class MValidacionLogin {
    public function __invoke(Request $request, RequestHandler $handler): Response {
        if ($request->getMethod() === 'POST') {
            $data = json_decode($request->getBody()->getContents(), true);
            if (empty($data)) {
                throw new Exception('Error, No se recibieron datos');
            }

            $errors = $this->validate($data);

            if (!empty($errors)) {
                $response = new Response();
                $response->getBody()->write(json_encode(['errors' => $errors]));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
        }

        return $handler->handle($request);
    }

    private function validate($data): array {
        $errors = [];

        if (count($data) != 2){
            $errors['extraFields'] = 'Numero incorrecto de campos. Se esperan: usuario y clave';
        } 
        else {
            if (empty($data['usuario'])) {
                $errors['usuario'] = 'usuario es requerido';
            }

            if (empty($data['clave'])) {
                $errors['clave'] = 'clave es requerido';
            }
        }

        return $errors;
    }
}