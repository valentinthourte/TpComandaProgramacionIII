<?php

require_once("AController.php");
require_once("services/PedidoService.php");

class ReportesController extends AController {
    
    private $pedidoService;
    public function __construct() {
        $this->pedidoService = new PedidoService();
    }

    public function pedidosDemorados($request, $response, $args) {
        try {
            $pedidos = $this->pedidoService->obtenerPedidosDemorados();
            $content = json_encode($pedidos);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    
    public function pedidosPorUsuario($request, $response, $args) {
        try {

            $pedidos = $this->pedidoService->obtenerPedidosPorUsuario($args['id']);
            $content = json_encode($pedidos);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function mesaMasUsada($request, $response, $args) {
        try {
            $datos = $this->pedidoService->obtenerMesaMasUsada();
            $content = json_encode($datos);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

}