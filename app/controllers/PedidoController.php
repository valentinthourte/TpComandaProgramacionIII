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
            $mozoId = $request->getAttribute("usuarioId");
            $numeroPedido = $this->pedidoService->crearPedido($parametros, $mozoId);
            $content = json_encode(array("mensaje"=>"Pedido creado con éxito.", "NumeroPedido"=>$numeroPedido));

            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage() . PHP_EOL . $e->getTraceAsString(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
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
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function tiempoRestantePedido($request, $response, $args) {
        try {
            $parametros = $request->getQueryParams();
            $numeroPedido = $args['numeroPedido'];
            $numeroMesa = $parametros['numeroMesa'];
            $content = json_encode(array("tiempo restante"=>$this->pedidoService->tiempoPorNumeroyMesa($numeroPedido, $numeroMesa)));
            return $this->setearResponse($response, $content);
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
            $numeroPedido = $request->getQueryParams()['numeroPedido'] ?? $args['numeroPedido'];
            $pedido = $this->pedidoService->obtenerPedidoPorNumero($numeroPedido);
            $content = json_encode($pedido);
            return $this->setearResponse($response, $content);
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
            $estado = json_decode($request->getBody()->getContents(),true)['estado'];
            $numeroPedido = $request->getQueryParams()['numeroPedido'] ?? $args['numeroPedido'];
            $pedido = $this->pedidoService->actualizarEstadoPedido($numeroPedido, $estado);
            $content = json_encode($pedido);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
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
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function pedidosPorEstado($request, $response, $args) {
        try {
            $estadoPedido = $request->getQueryParams()['estado'];
            $pedidos = $this->pedidoService->obtenerPedidosPorEstado($estadoPedido);
            $content = json_encode($pedidos);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function agregarImagen($request, $response, $args) {
        try {
            $imagen = $request->getUploadedFiles()['imagen'];
            $mensaje = $this->pedidoService->asociarImagenAPedido($args['numeroPedido'], $imagen);
            $content = json_encode(array("mensaje" => $mensaje));
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }


}