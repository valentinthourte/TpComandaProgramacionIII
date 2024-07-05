<?php

require_once("AController.php");
require_once("services/ComandaService.php");

class ComandaController extends AController   {
    private $comandaService;

    public function __construct() {
        $this->comandaService = new ComandaService();
    }

    public function leerTodos($request, $response, $args) {
        try {
            $comandas = $this->comandaService->leerComandas();
            $content = json_encode($comandas);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function leerUno($request, $response, $args) {
        try {
            $id = $request->getQueryParams()['id'] ?? $args['id'];
            $comanda = $this->comandaService->leerComandaPorId($id);
            $content = json_encode($comanda);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function actualizar($request, $response, $args) {
        try {
            $parametros = $this->bodyParseado($request);
            $numeroPedido = $request->getQueryParams()['numeroPedido'] ?? $args['numeroPedido'];
            $tipoUsuario = $request->getAttribute("tipoUsuario");
            $usuarioId = $request->getAttribute("usuarioId");
            $estado = $parametros['estado'];
            $tiempoEstimado = $parametros['tiempoEstimado'];

            $comanda = $this->comandaService->actualizarEstadoComanda($numeroPedido, $tipoUsuario, $usuarioId, $estado, $tiempoEstimado);
            $content = json_encode($comanda);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function leerPorEstadoTipoUsuario($request, $response, $args) {
        try {
            $estado = $request->getQueryParams()['estado'];
            $tipoUsuario = $request->getAttribute("tipoUsuario");
            $comandas = $this->comandaService->obtenerComandasPorEstadoYTipoUsuario($tipoUsuario, $estado);
            $content = json_encode($comandas);
            return $this->setearResponse($response, $content);             
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function eliminar($request, $response, $args) {
        throw new Exception("ComandaController: No implemenetado");
    }
}
