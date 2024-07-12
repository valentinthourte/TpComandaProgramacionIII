<?php

require_once("AController.php");
require_once("services/MesaService.php");

class MesaController extends AController {

    private MesaService $mesaService;
    public function __construct() {
        $this->mesaService = new MesaService();
    }
    public function crearUno($request, $response, $args) {
        try {
            $id = $this->mesaService->crearMesa();
            $payload = json_encode(array("numeroMesa"=> $id, "mensaje" => "Mesa creada con exito"));
    
            return $this->setearResponse($response, $payload);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function leerTodos($request, $response, $args) {

        try {
            $payload = json_encode($this->mesaService->leerMesas()); 
            return $this->setearResponse($response, $payload);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }

    }

    public function leerUno($request, $response, $args) {
        try {
            $numeroMesa = $request->getQueryParams()['numeroMesa'] ?? $args['numeroMesa'];
            $payload = json_encode($this->mesaService->leerMesaPorNumero($numeroMesa)); 
            return $this->setearResponse($response, $payload);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function actualizar($request, $response, $args) {
        try {
            $numeroMesa = $request->getQueryParams()['numeroMesa'] ?? $args['numeroMesa'];
            $estado = $request->getParsedBody()['estado'];
            $tipoUsuario = $request->getAttribute("tipoUsuario");
            $payload = json_encode($this->mesaService->actualizarMesa($numeroMesa, $estado, $tipoUsuario)); 
            return $this->setearResponse($response, $payload);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function eliminar($request, $response, $args) {
        try {
            $numeroMesa = $request->getQueryParams()['numeroMesa'] ?? $args['numeroMesa'];
            
            $payload = json_encode(array("mensaje"=>$this->mesaService->eliminarMesa($numeroMesa))); 
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