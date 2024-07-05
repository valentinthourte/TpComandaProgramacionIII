<?php

abstract class AController {
    protected function setearResponse($response, $content, $contentType = 'application/json') {
        $response->getBody()->write($content);
        return $response
            ->withHeader('Content-Type', $contentType);
    }
    protected function setearResponseError($response, $mensajeError, $codigo) {
        $content = json_encode(array("statusCode"=>$codigo, "error"=>$mensajeError));
        return $this->setearResponse($response, $content);
    }
    protected function bodyParseado($request) {
        return json_decode($request->getBody()->getContents(),true);
    }
}