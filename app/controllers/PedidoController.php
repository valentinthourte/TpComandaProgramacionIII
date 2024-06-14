<?php

require_once("model/Pedido.php");
require_once("AController.php");
require_once("interface/IController.php");
require_once("services/PedidoService.php");


class PedidoController extends AController implements IController {
    private PedidoService $pedidoService;
    public function __construct() {
        $this->pedidoService = new PedidoService();
    }

    public function crearUno($request, $response, $args) {
        $parametros = $request->getParsedBody();
        try {

            $numeroPedido = $this->pedidoService->crearPedido($parametros);
            $content = json_encode(array("mensaje"=>"Pedido creado con éxito.", "NumeroPedido"=>$numeroPedido));

            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
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