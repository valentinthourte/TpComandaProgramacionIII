<?php

require_once("model/Pedido.php");
require_once("AController.php");
require_once("services/PedidoService.php");


class PedidoController extends AController {
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
            return $this->setearResponseError($response, $e->getMessage() . PHP_EOL . $e->getTraceAsString(), 400);
        }
    }
    public function leerTodos($request, $response, $args) {
        try {
            $estado = $request->getQueryParams()['estado'];
            $pedidos = $this->pedidoService->leerPedidos($estado);
            $content = json_encode($pedidos);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function leerUno($request, $response, $args) {
        
    }
    public function actualizar($request, $response, $args) {
        try {
            $estado = json_decode($request->getBody()->getContents(),true)['estado'];
            $numeroPedido = $request->getQueryParams()['numeroPedido'] ?? $args['numeroPedido'];
            $pedido = $this->pedidoService->actualizarEstadoPedido($numeroPedido, $estado);
            $content = json_encode(array("Pedido actualizado" => $pedido));
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function pdfPorFecha($request, $response, $args) {
        try {
            $queryParams = $request->getQueryParams();
            $fechaDesde = isset($queryParams['fechaDesde']) ? $queryParams['fechaDesde'] : (new DateTime('-1 week'));
            $fechaHasta = isset($queryParams['fechaHasta']) ? $queryParams['fechaHasta'] : (new DateTime());
            $fechaDesdeString = $fechaDesde->format('Y-m-d H:i:s');
            $fechaHastaString = $fechaHasta->format('Y-m-d H:i:s');
            
            $nombreArchivo = str_replace(" ", "", 'pedidos_desde' . $fechaDesde->format("Y-m-d") . "_hasta_" . $fechaHasta->format("Y-m-d") . '.pdf'); // genero nombre de archivo y le saco espacios
            echo $nombreArchivo . PHP_EOL;
            $output = $this->pedidoService->exportarPdfPorFecha($fechaDesdeString, $fechaHastaString);
            return $this->setearResponse($response, $output, 'application/pdf')
            ->withHeader('Content-Description', 'File Transfer')
            ->withHeader('Content-Disposition', 'attachment; filename=' . $nombreArchivo)
            ->withHeader('Expires', '0')
            ->withHeader('Cache-Control', 'must-revalidate')
            ->withHeader('Pragma', 'public');
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function eliminar($request, $response, $args) {

    }

}