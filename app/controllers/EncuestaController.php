<?php

require_once("AController.php");
require_once("services/EncuestaService.php");


class EncuestaController extends AController {
    
    private EncuestaService $encuestaService;
    public function __construct() {
        $this->encuestaService = new EncuestaService();
    }

    public function leerEncuestas($request, $response, $args) {
        try {
            $payload = json_encode($this->encuestaService->leerEncuestas()); 
            return $this->setearResponse($response, $payload);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function crearEncuesta($request, $response, $args) {
        try {
            $parametros = $request->getParsedBody();
            $payload = json_encode($this->encuestaService->crearEncuesta($parametros)); 
            return $this->setearResponse($response, $payload);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }




}